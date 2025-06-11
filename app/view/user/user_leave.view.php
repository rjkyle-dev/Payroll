<?php
$title = "Leave Application";
require_once views_path("partials/header");
echo '<script src="../public/assets/js/bootstrap/bootstrap.bundle.min.js"></script>';
echo '<script src="../public/assets/js/sweetalert2/sweetalert2.all.min.js"></script>';


$leaveSummary = [
    'Sick Leave' => ['allowed' => 10, 'taken' => 2, 'color' => 'border-l-blue-500'],
    'Emergency Leave' => ['allowed' => 5, 'taken' => 1, 'color' => 'border-l-red-500'],
    'Vacation Leave' => ['allowed' => 5, 'taken' => 4, 'color' => 'border-l-yellow-500'],
    'Personal Leave' => ['allowed' => 5, 'taken' => 0, 'color' => 'border-l-purple-500'],
    'Maternity/Paternity Leave' => ['allowed' => 8, 'taken' => 5, 'color' => 'border-l-green-500'],
];


function getBorderColorClass($type) {
    switch ($type) {
        case 'Sick Leave':
            return 'border-l-blue-500';
        case 'Emergency Leave':
            return 'border-l-red-500';
        case 'Vacation Leave':
            return 'border-l-yellow-500';
        case 'Personal Leave':
            return 'border-l-purple-500';
        case 'Maternity/Paternity Leave':
            return 'border-l-green-500';
        default:
            return 'border-l-gray-400';
    }
}


?>

<style>
    .btn-close {
    filter: invert(1) brightness(2);
}
.swal2-confirm-red {
  background-color: #e74c3c !important; /* Red color */
  color: white !important;
  border: none !important;
}
.table thead th {
    background-color: #0b5125;
    color: #f3f4f6;
    font-weight: 600;
}

.table-hover tbody tr:hover {
    background-color: #f8fafc;
}

.badge {
    padding: 0.4em 0.6em;
    font-size: 0.85em;
    border-radius: 0.5rem;
}

</style>

<div class="flex min-h-screen overflow-hidden ">
    <!-- Main content -->
    <main id="mainContent" class="flex-1 p-6 bg-gray-100 transition-margin duration-300 ease-in-out" style="margin-left: 256px;">

        <?php require_once views_path("partials/user_sidebar"); ?>

        <div class="p-1 max-w-7xl mx-auto space-y-6">
            <!-- Page Header -->
            <div class="space-y-1">
                <span class="text-3xl font-bold text-gray-900">Leave Applications</span>
                <p class="text-gray-600">View and track your leave requests and remaining days.</p>
            </div>

            <!-- Enhanced Leave Summary Cards -->
            <div class="mt-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <span class="text-lg font-semibold text-gray-800 mb-4 block">Leave Credits</span>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                            <?php foreach ($leaveSummary as $type => $data): 
                                $remaining = max(0, $data['allowed'] - $data['taken']);
                                $borderColor = getBorderColorClass($type);
                            ?>
                                <div class="bg-white rounded-lg shadow-sm p-2 hover:shadow-md transition text-center border-l-4 <?= $borderColor ?>">
                                    <span class="text-sm font-medium text-gray-600"><?= htmlspecialchars($type) ?></span>
                                    <p class="text-base mt-3 font-bold text-green-600">
                                        <?= $remaining ?>
                                        <span class="text-xs text-gray-500 font-normal"></span>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>


            <!-- Leave Application Actions -->

            <!-- Leave Application Table -->
            <div class="bg-white rounded-lg shadow p-4 overflow-x-auto">
                <div class="flex justify-between items-center">
                <div>
                    <span class="text-xl font-semibold">Your Leave Applications</span>
                    <p class="text-sm text-gray-500">All your submitted leave records are shown here.</p>
                </div>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#leaveModal">
                    <i class="bi bi-file-earmark-plus me-2"></i>Apply for Leave
                </button>
            </div>
                <div class="table-responsive shadow-sm rounded-3 border border-light">
    <table class="table table-bordered table-hover text-sm align-middle mb-0">
        <thead class="table-success text-center">
            <tr>
                <th>Type</th>
                <th>Start</th>
                <th>End</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>    
            </tr>
        </thead>
        <tbody>
            <?php if ($leaves): ?>
                <?php foreach ($leaves as $leave): ?>
                    <tr>
                        <td><?= htmlspecialchars($leave['leave_type']) ?></td>
                        <td><?= htmlspecialchars($leave['start_date']) ?></td>
                        <td><?= htmlspecialchars($leave['end_date']) ?></td>
                        <td>
                            <?php if (!empty($leave['reason'])): ?>
                                <button class="btn btn-sm btn-info w-100" data-bs-toggle="modal" data-bs-target="#leaveReasonModal<?= $leave['id'] ?>">
                                    View
                                </button>

                                <div class="modal fade" id="leaveReasonModal<?= $leave['id'] ?>" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content" style="height: 50vh;">
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title">Leave Reason</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body d-flex flex-column justify-content-between">
                                                <div>
                                                    <?= nl2br(htmlspecialchars($leave['reason'])) ?>
                                                </div>
                                                <?php if (!empty($leave['leave_type'])): ?>
                                                    <div>
                                                        <hr class="w-100 m-0">
                                                        <small class="text-muted">Leave Type: <?= htmlspecialchars($leave['leave_type']) ?></small>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <span class="text-muted fst-italic">N/A</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <span class="badge 
                                <?= $leave['status'] === 'Approved' ? 'bg-success' : ($leave['status'] === 'Rejected' ? 'bg-danger' : 'bg-warning text-dark') ?>">
                                <?= $leave['status'] ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <?php if ($leave['status'] === 'Pending'): ?>
                                <button class="btn btn-sm btn-outline-danger delete-leave-btn"
                                        data-id="<?= $leave['id'] ?>"
                                        data-type="<?= htmlspecialchars($leave['leave_type']) ?>">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-3">No leave applications yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

            </div>
        </div>

        <!-- Leave Modal -->
        <div class="modal fade" id="leaveModal" tabindex="-1" aria-labelledby="leaveModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                <form method="POST" action="index.php?payroll=user_leave" id="leaveForm">
                    <div class="modal-header"style="background-color: #0b5125; color: white;">
                    <h5 class="modal-title" id="leaveModalLabel"><i class="bi bi-file-earmark-text me-2"></i>Leave Application</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <div class="modal-body">
                    <!-- Row 1: Leave Type and Duration -->
                    <div class="row mb-3">
                        <div class="col">
                        <label class="form-label" for="leave_type">Leave Type</label>
                        <select name="leave_type" id="leave_type" class="form-select" required>
                            <option value="" disabled selected>Select leave type</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Emergency Leave">Emergency Leave</option>
                            <option value="Vacation Leave">Vacation Leave</option>
                            <option value="Personal Leave">Personal Leave</option>
                            <option value="Maternity/Paternity Leave">Maternity/Paternity Leave</option>
                        </select>
                        </div>
                        <div class="col">
                        <label class="form-label" for="duration">Duration (days)</label>
                        <input type="number" name="duration" id="duration" class="form-control" readonly value="0">
                        </div>
                    </div>

                    <!-- Row 2: Start Date and End Date -->
                    <div class="row mb-3">
                        <div class="col">
                        <label class="form-label" for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required min="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="col">
                        <label class="form-label" for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required min="<?= date('Y-m-d') ?>">
                        </div>
                    </div>

                    <!-- Reason -->
                    <div>
                        <label class="form-label" for="reason">Reason</label>
                        <textarea 
                            name="reason" 
                            id="reason"
                            placeholder="Please provide a detailed reason for your leave request..." 
                            class="form-control" 
                            rows="3" 
                            required 
                            style="resize: none; overflow-y: auto;"></textarea>
                    </div>
                    </div>

                    <div class="modal-footer" style="border-top: none;">
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> -->
                        <button type="submit" class="btn btn-success"><i class="bi bi-send-fill me-3"></i>Submit Application</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const durationInput = document.getElementById('duration');

    function updateDuration() {
        const start = new Date(startDateInput.value);
        const end = new Date(endDateInput.value);

        if (start && end && end >= start) {
        const diffTime = end.getTime() - start.getTime();
        const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;
        durationInput.value = diffDays;
        } else {
        durationInput.value = 0;
        }
    }

    startDateInput.addEventListener('change', updateDuration);
    endDateInput.addEventListener('change', updateDuration);

    document.getElementById('leaveForm').addEventListener('submit', function(e) {
        if (parseInt(durationInput.value) <= 0) {
        e.preventDefault();
        alert('End date cannot be before start date.');
        }
    });

    document.querySelectorAll('.delete-leave-btn').forEach(button => {
    button.addEventListener('click', function () {
        const leaveId = this.dataset.id;
        const leaveType = this.dataset.type;

        Swal.fire({
            title: 'Are you sure?',
            text: `Delete your ${leaveType} leave request?`,
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Confirm',
            customClass: {
                confirmButton: 'swal2-confirm-red'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect or submit form to delete the leave
                window.location.href = `index.php?payroll=user_leave&action=delete&id=${leaveId}`;
            }
        });
    });
});
</script>

<?php if (isset($_SESSION['success'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: <?= json_encode($_SESSION['success']) ?>,
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true
        });
    </script>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>


<?php if (isset($_SESSION['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?= $_SESSION['error'] ?>',
            showConfirmButton: false,
            timer: 1000,
            timerProgressBar: true,
        });
    </script>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>


