document.addEventListener('DOMContentLoaded', () => {
    const addForm = document.getElementById('addScheduleForm');
    const editForm = document.getElementById('editScheduleForm');

    // Utility: Show missing field alert
    function showRequiredAlert(fieldName) {
        Swal.fire({
            icon: 'warning',
            title: 'Missing Field',
            text: `${fieldName} is required.`,
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        });
    }

    // Handle Add Schedule Form Submission
    const addScheduleModal = document.getElementById('addScheduleModal');
        if (addScheduleModal) {
            addScheduleModal.addEventListener('hidden.bs.modal', () => {
                if (addForm) addForm.reset();
            });
        }



    if (addForm) {
        addForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const employeeId = addForm.querySelector('[name="employee_id"]').value.trim();
            const timeIn = addForm.querySelector('[name="time_in"]').value.trim();
            const timeOut = addForm.querySelector('[name="time_out"]').value.trim();
            const gracePeriod = addForm.querySelector('[name="grace_period"]').value.trim();

            if (!employeeId) return showRequiredAlert("Employee");
            if (!timeIn) return showRequiredAlert("Time In");
            if (!timeOut) return showRequiredAlert("Time Out");
            if (!gracePeriod) return showRequiredAlert("Grace Period");

            const addScheduleModal = document.getElementById('addScheduleModal');
                if (addScheduleModal) {
                    addScheduleModal.addEventListener('hidden.bs.modal', () => {
                        if (addForm) addForm.reset();
                    });
                }

            const formData = new FormData(addForm);

            try {
                const response = await fetch('index.php?payroll=schedules', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.status === 'success') {
                    Swal.fire({
                        icon: data.icon || 'success',
                        title: 'Success!',
                        text: data.message || 'Schedule added successfully!',
                        timer: 1000,
                        showConfirmButton: false,
                        timerProgressBar: true
                    }).then(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addScheduleModal'));
                        if (modal) modal.hide();
                        addForm.reset();
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: data.icon || 'error',
                        title: data.title || 'Error',
                        html: data.message || 'Something went wrong.',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                }

            } catch (error) {
                console.error('Fetch Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong while submitting the form.',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    }

    // Handle Edit Schedule Form Submission
    if (editForm) {
        editForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const id = editForm.querySelector('[name="id"]').value.trim();
            const name = editForm.querySelector('[name="schedule_name"]').value.trim();
            const timeIn = editForm.querySelector('[name="time_in"]').value.trim();
            const timeOut = editForm.querySelector('[name="time_out"]').value.trim();
            const gracePeriod = editForm.querySelector('[name="grace_period"]').value.trim();

            if (!id) return showRequiredAlert("Schedule ID");
            if (!name) return showRequiredAlert("Schedule Name");
            if (!timeIn) return showRequiredAlert("Time In");
            if (!timeOut) return showRequiredAlert("Time Out");
            if (!gracePeriod) return showRequiredAlert("Grace Period");

            const formData = new FormData(editForm);

            try {
                const response = await fetch('index.php?payroll=schedules', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.status === 'success') {
                    Swal.fire({
                        icon: data.icon || 'success',
                        title: 'Updated!',
                        text: data.message || 'Schedule successfully updated.',
                        timer: 1000,
                        showConfirmButton: false,
                        timerProgressBar: true
                    }).then(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editScheduleModal'));
                        if (modal) modal.hide();
                        editForm.reset();
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: data.icon || 'error',
                        title: data.title || 'Error',
                        html: data.message || 'Something went wrong.',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                }

            } catch (error) {
                console.error('Fetch Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Something went wrong while updating the schedule.',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    }

    // View Schedule Modal
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const { name, timein, timeout, grace } = this.dataset;
            document.getElementById('viewScheduleBody').innerHTML = `
                <div><strong>Schedule Name:</strong> ${name}</div>
                <div><strong>Time In:</strong> ${timein}</div>
                <div><strong>Time Out:</strong> ${timeout}</div>
                <div><strong>Grace Period:</strong> ${grace} minutes</div>
            `;
        });
    });

    // Edit Schedule Modal
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const { id, name, timein, timeout, grace } = this.dataset;
            document.getElementById('editScheduleId').value = id;
            document.getElementById('editScheduleName').value = name;
            document.getElementById('editTimeIn').value = timein;
            document.getElementById('editTimeOut').value = timeout;
            document.getElementById('editGracePeriod').value = grace;
        });
    });
});

    // Handle Delete Schedule
    function handleDeleteSchedule(event, scheduleId) {
        event.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "This will permanently delete the schedule.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#b91c1c",
            cancelButtonColor: "#6b7280",
            confirmButtonText: "Confirm"
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById(`deleteScheduleForm-${scheduleId}`);
                const formData = new FormData(form);

                fetch('index.php?payroll=schedules', {  // Correct action URL for your backend
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Deleted!',
                            text: data.message,
                            icon: 'success', 
                            showConfirmButton: false, // Hide the "OK" button
                            timer: 1000, // Close the alert after 2 seconds
                            timerProgressBar: true
                        }).then(() => {
                            location.reload();  // Reload the page to reflect changes
                        });
                    } else {
                        Swal.fire({
                            title: data.title || 'Error',
                            text: data.message,
                            icon: data.icon || 'error'
                        });
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    Swal.fire("Error", "Something went wrong while deleting the schedule.", "error");
                });
            }
        });
    }



