<?php

$title = "Employee's List";
require_once views_path("partials/header");

$managerId = $_SESSION['manager_id'] ?? null;

if (!$managerId) {
    die("Manager not logged in.");
}

// Including JS libraries - ideally move these to footer
echo '<script src="../public/assets/js/bootstrap/bootstrap.bundle.min.js"></script>';
echo '<script src="../public/assets/js/sweetalert2/sweetalert2.all.min.js"></script>';

require_once '../app/core/database.php';

$db = new Database(); // Instantiate your custom Database class

$sql = "
SELECT 
    e.id, 
    e.employee_no, 
    e.rfid_number, 
    CONCAT(
            UPPER(LEFT(e.first_name, 1)), LOWER(SUBSTRING(e.first_name, 2)), ' ',
            UPPER(LEFT(e.middle_name, 1)), '. ',
            UPPER(LEFT(e.last_name, 1)), LOWER(SUBSTRING(e.last_name, 2))
        ) AS full_name, 
    e.position, 
    e.photo_path, 
    s.time_in, 
    s.time_out,
    CONCAT(m.first_name, ' ', m.last_name) AS manager_name
FROM employees e
LEFT JOIN employee_schedules es ON es.employee_id = e.id
LEFT JOIN schedules s ON s.id = es.schedule_id
LEFT JOIN employees m ON m.id = e.branch_manager
WHERE e.branch_manager = :manager_id
AND e.approved_by_manager = 1
ORDER BY e.last_name ASC

";

$list = $db->query($sql, ['manager_id' => $managerId]);

?>

<div class="flex min-h-screen overflow-hidden">
    <!-- Main content -->
    <main id="mainContent" class="flex-1 p-6 bg-gray-100 transition-margin duration-300 ease-in-out" style="margin-left: 256px;">
        <?php require_once views_path("branch/branch_sidebar"); ?>

        <div>
            <span class="text-2xl font-bold tracking-tight">Employee's List</span>
            <p class="text-gray-600">A detailed list of employees managed by you.</p>
        </div>

        <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 relative">
                <span class="text-lg font-semibold text-gray-800">Employees</span>
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

            <div class="overflow-x-auto">
                <table id="employeeTable" class="min-w-full divide-y divide-gray-200 text-sm overflow-hidden">
                    <thead class="bg-emerald-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">Photo</th>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">Employee Name</th>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">Employee ID</th>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">RFID Number</th>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">Position</th>
                            <th class="px-6 py-3 text-left font-semibold tracking-wide">Scheduled</th>
                            <!-- <th class="px-6 py-3 text-left font-semibold tracking-wide">Actions</th> -->
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <?php if (!empty($list) && is_array($list)): ?>
                            <?php foreach ($list as $lists): ?>
                                <tr>
                                    <td class="px-6 py-4">
                                        <?php if (!empty($lists['photo_path'])): ?>
                                            <img src="/mvcPayroll/public/<?= htmlspecialchars($lists['photo_path']) ?>" class="h-10 w-10 rounded-full object-cover" alt="Employee Photo">
                                        <?php else: ?>
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center text-sm text-white">
                                                <?= strtoupper(substr($lists['full_name'], 0, 1)) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4"><?= htmlspecialchars(ucwords(strtolower($lists['full_name']))) ?></td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($lists['employee_no']) ?></td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($lists['rfid_number']) ?></td>
                                    <td class="px-6 py-4"><?= htmlspecialchars($lists['position']) ?></td>
                                    <td class="px-6 py-4">
                                        <?php if (!empty($lists['time_in']) && !empty($lists['time_out'])): ?>
                                            <?= date("h:i A", strtotime($lists['time_in'])) ?> - <?= date("h:i A", strtotime($lists['time_out'])) ?>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>

                                    <!-- <td class="px-6 py-4">
                                        <button class="bg-emerald-500 text-white px-3 py-1 rounded hover:bg-emerald-600">View</button>
                                    </td> -->
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center px-6 py-4 text-gray-500">No employees found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>


<script>
const searchInput = document.getElementById('employeeSearch');
const clearBtn = document.getElementById('clearSearch');
const table = document.getElementById('employeeTable');

searchInput.addEventListener('input', () => {
  // Show or hide the clear button based on input value
  clearBtn.style.display = searchInput.value ? 'block' : 'none';

  const searchTerm = searchInput.value.toLowerCase();
  const rows = table.tBodies[0].rows;

  for (let row of rows) {
    const rowText = row.textContent.toLowerCase();
    row.style.display = rowText.indexOf(searchTerm) > -1 ? '' : 'none';
  }
});

clearBtn.addEventListener('click', () => {
  searchInput.value = '';
  clearBtn.style.display = 'none';

  // Trigger input event to reset filtering
  searchInput.dispatchEvent(new Event('input'));
});

</script>