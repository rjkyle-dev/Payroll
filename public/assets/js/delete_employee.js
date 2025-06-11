document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.deleteBtn').forEach(button => {
        button.addEventListener('click', () => {
            const employeeId = button.getAttribute('data-id');

            Swal.fire({
                title: "Are you sure?",
                text: "This will permanently delete the employee.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#b91c1c",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Confirm"
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('employee_id', employeeId);
                    formData.append('action', 'delete');

                    fetch('index.php?payroll=employees', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => {
                        if (!res.ok) {
                            // If HTTP status is not 2xx, throw error to be caught below
                            throw new Error(`HTTP error! status: ${res.status}`);
                        }
                        return res.json();
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1200,
                                timerProgressBar: true
                            }).then(() => location.reload());
                        } else {
                            Swal.fire({
                                icon: data.icon || 'error',
                                title: data.title || 'Error',
                                text: data.message || 'Something went wrong.'
                            });
                        }
                    })
                    .catch(err => {
                        console.error("Fetch or parsing error:", err);
                        Swal.fire("Error", "Something went wrong while deleting the employee.", "error");
                    });
                }
            });
        });
    });
});