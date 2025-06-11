<?php
$title = "Leave History"; // Set the page title
require_once views_path("partials/header"); // Include the header partial
require_once views_path("partials/sidebar");
require_once views_path("partials/nav");
?>

<main class="flex-1 h-[calc(100vh-3rem)] p-4 md:p-6 ml-[255px] mt-12 bg-[#f8fbf8]">
    <div class="space-y-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <span class="text-2xl font-bold tracking-tight text-[#133913]">Leave History</span>
                    <p class="text-[#478547]">View records of past employee leave requests and their statuses.</p>
                </div>

            </div>


        <div class="rounded-lg border-2 border-green-200 bg-white text-[#133913] shadow-sm" 
                    data-aos="fade-in" 
                    data-aos-delay="<?= $index * 1 ?>"
                    data-aos-duration="500">
            <div class="space-y-1.5 p-6 flex flex-row items-center justify-between">
                <span class="text-2xl font-semibold leading-none tracking-tight text-[#133913]">Employee Directory</span>
                <div class="relative w-64">
                    <svg class="lucide lucide-search absolute left-2.5 top-3 h-4 w-4 text-[#478547]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                    <input
                        type="text"
                        id="searchInput"
                        class="flex h-10 w-full placeholder:ml-[10px] rounded-md border border-input bg-background px-[50px] py-2 pl-8 text-base placeholder:text-[#478547] ring-offset-[#f8fbf8] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#16a249] focus-visible:ring-offset-2 disabled:opacity-50 md:text-sm"
                        placeholder="Search employee..."
                        oninput="toggleClearButton()"
                    >
                    <button id="clearButton" class="absolute right-2 top-1 text-[#478547] text-xl hidden" onclick="clearInput()">×</button>
                </div>                
            </div>

            <div class="p-6 pt-0">
                <div class="relative w-full overflow-auto">
                    <div class="max-h-[calc(100vh-300px)] overflow-y-auto">
                        <table class="w-full caption-bottom text-sm">
                            <thead class="[&_tr]:border-b bg-[#f2f8f2] sticky top-0 z-10">
                                <tr class="border-b transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
                                    <th class="h-12 px-3 text-left align-middle font-bold text-[#478547] bg-white">Photos</th>
                                    <th class="h-12 px-3 text-left align-middle font-bold text-[#478547] bg-white">Employee Name</th>
                                    <th class="h-12 px-3 text-left align-middle font-bold text-[#478547] bg-white">Employee ID</th>
                                    <th class="h-12 px-3 text-left align-middle font-bold text-[#478547] bg-white">Leave Types</th>
                                    <th class="h-12 px-3 text-left align-middle font-bold text-[#478547] bg-white">Start Date</th>
                                    <th class="h-12 px-3 text-left align-middle font-bold text-[#478547] bg-white">End Date </th>
                                    <th class="h-12 px-3 text-left align-middle font-bold text-[#478547] bg-white">Status</th>
                                    <th class="h-12 px-3 text-left align-middle font-bold text-[#478547] bg-white">Approved/Rejected By</th>
                                    <!-- <th class="h-12 px-3 align-middle font-bold text-[#478547] bg-white">Actions</th> -->
                                </tr>
                            </thead>
                                <tbody id="employeeTable " class="[&_tr:last-child]:border-0">
                                    <?php if (!empty($employees)): ?>
                                        <?php foreach ($employees as $employee): ?>
                                            <tr class="transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
                                                <td class="p-3 align-middle font-medium">
                                                    <?php
                                                        $defaultImage = ($employee['sex'] === 'Female') 
                                                            ? '../public/assets/image/default_women.png' 
                                                            : '../public/assets/image/default_men.png';

                                                        $photoPath = !empty($employee['photo_path']) 
                                                            ? htmlspecialchars($employee['photo_path']) 
                                                            : $defaultImage;
                                                    ?>
                                                    <img src="<?= $photoPath ?>"
                                                        alt="Photo"
                                                        class="w-10 h-10 rounded-full object-cover border border-gray-300">
                                                </td>

                                                <td class="p-3 align-middle font-medium"><?= htmlspecialchars($employee['employee_name']) ?></td>
                                                <td class="p-3 align-middle"><?= htmlspecialchars($employee['employee_no']) ?></td>
                                                <td class="p-3 align-middle"><?= htmlspecialchars($employee['leave_type']) ?></td>
                                                <td class="p-3 align-middle"><?= htmlspecialchars($employee['start_date']) ?></td>
                                                <td class="p-3 align-middle"><?= htmlspecialchars($employee['end_date']) ?></td>
                                                <td class="p-3 align-middle"><?= htmlspecialchars($employee['status']) ?></td>
                                                <td class="p-3 align-middle text-center">
                                                    <?= $employee['status'] === 'Rejected' && $employee['rejection_reason'] 
                                                        ? $employee['manager_name']
                                                        : ($employee['status'] === 'Approved' ? $employee['manager_name'] : '—') ?>
                                                </td>
                                                <!-- <td class="p-3 align-middle text-center">
                                                <button type="button"
                                                        class="inline-flex h-8 w-8 md:h-8 md:w-8 items-center justify-center rounded-md font-medium px-2 py-1 transition duration-100 transform hover:scale-105 hover:bg-[#478547] hover:text-white"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#viewLeaveHistoryModal"
                                                        onclick="viewEmployee('<?= htmlspecialchars($employee['employee_no']) ?>')">
                                                        <i class="bi bi-eye text-lg"></i>
                                                    </button>
                                                </td> -->
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="9" class="p-4 text-center text-gray-500">No leave history found.</td>
                                        </tr>
                                    <?php endif; ?>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const viewModal = document.getElementById('viewEmployeeModal');

  viewModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const employeeId = button.getAttribute('data-employee-id');
    
    if (employeeId) {
      viewEmployee(employeeId);
    }
  });
});
</script>



<?php
require_once views_path("partials/footer");
?>