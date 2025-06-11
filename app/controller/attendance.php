<?php
require_once '../app/core/database.php';
// Required for SweetAlert2 session-based popups

date_default_timezone_set('Asia/Manila');

$db = new Database();
$pdo = $db->getConnection();
$pdo->exec("SET time_zone = '+08:00'");

if (isset($_GET['payroll']) && $_GET['payroll'] === 'attendance') {
    try {
        $filterDate = $_GET['date'] ?? date('Y-m-d');
        $query = "
            SELECT 
                e.photo_path,
                e.employee_no,
                CONCAT(e.first_name, ' ', LEFT(e.middle_name, 1), '. ', e.last_name) AS full_name,
                e.position,
                a.time_in,
                a.time_out,
                a.date
            FROM attendance a
            INNER JOIN employees e ON a.employee_id = e.id
            WHERE DATE(a.date) = :filterDate
            ORDER BY 
                CASE WHEN a.time_out IS NOT NULL THEN 0 ELSE 1 END,
                a.time_out DESC,
                a.time_in DESC
";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':filterDate', $filterDate);
        $stmt->execute();
        $attendanceRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        $attendanceRecords = [];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    try {
        $rfid = $_POST['rfid'] ?? null;
        $employee_id_manual = $_POST['employee_id'] ?? null;
        $manual_type = $_POST['manual_type'] ?? null;

        if ($rfid) {
            $stmt = $pdo->prepare("SELECT * FROM employees WHERE rfid_number = ?");
            $stmt->execute([$rfid]);
        } elseif ($employee_id_manual && $manual_type) {
            $stmt = $pdo->prepare("SELECT * FROM employees WHERE employee_no = ?");
            $stmt->execute([$employee_id_manual]);
        } else {
            echo json_encode(["status" => "error", "message" => "RFID or Employee ID with manual type is required."]);
            exit;
        }

        $employee = $stmt->fetch();
        if (!$employee) {
            echo json_encode(["status" => "error", "message" => "Employee not found."]);
            exit;
        }

        $employee_id = $employee['id'];
        $middle_initial = !empty($employee['middle_name']) ? strtoupper($employee['middle_name'][0]) . '. ' : '';
        $name = $employee['first_name'] . ' ' . $middle_initial . $employee['last_name'];
        $image_path = $employee['photo_path'] ?? 'assets/image/default_user_image.svg';
        $today = date('Y-m-d');
        $now = date('Y-m-d H:i:s');
        $nowDT = new DateTime($now);

        $stmt = $pdo->prepare("SELECT * FROM attendance WHERE employee_id = ? AND date = ?");
        $stmt->execute([$employee_id, $today]);
        $attendance = $stmt->fetch();

        $schedStmt = $pdo->prepare("
            SELECT s.* FROM schedules s
            JOIN employee_schedules es ON es.schedule_id = s.id
            WHERE es.employee_id = ?
        ");
        $schedStmt->execute([$employee_id]);
        $schedule = $schedStmt->fetch();

        if (!$schedule) {
            echo json_encode([
                'status' => 'error',
                'message' => 'No schedule found. Please contact your manager or admin.'
            ]);
            exit;
        }

        $grace_period = $schedule['grace_period'] ?? 0;
        $time_in_sched = new DateTime($today . ' ' . $schedule['time_in']);
        $time_out_sched = new DateTime($today . ' ' . $schedule['time_out']);

        $type = "";
        $log_status = "on time";

        if ($manual_type === 'time-in') {
            $type = "time-in";
            if ($nowDT > (clone $time_in_sched)->modify("+$grace_period minutes")) {
                $log_status = "late";
            }

            if (!$attendance) {
                $stmt = $pdo->prepare("INSERT INTO attendance (employee_id, time_in, date) VALUES (?, ?, ?)");
                $stmt->execute([$employee_id, $now, $today]);
            } elseif ($attendance['time_in'] && !$attendance['time_out']) {
                echo json_encode([
                    "status" => "info",
                    "message" => "You have already timed in today.",
                    "employee_id" => $employee_id,
                    "name" => $name,
                    "date" => $today
                ]);
                exit;
            } else {
                echo json_encode([
                    "status" => "info",
                    "message" => "Attendance for today is already complete.",
                    "employee_id" => $employee_id,
                    "name" => $name,
                    "date" => $today
                ]);
                exit;
            }

        } elseif ($manual_type === 'time-out') {
            $type = "time-out";

            if ($attendance && $attendance['time_in'] && !$attendance['time_out']) {
                $time_in_dt = new DateTime($attendance['time_in']);
                $lockout_until = (clone $time_in_dt)->modify('+15 minutes');

                if ($nowDT < $lockout_until) {
                    echo json_encode([
                        "status" => "info",
                        "message" => "Please wait 15 minutes after timing in before you can time out.",
                        "lockout_until" => $lockout_until->format('Y-m-d H:i:s'),
                        "employee_id" => $employee_id,
                        "name" => $name,
                        "date" => $today
                    ]);
                    exit;
                }

                if ($nowDT < $time_out_sched) {
                    $log_status = "early out";
                }

                $stmt = $pdo->prepare("UPDATE attendance SET time_out = ? WHERE id = ?");
                $stmt->execute([$now, $attendance['id']]);

            } else {
                echo json_encode([
                    "status" => "info",
                    "message" => "You have not timed in yet or already timed out.",
                    "employee_id" => $employee_id,
                    "name" => $name,
                    "date" => $today
                ]);
                exit;
            }

        } elseif ($rfid) {
            if (!$attendance) {
                $type = "time-in";
                if ($nowDT > (clone $time_in_sched)->modify("+$grace_period minutes")) {
                    $log_status = "late";
                }
                $stmt = $pdo->prepare("INSERT INTO attendance (employee_id, time_in, date) VALUES (?, ?, ?)");
                $stmt->execute([$employee_id, $now, $today]);
            } elseif ($attendance['time_in'] && !$attendance['time_out']) {
                $time_in_dt = new DateTime($attendance['time_in']);
                $lockout_until = (clone $time_in_dt)->modify('+15 minutes');

                if ($nowDT < $lockout_until) {
                    echo json_encode([
                        "status" => "info",
                        "message" => "Standby",
                        "message" => "Please wait 15 minutes after timing in before you can time out.",
                        "lockout_until" => $lockout_until->format('Y-m-d H:i:s'),
                        "employee_id" => $employee_id,
                        "name" => $name,
                        "date" => $today
                    ]);
                    exit;
                }

                $type = "time-out";
                if ($nowDT < $time_out_sched) {
                    $log_status = "early out";
                }
                $stmt = $pdo->prepare("UPDATE attendance SET time_out = ? WHERE id = ?");
                $stmt->execute([$now, $attendance['id']]);
            } else {
                echo json_encode([
                    "status" => "info",
                    "message" => "Attendance for today is already complete.",
                    "employee_id" => $employee_id,
                    "name" => $name,
                    "date" => $today
                ]);
                exit;
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid attendance request."]);
            exit;
        }

        // SweetAlert2 Session Setup
        $_SESSION['attendance_popup'] = [
            'alert_message' => $type === "time-in"
                ? "Time In successfully recorded for $name."
                : "Time Out successfully recorded for $name.",
            'attendance_message' => $type === "time-in"
                ? "You have Time In at " . date("h:i A", strtotime($now)) . "."
                : "You have Time Out at " . date("h:i A", strtotime($now)) . ".",
            'alert_type' => 'success',
            'image_url' => $image_path,
            'attendance_action' => strtoupper($type),
            'popup_border_color' => $type === 'time-in' ? "rgb(76, 180, 76)" : "rgb(255, 119, 119)"
        ];

        echo json_encode([
            "status" => "success",
            "message" => "Successfully logged $type.",
            "employee_id" => $employee_id,
            "image_url" => 'http://localhost/mvcPayroll/public/' . $image_path,
            "name" => $name,
            "timestamp" => $now,
            "type" => $type,
            "log_status" => $log_status,
            "schedule" => [
                "time_in" => $schedule['time_in'],
                "time_out" => $schedule['time_out'],
                "grace_period" => $schedule['grace_period']
            ]
        ]);
        exit;

    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
        exit;
    }
}

// For GET requests: Render the attendance view
$current_time = date("h:i:s A");
$current_date = date("F j, Y");
require views_path("auth/attendance");
