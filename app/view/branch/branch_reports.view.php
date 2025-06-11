<?php

$title = "Reports";
require_once views_path("partials/header");

$managerId = $_SESSION['manager_id'] ?? null;

if (!$managerId) {
    die("Manager not logged in.");
}

// --- DEMO: Sample Reports Data ---
$reports = [
    [
        'id' => 1,
        'type' => 'Attendance',
        'from_date' => '2025-05-01',
        'to_date' => '2025-05-15',
        'details' => '15 records processed',
        'generated_at' => '2025-05-29 10:45:00'
    ],
    [
        'id' => 2,
        'type' => 'Leave Summary',
        'from_date' => '2025-04-01',
        'to_date' => '2025-04-30',
        'details' => '10 employees on leave',
        'generated_at' => '2025-05-29 11:10:00'
    ]
];


?>


<style>
    .tooltip-container {
  position: relative;
  display: inline-block;
  cursor: pointer;
}

.tooltip-container .tooltip-text {
  visibility: hidden;
  width: 80px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 4px;
  padding: 5px 7px;
  position: absolute;
  z-index: 10;
  bottom: 125%; /* position above the button */
  left: 50%;
  transform: translateX(-50%);
  opacity: 0;
  transition: opacity 0.3s;
  font-size: 12px;
  pointer-events: none;
}

.tooltip-container:hover .tooltip-text {
  visibility: visible;
  opacity: 1;
}

</style>

<div class="flex min-h-screen overflow-hidden">
    <!-- Main content -->
    <main id="mainContent" class="flex-1 p-6 bg-gray-100 transition-margin duration-300 ease-in-out" style="margin-left: 256px;">
        <?php require_once views_path("branch/branch_sidebar"); ?>

        <div>
            <span class="text-2xl font-bold tracking-tight">Reports</span>
            <p class="text-gray-600">View and generate detailed reports.</p>
        </div>

        <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
            <div class="flex items-center justify-between p-4 border-gray-200 relative">
                <span class="text-lg font-semibold text-gray-800"></span>
                <div class="relative max-w-sm w-full sm:w-auto">
                    <input
                        type="text"
                        id="employeeSearch"
                        placeholder="Search employees..."
                        class="flex h-10 w-full placeholder:ml-[10px] rounded-md border border-input bg-background px-[50px] py-2 pl-8 text-base placeholder:text-[#478547] ring-offset-[#f8fbf8] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#16a249] focus-visible:ring-offset-2 disabled:opacity-50 md:text-sm"
                    >
                    <button
                        id="clearSearch"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 text-sm text-gray-400 hover:text-gray-600 hidden"
                        aria-label="Clear search"
                        type="button"
                    >
                        &#x2715;
                    </button>
                </div>
            </div>

            <div class="p-4 bg-white -mt-4 rounded shadow-sm max-w-full">
                <form id="reportForm" method="GET" action="" class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="flex flex-col">
                            <label for="reportType" class="font-semibold text-gray-700 mb-1">Report Type</label>
                            <select id="reportType" name="report_type" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                                <option value="" disabled selected>Select report type</option>
                                <option value="Attendance">Attendance Report</option>
                                <option value="Leave Summary">Leave Report</option>
                                <option value="Payroll">Payroll Summary Report</option>
                                <option value="Payroll">Tax Deuductions Report</option>
                            </select>
                        </div>

                        <div class="flex flex-col">
                            <label for="fromDate" class="font-semibold text-gray-700 mb-1">From:</label>
                            <input type="date" id="fromDate" name="from_date" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                        </div>

                        <div class="flex flex-col">
                            <label for="toDate" class="font-semibold text-gray-700 mb-1">To:</label>
                            <input type="date" id="toDate" name="to_date" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <label class="opacity-0 mb-1 select-none">Hidden label</label> <!-- invisible label to align button with inputs -->
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-5 rounded">Generate</button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table id="reportsTable" class="min-w-full divide-y divide-gray-200 text-sm overflow-hidden">
                    <thead class="bg-emerald-600 text-white text-center">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">ID</th>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">Report Type</th>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">From</th>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">To</th>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">Generated At</th>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reports as $report): ?>
                        <tr class="hover:bg-gray-50 text-center">
                            <td class="px-6 py-4"><?php echo htmlspecialchars($report['id']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($report['type']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($report['from_date']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($report['to_date']); ?></td>
                            <td class="px-6 py-4"><?php echo htmlspecialchars($report['generated_at']); ?></td>
                            <td class="px-6 py-4 text-center">
                                <div class="tooltip-container">
                                    <button
                                        class="inline-flex h-8 w-8 md:h-8 md:w-8 items-center justify-center rounded font-medium px-2 py-1 transition duration-100 transform hover:scale-105 hover:bg-emerald-600 hover:text-white"
                                        onclick='viewReportDemo(<?php echo json_encode($report); ?>)'>
                                        <i class="bi bi-eye text-lg"></i>
                                    </button>
                                    <span class="tooltip-text">View Report Details</span>
                                </div>
                            </td>


                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- <script src="../public/assets/js/sweetalert2/sweetalert2.all.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
(() => {
    const form = document.getElementById('reportForm');
    const reportsTableBody = document.querySelector('#reportsTable tbody');
    const reportTypeSelect = document.getElementById('reportType');
    const fromDateInput = document.getElementById('fromDate');
    const toDateInput = document.getElementById('toDate');

    let maxId = <?php echo count($reports) > 0 ? max(array_column($reports, 'id')) : 0; ?>;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const type = reportTypeSelect.value;
        const from = fromDateInput.value;
        const to = toDateInput.value;

        if (!type || !from || !to) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in all fields before generating the report!'
            });
            return;
        }

        maxId++;

        const generatedAt = new Date().toISOString().slice(0, 19).replace('T', ' ');

        const newRow = document.createElement('tr');
        newRow.classList.add('hover:bg-gray-50');
        newRow.innerHTML = `
            <td class="px-6 py-4 text-center">${maxId}</td>
            <td class="px-6 py-4 text-center">${type}</td>
            <td class="px-6 py-4 text-center">${from}</td>
            <td class="px-6 py-4 text-center">${to}</td>
            <td class="px-6 py-4 text-center">${generatedAt}</td>
            <td class="px-6 py-4 text-center">
    <div class="tooltip-container">
        <button
            class="inline-flex h-8 w-8 md:h-8 md:w-8 items-center justify-center rounded font-medium px-2 py-1 transition duration-100 transform hover:scale-105 hover:bg-emerald-600 hover:text-white"
            onclick='viewReportDemo(<?php echo json_encode($report); ?>)'>
            <i class="bi bi-eye text-lg"></i>
        </button>
        <span class="tooltip-text">View Report Details</span>
    </div>
</td>

        `;

        reportsTableBody.appendChild(newRow);

        form.reset();

        Swal.fire({
            icon: 'success',
            title: 'Report Generated',
            text: `Your ${type} report from ${from} to ${to} was successfully generated!`,
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: false
        });
    });
})();

function viewReportDemo(report) {
  let reportText = '';

  switch(report.type.toLowerCase()) {
    case 'attendance':
      reportText = `
Report Type: Attendance Report
From: ${report.from_date}
To: ${report.to_date}

Details:
- Summary: ${report.details}

Generated At: ${report.generated_at}
      `;
      break;

    case 'leave summary':
    case 'leave':
      reportText = `
Report Type: Leave Report
From: ${report.from_date}
To: ${report.to_date}

Details:
- Summary: ${report.details}

Generated At: ${report.generated_at}
      `;
      break;

    case 'payroll':
      reportText = `
Report Type: Payroll Report
From: ${report.from_date}
To: ${report.to_date}

Details:
- Summary: ${report.details}

Generated At: ${report.generated_at}
      `;
      break;

    default:
      reportText = `
Report Type: ${report.type}
From: ${report.from_date}
To: ${report.to_date}

Details:
- ${report.details}

Generated At: ${report.generated_at}
      `;
  }

  Swal.fire({
    title: 'Report Preview',
    html: `<pre style="text-align:left; font-family: monospace; background:#f9f9f9; padding: 15px; border-radius: 8px;">${reportText}</pre>`,
    width: 450,
    confirmButtonText: 'Close',
    background: '#f0fdf4',
    iconColor: '#10b981'
  });
}

</script>
