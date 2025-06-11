<?php
// $admin_id = $_SESSION['admin_id'] ?? null;

// if (!$admin_id) {
//     // If it's an API request, return JSON
//     if (isset($_GET['id'])) {
//         header('Content-Type: application/json');
//         echo json_encode(['error' => 'Unauthorized admin access']);
//         exit;
//     } else {
//         // Show custom 403 page for browser access
//         http_response_code(403);
//          require_once '../app/Error/unauthorized.php'; // Adjust the path
//         exit;
//     }
// }


// require_once '../app/core/database.php'; // Include your database class

// $db = new Database();
// $conn = $db->getConnection();

// // Get logged-in admin from session
// $adminId = $_SESSION['SESSION_USER_ID'] ?? null;
// $adminName = $_SESSION['USERNAME'] ?? 'Unknown';

// if (!$adminId) {
//     die("Admin not logged in.");
// }

// // You may still fetch full admin details if needed
// $admin = [
//     'id' => $adminId,
//     'name' => $adminName
// ];


// // Fetch full admin data
// $stmt = $conn->prepare("SELECT id, name FROM admins WHERE id = :id");
// $stmt->execute([':id' => $adminId]);
// $admin = $stmt->fetch(PDO::FETCH_ASSOC);

// if (!$admin) {
//     die("Admin not found.");
// }


// function computeAndInsertPayroll($conn, $employee, $payPeriodStart, $payPeriodEnd, $frequency = 'monthly', $adminId = null) {
//     $baseSalary = $employee['basic'];
//     $hourlyRate = $baseSalary / 8;
//     $totalHours = $employee['total_hours'];

//     // Derived
//     $totalDays = $totalHours / 8;
//     $grossPay = $baseSalary * $totalDays;

//     // Simulated values
//     $totalMinsLate = 60; // simulate 1 hr late total
//     $absentDays = 1;     // simulate 1 absence

//     $lateDeduction = ($totalMinsLate / 60) * $hourlyRate;
//     $benefitsDeduction = 0.15 * $grossPay;
//     $absenceDeduction = $baseSalary * $absentDays;

//     $totalDeduction = $lateDeduction + $benefitsDeduction + $absenceDeduction;
//     $netPay = $grossPay - $totalDeduction;

//     // Payroll duration in days
//     $duration = (new DateTime($payPeriodStart))->diff(new DateTime($payPeriodEnd))->days + 1;

//     // Insert into payroll table
//     $sql = "INSERT INTO payroll (
//                 employee_id,
//                 pay_period_start,
//                 pay_period_end,
//                 payroll_frequency,
//                 payroll_duration,
//                 total_hours,
//                 deductions,
//                 gross_pay,
//                 net_pay,
//                 generated_by
//             ) VALUES (
//                 :employee_no,
//                 :start_date,
//                 :end_date,
//                 :frequency,
//                 :duration,
//                 :total_hours,
//                 :deductions,
//                 :gross_pay,
//                 :net_pay,
//                 :admin_id
//             )";

//     $stmt = $conn->prepare($sql);
//     $stmt->execute([
//         ':employee_no' => $employee['employee_no'],
//         ':start_date' => $payPeriodStart,
//         ':end_date' => $payPeriodEnd,
//         ':frequency' => $frequency,
//         ':duration' => $duration,
//         ':total_hours' => $totalHours,
//         ':deductions' => round($totalDeduction, 2),
//         ':gross_pay' => round($grossPay, 2),
//         ':net_pay' => round($netPay, 2),
//         ':admin_id' => $adminId
//     ]);

//     echo "✅ Payroll computed and inserted for <strong>{$employee['name']}</strong> (Employee ID: EMP{$employee['id']})<br>";
// }


// // Example employee data
// $employees = [
//     ["id" => 1, "name" => "John Doe", "basic" => 600, "total_hours" => 250],
//     ["id" => 2, "name" => "Jane Smith", "basic" => 600, "total_hours" => 200],
//     ["id" => 3, "name" => "Mike Johnson", "basic" => 600, "total_hours" => 100],
// ];


// // Set pay period
// $payPeriodStart = '2025-05-01';
// $payPeriodEnd = '2025-05-15';

// // Insert payrolls
// foreach ($employees as $employee) {
//     computeAndInsertPayroll($conn, $employee, $payPeriodStart, $payPeriodEnd, 'biweekly', $admin['id']);
// }

// // ✅ Load the view if needed
// if (function_exists('views_path')) {
//     require views_path("auth/payroll");
// } else {
//     echo "<br><em>Payroll view not loaded. Make sure views_path() is defined.</em>";
// }

require views_path("auth/payroll");
