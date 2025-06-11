<?php
$title = "Daily Time Record";
require_once views_path("partials/header");
require_once "../app/core/database.php";

$employee_id = $_SESSION['employee_id'] ?? null;

if (!$employee_id) {
    // If API request (e.g. ?id=...), return JSON error
    if (isset($_GET['id'])) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Unauthorized']);
        exit;
    } else {
        // For normal page request, show custom 403 page
        http_response_code(403);  // Set HTTP status 403 Forbidden
        require_once '../app/Error/unauthorized.php';  // adjust path accordingly
        exit;
    }
}

// Simulate logged in employee_id
$employeeId = $_SESSION['employee_id'] ?? 1;

if (!$employeeId) {
    echo "<script>alert('Employee not logged in.');</script>";
    exit;
}

$db = (new Database)->getConnection();

$currentPage = $_GET['payroll'] ?? 'user_dashboard';

echo '<script src="../public/assets/js/sweetalert2/sweetalert2.all.min.js"></script>';

$months = [
    '01' => 'January', '02' => 'February', '03' => 'March',
    '04' => 'April', '05' => 'May', '06' => 'June',
    '07' => 'July', '08' => 'August', '09' => 'September',
    '10' => 'October', '11' => 'November', '12' => 'December',
];

$currentYear = date('Y');
$years = array_reverse(range($currentYear - 5, $currentYear));

$selectedMonth = $_GET['month'] ?? null;
$selectedYear = $_GET['year'] ?? $currentYear; // Default to current year (e.g., 2025)


$filteredRecords = [];

if ($selectedMonth && $selectedYear) {
    $stmt = $db->prepare("SELECT date, time_in, time_out, status FROM attendance WHERE employee_id = :emp_id AND MONTH(date) = :month AND YEAR(date) = :year ORDER BY date ASC");
    $stmt->execute([
        ':emp_id' => $employeeId,
        ':month' => $selectedMonth,
        ':year' => $selectedYear
    ]);
    $filteredRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$stmtName = $db->prepare("SELECT first_name, middle_name, last_name FROM employees WHERE id = :emp_id LIMIT 1");
$stmtName->execute([':emp_id' => $employeeId]);
$employee = $stmtName->fetch(PDO::FETCH_ASSOC);

$employeeName = $employee ? $employee['first_name'] . ' ' . $employee['middle_name'] . '. ' . $employee['last_name'] : "Unknown Employee";


// Replace with actual schedule ID (e.g., from session or employee record)
$scheduleId = $employeeId;

// 1. Fetch schedule_id from employee_schedules for this employee
$stmt = $db->prepare("SELECT schedule_id FROM employee_schedules WHERE employee_id = :employee_id LIMIT 1");
$stmt->execute(['employee_id' => $employeeId]);
$empSchedule = $stmt->fetch(PDO::FETCH_ASSOC);

$officialTimeIn = '-';
$officialTimeOut = '-';

if ($empSchedule) {
    $scheduleId = $empSchedule['schedule_id'];

    // 2. Fetch time_in and time_out from schedules table
    $stmt2 = $db->prepare("SELECT time_in, time_out FROM schedules WHERE id = :schedule_id");
    $stmt2->execute(['schedule_id' => $scheduleId]);
    $schedule = $stmt2->fetch(PDO::FETCH_ASSOC);

    if ($schedule) {
        $officialTimeIn = date("g:i A", strtotime($schedule['time_in']));
        $officialTimeOut = date("g:i A", strtotime($schedule['time_out']));
    }
}
?>


<div class="flex min-h-screen overflow-hidden">
    <!-- Main content -->
    <main id="mainContent" class="flex-1 p-6 bg-gray-100 transition-margin duration-300 ease-in-out" style="margin-left: 256px;">
        <?php require_once views_path("partials/user_sidebar"); ?>

        <div>
            <span class="text-2xl font-bold tracking-tight">Daily Time Record</span>
            <p class="text-gray-600">Here's a quick overview of your daily logs.</p>
        </div>

        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow p-6 mt-4">
            <!-- Filter Form -->
            <div class="flex items-center justify-between mb-6 gap-4">
                <form method="GET" action="" class="flex flex-wrap items-center gap-2 sm:gap-4">
                    <input type="hidden" name="payroll" value="user_dtr" />
                    <label for="month" class="font-medium text-gray-700">Month:</label>
                    <select name="month" id="month" class="border rounded p-1" required>
                        <option disabled <?= is_null($selectedMonth) ? 'selected' : '' ?>>-- Select Month --</option>
                        <?php foreach ($months as $num => $name): ?>
                            <option value="<?= $num ?>" <?= ($num === $selectedMonth) ? 'selected' : '' ?>><?= $name ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="year" class="font-medium text-gray-700">Year:</label>
                    <select name="year" id="year" class="border rounded p-1" required>
                        <option disabled <?= is_null($selectedYear) ? 'selected' : '' ?>>-- Select Year --</option>
                        <?php foreach ($years as $year): ?>
                            <option value="<?= $year ?>" <?= ($year == $selectedYear) ? 'selected' : '' ?>><?= $year ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button id="filterBtn" type="submit" class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700 transition">
                        <span class="text-sm">Filter</span><i class="bi bi-funnel fs-7 ml-2"></i>
                    </button>


                </form>

                <?php if ($selectedMonth && $selectedYear): ?>
                    <div class="flex gap-2">
                        <?php if (count($filteredRecords) > 0): ?>
                            <button onclick="downloadDTR()" class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700 transition">
                                <i class="bi bi-download mr-2"></i> <span class="text-sm">Download DTR</span>
                            </button>
                        <?php endif; ?>
                        <button type="button" onclick="clearFilter()" class="bg-gray-600 text-white px-4 py-1 rounded hover:bg-gray-700 transition"><span class="text-sm">Clear Filter</span></button>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($selectedMonth && $selectedYear): ?>
                <?php if (count($filteredRecords) > 0): ?>
                    <!-- DTR Table -->
                    <div class="overflow-x-auto">
                        <div id="dtrSection" class="text-xs leading-tight">
                            <p class="text-center font-semibold text-sm">DAILY TIME RECORD</p>
                            <p class="text-left mb-2">Name: <strong><span class="underline"><?= ucwords(htmlspecialchars($employeeName)) ?></span></strong></p>
                            <div class="mb-2 text-xs">
                                <p>For the month of: <strong><?= $months[$selectedMonth] ?> <?= $selectedYear ?></strong></p>
                                <p>Official Hours: <?= htmlspecialchars($officialTimeIn) ?> | <?= htmlspecialchars($officialTimeOut) ?></p>
                            </div>

                            <table class="table-fixed w-full border border-black text-center text-xs">
                                <thead>
                                    <tr>
                                        <th class="border border-black w-[10%]">Day</th>
                                        <th class="border border-black w-[20%]">Time In</th>
                                        <th class="border border-black w-[20%]">Time Out</th>
                                        <th class="border border-black w-[20%]">Hours Worked</th>
                                        <th class="border border-black w-[20%]">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);
                                    $totalDaysWorked = 0;
                                    for ($day = 1; $day <= $daysInMonth; $day++):
                                        $dateStr = sprintf('%04d-%02d-%02d', $selectedYear, $selectedMonth, $day);
                                        $entry = null;
                                        foreach ($filteredRecords as $rec) {
                                            if ($rec['date'] === $dateStr) {
                                                $entry = $rec;
                                                break;
                                            }
                                        }
                                        $timeIn = ($entry && $entry['time_in'] !== '01:00:00') 
                                            ? date("h:i:s A", strtotime($entry['time_in'])) 
                                            : '-';

                                        $timeOut = ($entry && $entry['time_out'] !== '01:00:00') 
                                            ? date("h:i:s A", strtotime($entry['time_out'])) 
                                            : '-';

                                        $remarks = $entry ? $entry['status'] : '-';
                                        $worked = ($entry && $entry['status'] !== 'Absent') ? 8 : 0;
                                        $totalDaysWorked += ($worked > 0) ? 1 : 0;
                                    ?>
                                        <tr>
                                            <td class="border border-black"><?= $day ?></td>
                                            <td class="border border-black"><?= htmlspecialchars($timeIn) ?></td>
                                            <td class="border border-black"><?= htmlspecialchars($timeOut) ?></td>
                                            <td class="border border-black"><?= $worked ?></td>
                                            <td class="border border-black"><?= htmlspecialchars($remarks) ?></td>
                                        </tr>
                                    <?php endfor; ?>
                                    <tr>
                                        <td colspan="3" class="border border-black font-bold text-right pr-2">Total</td>
                                        <td class="border border-black font-bold"><?= $totalDaysWorked * 8 ?></td>
                                        <td class="border border-black"></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="flex justify-between items-center mt-4 text-[10px] leading-snug">
                                <p class="max-w-[70%] text-justify">
                                    I certify on my honor that the above is a true and correct record of the hours of work performed, and that I have not falsified or misrepresented any information contained herein.
                                    I understand that any misrepresentation or omission of time-in or time-out entries may result in disciplinary action and/or legal consequences.
                                </p>
                                <p class="text-right max-w-[35%] pr-10">
                                    ______________________________<br>
                                    Signature over printed name
                                </p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-center text-gray-600 mt-10">No DTR records found for <?= $months[$selectedMonth] ?> <?= $selectedYear ?>.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>
</div>



<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>


function downloadDTR() {
    Swal.fire({
        title: 'Downloading...',
        text: 'Please wait while we generate your DTR.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    const element = document.getElementById("dtrSection");
    window.scrollTo(0, 0);

    const opt = {
        margin: 5,
        filename: 'DTR_<?= $months[$selectedMonth] . "_" . $selectedYear ?>.pdf',
        image: { type: 'png', quality: 6 },
        html2canvas: { scale: 3, scrollX: 0, scrollY: 0 },
        jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
        pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
    };

    html2pdf().set(opt).from(element).save().then(() => {
        Swal.close();
    }).catch((error) => {
        Swal.fire('Error', 'Something went wrong while generating the PDF.', 'error');
        console.error(error);
    });
}

function clearFilter() {
    const url = new URL(window.location.href);
    url.searchParams.delete('month');
    url.searchParams.delete('year');
    if (!url.searchParams.has('payroll')) {
        url.searchParams.set('payroll', 'user_dtr');
    }
    window.location.href = url.toString();
}

document.addEventListener('DOMContentLoaded', function () {
    const monthSelect = document.getElementById('month');
    const yearSelect = document.getElementById('year');
    const filterForm = document.querySelector('form');

    filterForm.addEventListener('submit', function (e) {
        const monthValid = monthSelect.value && !monthSelect.options[monthSelect.selectedIndex].disabled;
        const yearValid = yearSelect.value && !yearSelect.options[yearSelect.selectedIndex].disabled;

        if (!monthValid || !yearValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Incomplete Filter',
                text: 'Please select both month and year before filtering.'
            });
        }
    });
});
</script>

<!-- Responsive + Print Styles -->
<style>
#dtrSection {
    width: 100%;
    max-width: 794px;
    padding: 20px;
    margin: auto;
    background-color: white;
    overflow-x: auto;
}

#dtrSection table {
    width: 100%;
    table-layout: fixed;
    border-collapse: collapse;
    font-size: 10px;
    word-break: break-word;
    margin-top: 10px;
}

#dtrSection th,
#dtrSection td {
    padding: 4px;
    border: 1px solid black;
    text-align: center;
}

@media (max-width: 768px) {
    #dtrSection {
        padding: 10px;
    }

    #dtrSection table {
        font-size: 9px;
    }

    #dtrSection p,
    #dtrSection span,
    #dtrSection strong {
        font-size: 10px;
    }
}

@media print {
    body {
        margin: 0;
    }

    #dtrSection {
        width: 794px;
        padding: 20px;
        page-break-inside: avoid;
    }

    table, tr, td, th {
        page-break-inside: avoid !important;
    }

    html, body {
        width: 210mm;
        height: 297mm;
    }
}
</style>
