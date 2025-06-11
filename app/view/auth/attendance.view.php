<?php
// Set page title
$title = "RFID Attendance";

// Include header partial
require_once views_path("partials/header");
?>

<!-- SweetAlert2 CDN for alert popups -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<!-- Layout wrapper: Sidebar + Main -->
<div class="flex w-screen h-screen overflow-hidden" style="font-family: ${defaultFont};">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-green-800 shadow-md fixed top-0 left-0 bottom-0 z-30 border-r border-green-700 overflow-y-auto">
    <div class="p-6 space-y-4 text-white">
        <!-- Logo & Company Info -->
        <div class="text-center">
            <img src="../public/assets/image/logo.png" alt="Company Logo" 
                 class="mx-auto w-28 h-28 rounded-full border-4 border-white/10 bg-white shadow">
            <span class="font-extrabold text-xl md:text-2xl leading-tight block mt-2">
                Migrants Venture Corporation
            </span>
            <p class="text-green-100 font-semibold mt-1">
                Employee Attendance System
            </p>
        </div>

        <!-- Attendance Form -->
        <form id="manualAttendanceForm" method="POST" action="index.php?payroll=attendance" 
              class="space-y-4 mt-6 w-full">
              
            <!-- Employee ID Input -->
            <div class="space-y-1 text-left">
                <label for="employeeIdInput" class="block text-white text-sm font-medium mb-1 ml-2 mt-14">
                    EMPLOYEE ID
                </label>
                <input
                    type="text"
                    name="employee_id"
                    id="employeeIdInput"
                    placeholder="Enter Employee ID"
                    autocomplete="off"
                    required
                    oninput="this.value = this.value.toUpperCase()"
                    class="w-full px-3 py-2 rounded-md bg-white/10 border border-white/20 text-white placeholder-white/50 focus:outline-none focus:border-white/40 focus:ring-1 focus:ring-white/20"
                />
            </div>

            <!-- Buttons -->
            <div class="flex gap-2 sm:gap-4 pt-2">
                <button
                    type="button"
                    name="time_in"
                    id="manualTimeInBtn"
                    class="flex-1 py-2 rounded border font-semibold text-sm hover:bg-green-200 border-green-500 bg-green-50 text-green-700 transition"
                >
                    Time In
                </button>
                <button
                    type="button"
                    name="time_out"
                    id="manualTimeOutBtn"
                    class="flex-1 py-2 rounded border font-semibold text-sm hover:bg-red-200 border-red-500 bg-red-50 text-red-700 transition"
                >
                    Time Out
                </button>
            </div>
        </form>

        <!-- Hidden RFID Input -->
        <input type="text" name="rfid" id="rfidInput" autocomplete="off" class="sr-only">
    </div>
</aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 ml-72 flex flex-col overflow-hidden">
        <main class="p-6 overflow-y-auto flex-1">

            <!-- Current time and date display -->
            <div class="flex justify-center -mt-2">
                <div class="text-[#237339] w-full lg:w-1/2 h-32 flex flex-col items-center justify-center">
                    <div id="time" class="text-6xl font-extrabold"><?= $current_time ?></div>
                    <div class="text-xl mt-2"><?= $current_date ?></div>
                </div>
            </div>

            <!-- Instruction -->
            <div class="text-center text-gray-500 mb-2">
                Tap your RFID card or use Manual Attendance to record your attendance.
            </div>

           <form method="GET" action="index.php" class="bg-white p-2 rounded-md mb-2 text-sm max-w-xs w-full mx-auto">
    <input type="hidden" name="payroll" value="attendance">
    
    <div class="flex items-center gap-2 w-full">
        <!-- Date Input with centered text -->
        <div class="relative flex-1 min-w-0">
            <input 
                type="date" 
                id="date" 
                name="date" 
                value="<?= htmlspecialchars($filterDate ?? date('Y-m-d')) ?>"
                class="w-full p-1 text-sm border border-emerald-300 rounded focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 text-emerald-700 text-center [&::-webkit-datetime-edit-text]:p-0 [&::-webkit-datetime-edit-month-field]:p-0 [&::-webkit-datetime-edit-day-field]:p-0 [&::-webkit-datetime-edit-year-field]:p-0"
            >
        </div>
        
        <!-- Buttons -->
        <div class="flex-shrink-0 flex gap-1">
            <button type="submit" class="px-2 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded text-xs whitespace-nowrap">
                Filter <i class="bi bi-filter"></i>
            </button>
            
            <?php if (isset($_GET['date']) && $_GET['date'] !== date('Y-m-d')): ?>
                <a href="index.php?payroll=attendance" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs whitespace-nowrap">
                    Clear
                </a>
            <?php endif; ?>
        </div>
    </div>
</form>

            <!-- Table of records -->
            <div class="overflow-x-auto max-h-[60vh] rounded-lg shadow-md bg-white">
                <table class="w-full text-base min-w-[700px]">
                    <thead class="sticky top-0 bg-[#237339] text-white">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-bold">NO.</th>
                            <th class="py-3 px-4 text-left text-xs font-bold">PHOTO</th>
                            <th class="py-3 px-4 text-left text-xs font-bold">EMPLOYEE ID</th>
                            <th class="py-3 px-4 text-left text-xs font-bold">NAME</th>
                            <th class="py-3 px-4 text-left text-xs font-bold">POSITION</th>
                            <th class="py-3 px-4 text-left text-xs font-bold">TIME IN</th>
                            <th class="py-3 px-4 text-left text-xs font-bold">TIME OUT</th>
                            <th class="py-3 px-4 text-left text-xs font-bold">DATE</th>
                        </tr>
                    </thead>                  
                          <tbody id="attendance-table-body">
                                <?php if (count($attendanceRecords) > 0): ?>
                                    <?php foreach ($attendanceRecords as $index => $record): ?>
                                        <tr>
                                            <td class="py-2 px-4"><?= $index + 1 ?></td>
                                            <td class="py-2 px-4">
                                                <img src="<?= htmlspecialchars($record['photo_path'] ?: 'assets/image/default_user_image.svg') ?>" alt="Photo" class="h-10 w-10 rounded-full object-cover" />
                                            </td>
                                            <td class="py-2 text-sm px-4"><?= htmlspecialchars($record['employee_no']) ?></td>
                                            <td class="py-2 text-sm px-4"><?= htmlspecialchars(ucwords(strtolower($record['full_name']))) ?></td>

                                            <td class="py-2 text-sm px-4"><?= htmlspecialchars($record['position']) ?></td>
                                            <td class="py-2 text-sm px-4">
                                                <?= $record['time_in'] ? date('h:i A', strtotime($record['time_in'])) : '-' ?>
                                            </td>
                                            <td class="py-2 px-4 text-sm">
                                                <?= $record['time_out'] ? date('h:i A', strtotime($record['time_out'])) : '-' ?>
                                            </td>
                                            <td class="py-2 px-4 text-sm"><?= htmlspecialchars(date('F j, Y', strtotime($record['date']))) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-sm">No attendance records found<?= isset($filterDate) ? ' for this date' : '' ?>.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </main>
            </div>
        </div>
    </div>


<script>

// Real-time clock function
function updateClock() {
    const now = new Date();
    const timeElement = document.getElementById('time');
    const dateElement = document.getElementById('date');
    
    // Format time (e.g., "02:30:45 PM")
    const timeString = now.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    });
    
    // Format date (e.g., "January 1, 2023")
    const dateString = now.toLocaleDateString('en-US', {
        month: 'long',
        day: 'numeric',
        year: 'numeric'
    });
    
    if (timeElement) timeElement.textContent = timeString;
    if (dateElement) dateElement.textContent = dateString;
}

// Update clock immediately and then every second
updateClock();
setInterval(updateClock, 1000);

function formatName(str) {
  return str
    .toLowerCase()
    .split(' ')
    .map(word => word.charAt(0).toUpperCase() + word.slice(1))
    .join(' ');
}




document.addEventListener('DOMContentLoaded', () => {

    // Initialize real-time clock
    updateClock();
    setInterval(updateClock, 1000);

  const rfidInput = document.getElementById('rfidInput');
  const employeeIdInput = document.getElementById('employeeIdInput');
  const manualTimeInBtn = document.getElementById('manualTimeInBtn');
  const manualTimeOutBtn = document.getElementById('manualTimeOutBtn');

  const showSimpleAlert = (type, title, text) => {
    Swal.fire({
      icon: type,
      title: title,
      text: text,
      timer: 2500,
      showConfirmButton: false
    });
  };

  const submitAttendance = (dataObj) => {
    fetch('index.php?payroll=attendance', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams(dataObj).toString()
    })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      if (data.status === 'success') {
  const type = data.type; // 'time-in' or 'time-out'
 const rawName = data.name;
  const name = formatName(rawName); 
  const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
  const imageUrl = data.image_url || 'assets/image/default_user_image.svg';
  const popupBorderColor = type === 'time-in' ? 'rgb(76, 180, 76)' : 'rgb(255, 119, 119)';
  const toastBgColor = popupBorderColor; // Same color for toast background
  const bgColor = type === 'time-in' ? '#ecfdf5' : '#fef2f2';


  Swal.fire({
    html: `
      <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <img src="${imageUrl}" alt="Employee Photo" 
             style="height: 150px; width: 150px; border-radius: 50%; margin-top: 10px; margin-bottom: 10px; 
                    border: 2px solid ${popupBorderColor}; object-fit: cover;">
        <h2 style="margin: 5px 0 2px 0; font-weight: bold; font-size: 2rem;">${name}</h2>
        <p style="margin: 0; ">
          ${type === 'time-in' ? 'Time In successfully recorded' : 'Time Out successfully recorded'}
        </p>
       
      </div>
    `,
    // icon: 'success',
    showConfirmButton: false,
    timer: 2000, // Uncomment if you want it auto-close after 2 seconds
    customClass: {
      popup: 'swal2-popup-border'
    },
    didOpen: () => {
      const popup = document.querySelector('.swal2-popup');
      if (popup) popup.style.border = '5px solid ' + popupBorderColor;

      // Show toast simultaneously
      const toastLightBgColor = type === 'time-in' ? '#ecfdf5' : '#fef2f2'; // Tailwind: bg-green-50 / bg-red-50
        showCustomToast(`You have ${type === 'time-in' ? 'Time In' : 'Time Out'} at ${currentTime}.`, toastLightBgColor);

    }
  }).then(() => {
    // Refresh the page after the alert closes
    location.reload();
  });

} else {
  showSimpleAlert(
    data.status || 'info',
    data.status ? data.status.toUpperCase() : 'INFO',
    data.message || 'No message received.'
  );
}


// Custom toast function
function showCustomToast(message, bgColor, borderColor) {
  // Create toast container if not exists
  let container = document.getElementById('custom-toast-container');
  if (!container) {
    container = document.createElement('div');
    container.id = 'custom-toast-container';
    container.style.position = 'fixed';
    container.style.bottom = '20px';
    container.style.right = '20px';
    container.style.zIndex = 9999;
    container.style.display = 'flex';
    container.style.flexDirection = 'column';
    container.style.gap = '10px';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.style.background = bgColor;
  toast.style.color = '#133913';
  toast.style.padding = '12px 20px';
  toast.style.borderRadius = '10px';
  toast.style.fontWeight = '600';
  toast.style.fontSize = '14px';
  toast.style.opacity = '1';
  toast.style.transition = 'opacity 0.5s ease';
  toast.style.display = 'flex';
  toast.style.flexDirection = 'column';
  toast.style.width = '300px';

  // Create header element
  const header = document.createElement('strong');
  header.textContent = 'Attendance time recorded';
  header.style.fontSize = '16px';
  header.style.marginBottom = '6px';

  // Create message element
  const messageElem = document.createElement('span');
  messageElem.textContent = message;
  messageElem.style.fontWeight = 'normal';
  messageElem.style.fontSize = '14px';

  toast.appendChild(header);
  toast.appendChild(messageElem);

  container.appendChild(toast);

  // Fade out after 2 seconds and remove
  setTimeout(() => {
    toast.style.opacity = '0';
    setTimeout(() => {
      container.removeChild(toast);
      // Remove container if empty
      if (container.childElementCount === 0) container.remove();
    }, 500);
  },2000);
}


// Clear inputs & focus (still useful if there's an error)
if (rfidInput) rfidInput.value = '';
if (employeeIdInput) employeeIdInput.value = '';
if (rfidInput) rfidInput.focus();

    })
    .catch(error => {
      console.error('Fetch Error:', error);
      showSimpleAlert('error', 'Error', 'Failed to submit attendance. Please try again.');
    });
  };

  // Set focus to RFID input on page load if it exists
  if (rfidInput) {
    rfidInput.focus();
    
    // RFID auto-submit on Enter
    rfidInput.addEventListener('keypress', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        const rfid = rfidInput.value.trim();
        if (!rfid) {
          showSimpleAlert('warning', 'Missing Input', 'Please enter your RFID.');
          return;
        }
        submitAttendance({ rfid });
      }
    });
  }

  if (employeeIdInput) {
  employeeIdInput.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault(); // Stop Enter key from triggering any action
    }
  });
}

  // Manual Time-In button
  if (manualTimeInBtn) {
    manualTimeInBtn.addEventListener('click', () => {
      if (!employeeIdInput) return;
      
      const empId = employeeIdInput.value.trim();
      if (!empId) {
        showSimpleAlert('warning', 'Missing Input', 'Please enter your Employee ID.');
        employeeIdInput.focus();
        return;
      }
      submitAttendance({ employee_id: empId, manual_type: 'time-in' });
    });
  }

  // Manual Time-Out button
  if (manualTimeOutBtn) {
    manualTimeOutBtn.addEventListener('click', () => {
      if (!employeeIdInput) return;
      
      const empId = employeeIdInput.value.trim();
      if (!empId) {
        showSimpleAlert('warning', 'Missing Input', 'Please enter your Employee ID.');
        employeeIdInput.focus();
        return;
      }
      submitAttendance({ employee_id: empId, manual_type: 'time-out' });
    });
  }

  // Autofocus RFID input when clicking elsewhere
  document.body.addEventListener('click', (e) => {
    if (!rfidInput) return;
    
    const tag = e.target.tagName.toLowerCase();
    if (!['input', 'button', 'textarea'].includes(tag) && !e.target.closest('#manualAttendanceForm')) {
      rfidInput.focus();
    }
  });
});
</script>


<!-- Include footer -->
<?php require_once views_path("partials/footer"); ?>

<!-- Custom Style for SweetAlert Popup -->
<style>
.swal2-popup.custom-attendance-swal-popup {
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    padding: 20px;
    background-color: white;
    color: #333;
    border: 3px solid <?php echo isset($popup_border_color) ? $popup_border_color : 'white'; ?>;
    font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif;
}

.swal2-popup.custom-attendance-swal-popup h2 {
    font-size: 2.5rem;
    margin-bottom: 10px;
    color:rgb(10, 10, 10);
}

.swal2-popup.custom-attendance-swal-popup .swal2-html-container {
    margin: 10px 0;
    text-align: center;
}
</style>



