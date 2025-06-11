<?php
$title = "Schedules";
require_once views_path("partials/header");
require_once views_path("partials/sidebar");
require_once views_path("partials/nav");
?>



<main class="h-[calc(100vh-3rem)] overflow-hidden p-4 md:p-6 sm:ml-64 mt-12 bg-[#f8fbf8]">
  <header class="mb-6">
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
    
    <!-- Left Side: Title and Description -->
    <div>
      <span class="text-2xl font-bold tracking-tight text-[#133913]">Schedules</span>
      <p class="text-[#478547] ">Manage employee schedules.</p>
    </div>
    
    <!-- Right Side: Button -->
    <button type="button" 
            class="btn btn-success d-inline-flex align-items-center h-10 px-4 py-2" 
            style="min-width: 106px;"
            data-bs-toggle="modal" 
            data-bs-target="#addScheduleModal">
      <i class="fas fa-plus me-2"></i>
      <span class="d-none d-sm-inline font-semibold">Add schedule</span>
    </button>

    
  </div>
</header>



  <div class="bg-white border-2 border-green-200 rounded-lg p-4 md:p-6 mt-4"
        data-aos="fade-in" 
        data-aos-delay="<?= $index * 1 ?>"
        data-aos-duration="500">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
      <span class="text-xl md:text-2xl font-semibold text-[#133913]">Schedule Management</span>

                <div class="relative w-64">
                    <svg class="lucide lucide-search absolute left-2.5 top-3 h-4 w-4 text-[#478547]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                    <input
                        type="text"
                        id="searchInput"
                        class="sched-search flex h-10 w-full placeholder:ml-[10px] rounded-md border border-input bg-background px-[50px] py-2 pl-8 text-base placeholder:text-[#478547] ring-offset-[#f8fbf8] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#16a249] focus-visible:ring-offset-2 disabled:opacity-50 md:text-sm"
                        placeholder="Search employee..."
                        oninput="toggleClearButton()"
                    >
                    <button id="clearButton" class="absolute right-2 top-1 text-[#478547] text-xl hidden" onclick="clearInput()">×</button>
                </div>
      
    </div>

    <!-- Table -->
    <div class="w-full h-[calc(100vh-295px)] overflow-x-auto overflow-y-auto">
    <table class="min-w-full table-auto md:table-fixed">
        <thead class="sticky top-0 z-10">
        <tr class="border-b transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
            <th class="h-12 px-2 md:px-4 text-left align-middle font-bold text-[#478547] bg-white w-[8%] whitespace-nowrap">No.</th>
            <th class="h-12 px-2 md:px-4 text-left align-middle font-bold text-[#478547] bg-white w-[25%] whitespace-nowrap">Schedule Name</th>
            <th class="h-12 px-2 md:px-4 text-left align-middle font-bold text-[#478547] bg-white w-[17%] whitespace-nowrap">Time In</th>
            <th class="h-12 px-2 md:px-4 text-left align-middle font-bold text-[#478547] bg-white w-[17%] whitespace-nowrap">Time Out</th>
            <th class="h-12 px-2 md:px-4 align-middle font-bold text-[#478547] bg-white w-[18%] whitespace-nowrap">Grace Period</th>
            <th class="h-12 px-2 md:px-4 align-middle font-bold text-[#478547] bg-white w-[15%] whitespace-nowrap">Actions</th>

        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100 text-sm">
        <?php
        $db = new Database();
        $conn = $db->getConnection();

        $query = "SELECT * FROM schedules";
        $result = $conn->query($query);

        if ($result->rowCount() > 0):
            $i = 1;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)):
        ?>
    <tr class="transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
            <!-- data-aos="fade-in" 
            data-aos-delay="<?= $index * 50 ?>"
            data-aos-duration="500" -->
        <td class="px-3 md:px-6 py-2 truncate"><?= $i++ ?></td>
        <td class="px-2 md:px-6 py-2 truncate"><?= htmlspecialchars($row['name']) ?></td>
        <td class="px-2 md:px-6 py-2 truncate"><?= date("g:i A", strtotime($row['time_in'])) ?></td>
        <td class="px-2 md:px-6 py-2 truncate"><?= date("g:i A", strtotime($row['time_out'])) ?></td>
        <td class="px-2 md:px-6 py-2 truncate"><?= (int)$row['grace_period'] ?> mins</td>
        <td class="px-2 md:px-6 py-2 space-x-1 md:space-x-2">
            <!-- <button 
                class="view-btn inline-flex h-8 w-8 md:h-8 md:w-8 items-center justify-center rounded-md font-medium hover:bg-blue-400 hover:text-white px-2 py-1 transition duration-100 transform hover:scale-105"
                data-name="<?= htmlspecialchars($row['name']) ?>"
                data-timein="<?= $row['time_in'] ?>"
                data-timeout="<?= $row['time_out'] ?>"
                data-grace="<?= $row['grace_period'] ?>"
                data-bs-toggle="modal"
                data-bs-target="#viewScheduleModal">
                <i class="bi bi-eye text-lg"></i>
            </button> -->

            <button 
                class="edit-btn inline-flex h-8 w-8 md:h-8 md:w-8 items-center justify-center rounded-md font-medium hover:bg-[#478547] hover:text-white transition duration-100 transform hover:scale-105"
                data-id="<?= $row['id'] ?>"
                data-name="<?= htmlspecialchars($row['name']) ?>"
                data-timein="<?= $row['time_in'] ?>"
                data-timeout="<?= $row['time_out'] ?>"
                data-grace="<?= $row['grace_period'] ?>"
                data-bs-toggle="modal"
                data-bs-target="#editScheduleModal">
                <i class="bi bi-pencil-square text-lg"></i>
            </button>

            <form id="deleteScheduleForm-<?= $row['id'] ?>" action="index.php?payroll=schedules" method="POST" class="inline">
                <input type="hidden" name="schedule_id" value="<?= $row['id'] ?>">
                <input type="hidden" name="action" value="delete">
                <button type="button"
                    onclick="handleDeleteSchedule(event, <?= $row['id'] ?>)"
                    class="inline-flex h-8 w-8 items-center justify-center rounded-md transition-colors hover:bg-[#b91c1c] hover:text-white">
                    <i class="bi bi-trash text-lg"></i>
                </button>
            </form>
        </td>
    </tr>
<?php 
    endwhile;
else:
?>
    <tr>
        <td colspan="6" class="px-4 py-4 text-center text-gray-500">No Schedule Found</td>
    </tr>
<?php endif; ?>
</tbody>

    </table>
    </div>

  </div>
</main>






<!-- Add Schedule Modal -->
<div class="modal fade" id="addScheduleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addScheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="index.php?payroll=schedules" method="POST" id="addScheduleForm">
        <div class="modal-header">
          <h5 class="modal-title text-success fs-5" id="addScheduleModalLabel">
          <i class="fa fa-plus me-2"></i>Add New Schedule</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body space-y-3">
          <!-- Employee Dropdown -->
          <div class="mb-3">
                <label class="form-label text-success ml-2">Employee Name</label>
                <select name="employee_id" class="form-select focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249]" >
                    <option value="" disabled selected>--- Select an Employee ---</option>
                    <?php if (!empty($data['employees'])): ?>
                        <?php foreach ($data['employees'] as $employee): ?>
                            <?php if ($employee['approved_by_manager'] == 1): ?>
                                <option value="<?= htmlspecialchars($employee['id']) ?>">
                                    <?= htmlspecialchars(
                                        ucwords($employee['first_name']) . ' ' .
                                        (isset($employee['middle_name'][0]) ? strtoupper($employee['middle_name'][0]) . '. ' : '') .
                                        ucwords($employee['last_name'])
                                    ) ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option disabled>No available employees</option>
                    <?php endif; ?>
                </select>
            </div>

          <!-- Time In -->
          <div class="mb-3">
            <label class="form- text-success ml-2">Time In</label>
            <input type="time" name="time_in" class="form-control focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249]" >
          </div>

          <!-- Time Out -->
          <div class="mb-3">
            <label class="form-label text-success ml-2">Time Out</label>
            <input type="time" name="time_out" class="form-control focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249]" >
          </div>

          <!-- Grace Period -->
          <div class="mb-3">
            <label class="form-label text-success ml-2">Grace Period (minutes)</label>
            <input type="number" name="grace_period" class="form-control focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249]" >
          </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Add Schedule</button>
            <button type="button"
              class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors duration-200 font-semibold"
              data-bs-dismiss="modal">
              Cancel
            </button>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- View Schedule Modal -->
<div class="modal fade" id="viewScheduleModal" tabindex="-1" aria-labelledby="viewScheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success fs-5" id="viewScheduleModalLabel">
          <i class="bi bi-info-circle me-2"></i>Schedule Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body space-y-2" id="viewScheduleBody">
        <!-- JS will populate this -->
      </div>
    </div>
  </div>
</div>

<!-- Edit Schedule Modal -->
<div class="modal fade" id="editScheduleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form action="index.php?payroll=schedules&action=delete" method="POST" id="editScheduleForm">
        <div class="modal-header">
          <h5 class="modal-title text-success fs-5" id="editScheduleModalLabel">
            <i class="fa fa-pen-to-square"></i> Edit Schedule</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body space-y-3">
          <input type="hidden" name="id" id="editScheduleId">
          <div>
            <label class="form-label text-[#396A39] font-semibold ml-2">Schedule Name</label>
            <input type="text" name="schedule_name" id="editScheduleName" class="form-control pointer-events-none cursor-default bg-gray-100 focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249]"  readonly>
          </div>
          <div>
            <label class="form-label text-[#396A39] font-semibold ml-2">Time In</label>
            <input type="time" name="time_in" id="editTimeIn" class="form-control cursor-text focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249]" >
          </div>
          <div>
            <label class="form-label text-[#396A39] font-semibold ml-2">Time Out</label>
            <input type="time" name="time_out" id="editTimeOut" class="form-control cursor-text focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249]" >
          </div>
          <div>
            <label class="form-label text-[#396A39] font-semibold ml-2">Grace Period (minutes)</label>
            <input type="number" name="grace_period" id="editGracePeriod" class="form-control cursor-text focus:outline-none focus:border-[#16a249] focus:ring-2 focus:ring-[#16a249]" >
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Changes</button>
          <button type="button"
            class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition-colors duration-200 font-semibold"
            data-bs-dismiss="modal">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once views_path("partials/footer"); ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const clearBtn = document.getElementById("clearButton");

    searchInput.addEventListener("input", function () {
        toggleClearButton();
        filterTable();
    });

    clearBtn.addEventListener("click", function () {
        searchInput.value = "";
        toggleClearButton();
        filterTable();
    });

    function toggleClearButton() {
        clearBtn.classList.toggle("hidden", searchInput.value.trim() === "");
    }

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll("tbody tr");
        let visibleCount = 0;

        rows.forEach(row => {
            const scheduleNameCell = row.querySelector("td:nth-child(2)");

            // Skip empty rows or the "No Schedule Found" row
            if (!scheduleNameCell) return;

            const name = scheduleNameCell.textContent.toLowerCase();
            const matches = name.includes(searchTerm);

            row.style.display = matches || searchTerm === "" ? "" : "none";

            if (matches) visibleCount++;
        });

        // Handle "No matching schedules found"
        let noResultRow = document.getElementById("noResultRow");
        if (visibleCount === 0) {
            if (!noResultRow) {
                noResultRow = document.createElement("tr");
                noResultRow.id = "noResultRow";
                noResultRow.innerHTML = `<td colspan="6" class="px-4 py-4 text-center text-gray-500">No matching schedules found</td>`;
                document.querySelector("tbody").appendChild(noResultRow);
            }
        } else {
            if (noResultRow) noResultRow.remove();
        }
    }
});
</script>

