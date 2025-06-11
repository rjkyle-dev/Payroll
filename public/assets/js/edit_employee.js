function editdisplayFileName(input) {
  const fileNameSpan = document.getElementById('edit_photoFileName');
  if (!fileNameSpan) return;
  const file = input.files?.[0];
  fileNameSpan.textContent = file ? file.name : 'No file chosen';
}

function editpreviewEmployeePhoto(event) {
  const input = event.target;
  const preview = document.getElementById('edit_employeePhotoPreview');
  const placeholder = document.getElementById('edit_photoPlaceholder');
  if (!preview || !placeholder) return;

  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function (e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
      placeholder.style.display = 'none';
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    preview.src = '';
    preview.style.display = 'none';
    placeholder.style.display = 'flex';
  }
}

function initEmployeePhoto(photoPath) {
  const preview = document.getElementById('edit_employeePhotoPreview');
  const placeholder = document.getElementById('edit_photoPlaceholder');
  const fileNameSpan = document.getElementById('edit_photoFileName');
  if (!preview || !placeholder || !fileNameSpan) return;

  if (photoPath) {
    preview.src = photoPath;
    preview.style.display = 'block';
    placeholder.style.display = 'none';
    fileNameSpan.textContent = photoPath.split('/').pop();
  } else {
    preview.style.display = 'none';
    placeholder.style.display = 'flex';
    fileNameSpan.textContent = 'No file chosen';
  }
}

function formatSalary(salary) {
  if (!salary) return '';
  const str = salary.toString();
  return str.endsWith('.00') ? str.slice(0, -3) : str;
}

const editBtn = document.querySelector('.editBtn');
if (editBtn) {
  editBtn.addEventListener('click', () => {
    const employeeIdInput = document.querySelector('#view_employee_id');
    const employeeId = employeeIdInput?.value;

    fetch(`index.php?payroll=employees&id=${employeeId}`)
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          const emp = data.data;

          // Fill input fields
          const fields = {
            edit_employee_id: emp.employee_no,
            edit_rfidNumber: emp.rfid_number,
            edit_first_name: emp.first_name,
            edit_middle_name: emp.middle_name,
            edit_last_name: emp.last_name,
            edit_dob: emp.dob,
            edit_placeOfBirth: emp.place_of_birth,
            edit_sex: emp.sex,
            edit_philhealthNumber: emp.philhealth_number,
            edit_civilStatus: emp.civil_status,
            edit_contactNumber: emp.contact_number,
            edit_email: emp.email,
            edit_citizenship: emp.citizenship,
            edit_bloodType: emp.blood_type,
            edit_position: emp.position,
            edit_address: emp.address,
            edit_baseSalary: formatSalary(emp.base_salary),
            edit_sssNumber: emp.sss_number,
            edit_pagibigNumber: emp.pagibig_number
          };

          Object.entries(fields).forEach(([id, val]) => {
            const el = document.getElementById(id);
            if (el) el.value = val || '';
          });

          // Set selected manager in dropdown
          const branchManagerSelect = document.getElementById('edit_branchManager');
          if (branchManagerSelect) {
            branchManagerSelect.value = emp.branch_manager || '';
          }

          // Update photo preview
          const preview = document.getElementById('edit_employeePhotoPreview');
          const placeholder = document.getElementById('edit_photoPlaceholder');
          const photoFilename = document.getElementById('edit_photoFileName');

          if (emp.photo_path) {
            if (preview) {
              preview.src = emp.photo_path;
              preview.style.display = 'block';
            }
            if (placeholder) placeholder.style.display = 'none';
            if (photoFilename) {
              photoFilename.textContent = emp.photo_path.split('/').pop();
              photoFilename.style.display = 'block';
            }
          } else {
            if (preview) preview.style.display = 'none';
            if (placeholder) placeholder.style.display = 'flex';
            if (photoFilename) {
              photoFilename.textContent = 'No file chosen';
              photoFilename.style.display = 'block';
            }
          }
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Not Found',
            text: 'Employee data not found.',
          });
        }
      })
      .catch(err => {
        console.error('Error:', err);
        Swal.fire({
          icon: 'error',
          title: 'Fetch Failed',
          text: 'An error occurred while fetching the data.',
        });
      });
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('editEmployeeForm');
  if (!form) return;

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    const formData = new FormData(this);

    fetch('index.php?payroll=employees', {
      method: 'POST',
      body: formData,
    })
      .then(async (response) => {
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
          return response.json();
        } else {
          const text = await response.text();
          console.error('Non-JSON response:', text);
          throw new Error('Server did not return valid JSON.');
        }
      })
      .then(data => {
        console.log('Server response:', data);

        if (data.status === 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: data.message || 'Employee updated successfully.',
            timer: 1000,
            showConfirmButton: false,
            timerProgressBar: true,
          }).then(() => {
            resetEditForm();
            const modal = bootstrap.Modal.getInstance(document.getElementById('editEmployeeModal'));
            if (modal) modal.hide();
            window.location.reload();
          });
        } else if (data.status === 'no_changes') {
          Swal.fire({
            icon: 'info',
            title: 'No Changes!',
            text: 'No changes were made to the employee data.',
          });
        } else if (data.status === 'error' && data.title === 'Duplicate Entry') {
          Swal.fire({
            icon: 'error',
            title: data.title,
            text: data.message,
          });
        } else {
          Swal.fire({
            icon: data.icon || 'error',
            title: data.title || 'Update Failed',
            text: data.message || 'An unknown error occurred during update.',
          });
        }
      })
      .catch(error => {
        console.error('Fetch error:', error);
        Swal.fire({
          icon: 'error',
          title: 'Request Failed',
          text: 'Please try again later.',
        });
      });
  });
});

function resetEditForm() {
  const form = document.getElementById('editEmployeeForm');
  if (form) form.reset();

  const preview = document.getElementById('edit_employeePhotoPreview');
  if (preview) preview.style.display = 'none';

  const placeholder = document.getElementById('edit_photoPlaceholder');
  if (placeholder) placeholder.style.display = 'flex';

  const photoFilename = document.getElementById('edit_photoFileName');
  if (photoFilename) {
    photoFilename.textContent = 'No file chosen';
    photoFilename.style.display = 'block';
  }
}
