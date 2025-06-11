function formatFullName(first, middle, last, suffix) {
  const firstName = (first ?? '').toUpperCase();
  const middleInitial = middle ? `${middle.charAt(0).toUpperCase()}.` : '';
  const lastName = (last ?? '').toUpperCase();
  const nameSuffix = suffix ? suffix.toUpperCase() : '';
  return `${lastName}, ${firstName} ${middleInitial} ${nameSuffix}`.trim().replace(/\s+/g, ' ');
}

function formatSSS(sss) {
  if (!sss) return 'N/A';
  return `${sss.slice(0, 4)}-${sss.slice(4, 11)}-${sss.slice(11)}`.replace(/-+$/, '');
}

function formatPagibig(pagibig) {
  if (!pagibig) return 'N/A';
  return `${pagibig.slice(0, 4)}-${pagibig.slice(4, 8)}-${pagibig.slice(8)}`.replace(/-+$/, '');
}

function formatPhilhealth(philhealth) {
  if (!philhealth) return 'N/A';
  return `${philhealth.slice(0, 2)}-${philhealth.slice(2, 11)}-${philhealth.slice(11)}`.replace(/-+$/, '');
}

function toTitleCase(str) {
  if (!str) return 'N/A';
  return str.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
}


function viewEmployee(employeeId) {
  fetch(`index.php?payroll=employees&id=${employeeId}`)
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        const emp = data.data;

        const deleteBtn = document.getElementById('modalDeleteBtn');
        if (deleteBtn) {
          deleteBtn.setAttribute('data-id', emp.id);
        } else {
          console.warn('modalDeleteBtn not found in the DOM');
        }


        document.getElementById('view_employee_id').value = emp.employee_no;
        
        document.getElementById('employeeIdView').textContent = emp.employee_no || 'N/A';

        document.getElementById('employeeName').textContent = formatFullName(emp.first_name, emp.middle_name, emp.last_name, emp.suffix);
        document.getElementById('employeeId').textContent = emp.employee_no || 'N/A';
        document.getElementById('employeeBloodType').textContent = emp.blood_type || 'Not available';
        document.getElementById('employeeCivilStatus').textContent = emp.civil_status || 'Not available';
        document.getElementById('employeeSex').textContent = emp.sex || 'Not available';
        document.getElementById('employeeCitizen').textContent = (emp.citizenship || 'N/A').toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
        document.getElementById('employeePosition').textContent = emp.position || 'N/A';
        document.getElementById('employeeEmail').textContent = emp.email || 'N/A';
        document.getElementById('employeePhone').textContent = emp.contact_number || 'N/A';
        document.getElementById('employeePlaceOfBirth').textContent = toTitleCase(emp.place_of_birth || '');
        document.getElementById('employeeRFID').textContent = emp.rfid_number || 'N/A';
        document.getElementById('employeeAddress').textContent = toTitleCase(emp.address || '');
        document.getElementById('employeeSalary').textContent = emp.base_salary || 'N/A';
        document.getElementById('employeeSSS').textContent = formatSSS(emp.sss_number || '');
        document.getElementById('employeePagibig').textContent = formatPagibig(emp.pagibig_number || '');
        document.getElementById('employeePhilhealth').textContent = formatPhilhealth(emp.philhealth_number || '');
        document.getElementById('employeeBranch').textContent = emp.branch_manager_display || 'Not assigned';


        // Format birthday
        const dob = emp.dob || 'N/A';
        if (dob !== 'N/A') {
          const date = new Date(dob);
          const formattedDob = `${date.getMonth() + 1}-${date.getDate()}-${date.getFullYear()}`;
          document.getElementById('employeeBirthday').textContent = formattedDob;
        } else {
          document.getElementById('employeeBirthday').textContent = dob;
        }

        // Handle photo
        const photoElement = document.getElementById('view_employeePhoto');

        const isValidPhoto = emp.photo_path && emp.photo_path.trim() !== '';
        const isFemale = emp.sex && emp.sex.toLowerCase() === 'female';

        const defaultImage = isFemale
            ? 'assets/image/default_women.png'
            : 'assets/image/default_men.png';

        if (isValidPhoto) {
            const imageUrl = `../public/${emp.photo_path}`;
            photoElement.src = imageUrl + `?v=${Date.now()}`; // force reload

            photoElement.onerror = function () {
                this.onerror = null;
                this.src = defaultImage;
            };
        } else {
            photoElement.src = defaultImage;
        }
      } else {
        alert('Employee not found.');
      }
    })
    .catch(error => {
      console.error('Error loading employee:', error);
      alert('Something went wrong while loading employee data.');
    });
}
