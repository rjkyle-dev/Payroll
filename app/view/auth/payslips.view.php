<?php
$title = "Payslips";
require_once views_path("partials/header");
require_once views_path("partials/sidebar");
require_once views_path("partials/nav");
?>

<main class="font-sans flex-1 bg-[#f8fbf8] overflow-auto mt-12 p-4 md:p-6 ml-[255px]">
  <div class="space-y-6">
    <!-- Header -->
    <div>
      <span class="text-2xl font-bold tracking-tight">Payslips</span>
      <p class="text-[#478547]">View and manage employee payslips</p>
    </div>

    <!-- Card -->
    <div class="rounded-lg border-2 border-green-200 bg-card text-card-foreground shadow-sm bg-white"
    data-aos="fade-in" 
                    data-aos-delay="<?= $index * 1 ?>"
                    data-aos-duration="500">
      <!-- Card Header -->
      <div class="space-y-1.5 p-6 flex flex-row items-center justify-between">
        <span class="text-xl md:text-2xl font-semibold text-[#133913]">All Employee Payslips</span>

        <!-- Search Bar -->
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

      <!-- Card Body -->
      <div class="p-6 pt-0 ">
        <div id="table-container" class="relative overflow-y-auto max-h-[350px] w-full max-w-full transition-all duration-300">
            <table class="min-w-full table-auto caption-bottom text-xs md:text-sm">
            <thead class="[&_tr]:border-b bg-white sticky top-0 z-10">
                <tr class="border-b transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
                <th class="h-10 md:h-12 px-2 md:px-4 text-left align-middle font-bold text-[#478547]">#</th>
                <th class="h-10 md:h-12 px-2 md:px-4 text-left align-middle font-bold text-[#478547]">Employee</th>
                <th class="h-10 md:h-12 px-2 md:px-4 text-left align-middle font-bold text-[#478547]">Period</th>
                <th class="h-10 md:h-12 px-2 md:px-4 text-left align-middle font-bold text-[#478547]">Issue Date</th>
                <th class="h-10 md:h-12 px-2 md:px-4 text-left align-middle font-bold text-[#478547]">Net Pay</th>
                <th class="h-10 md:h-12 px-2 md:px-4 text-left align-middle font-bold text-[#478547]">Status</th>
                <th class="h-10 md:h-12 px-2 md:px-4 text-right align-middle font-bold text-[#478547]">Actions</th>
                </tr>
            </thead>
            <tbody class="[&_tr:last-child]:border-0">
            <!-- Employee 1 -->
            <tr class="border-b transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
                <td class="p-2 md:p-4 align-middle ">1</td>
                <td class="p-2 md:p-4 align-middle">Michael Reyes</td>
                <td class="p-2 md:p-4 align-middle">Apr 01 - Apr 15, 2024</td>
                <td class="p-2 md:p-4 align-middle">Apr 16, 2024</td>
                <td class="p-2 md:p-4 align-middle">₱25,400</td>
                <td class="p-2 md:p-4 align-middle">
                <div class="inline-flex items-center rounded-full border border-transparent bg-[#16a249] text-white px-2.5 py-0.5 text-xs font-semibold">
                    PAID
                </div>
                </td>
                <td class="p-2 md:p-4 align-middle text-right">
                <button class="inline-flex h-8 w-8 md:h-10 md:w-10 items-center justify-center rounded-md font-medium transition-colors hover:bg-[#478547] hover:text-white" onclick="openPayslip()" type="button">
                    <i class="bi bi-eye h-5 w-5 md:h-7 md:w-7 text-lg"></i>
                </button>
                </td>
            </tr>

            <!-- Employee 2 -->
            <tr class="border-b transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
                <td class="p-2 md:p-4 align-middle">2</td>
                <td class="p-2 md:p-4 align-middle">Anna Cruz</td>
                <td class="p-2 md:p-4 align-middle">Apr 01 - Apr 15, 2024</td>
                <td class="p-2 md:p-4 align-middle">Apr 16, 2024</td>
                <td class="p-2 md:p-4 align-middle">₱19,850</td>
                <td class="p-2 md:p-4 align-middle">
                <div class="inline-flex items-center rounded-full border border-transparent bg-[#16a249] text-white px-2.5 py-0.5 text-xs font-semibold">
                    PAID
                </div>
                </td>
                <td class="p-2 md:p-4 align-middle text-right">
                <button class="inline-flex h-8 w-8 md:h-10 md:w-10 items-center justify-center rounded-md font-medium transition-colors hover:bg-[#478547] hover:text-white" onclick="openPayslip()" type="button">
                    <i class="bi bi-eye h-5 w-5 md:h-7 md:w-7 text-lg"></i>
                </button>
                </td>
            </tr>

            <!-- Employee 3 -->
            <tr class="border-b transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
                <td class="p-2 md:p-4 align-middle">3</td>
                <td class="p-2 md:p-4 align-middle">Carlos Dela Cruz</td>
                <td class="p-2 md:p-4 align-middle">Apr 01 - Apr 15, 2024</td>
                <td class="p-2 md:p-4 align-middle">Apr 16, 2024</td>
                <td class="p-2 md:p-4 align-middle">₱21,100</td>
                <td class="p-2 md:p-4 align-middle">
                <div class="inline-flex items-center rounded-full border border-transparent bg-[#16a249] text-white px-2.5 py-0.5 text-xs font-semibold">
                    PAID
                </div>
                </td>
                <td class="p-2 md:p-4 align-middle text-right">
                <button class="inline-flex h-8 w-8 md:h-10 md:w-10 items-center justify-center rounded-md font-medium transition-colors hover:bg-[#478547] hover:text-white" onclick="openPayslip()" type="button">
                    <i class="bi bi-eye h-5 w-5 md:h-7 md:w-7 text-lg"></i>
                </button>
                </td>
            </tr>

            <!-- Employee 4 -->
            <tr class="border-b transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
                <td class="p-2 md:p-4 align-middle">4</td>
                <td class="p-2 md:p-4 align-middle">Sophia Mendoza</td>
                <td class="p-2 md:p-4 align-middle">Apr 01 - Apr 15, 2024</td>
                <td class="p-2 md:p-4 align-middle">Apr 16, 2024</td>
                <td class="p-2 md:p-4 align-middle">₱23,000</td>
                <td class="p-2 md:p-4 align-middle">
                <div class="inline-flex items-center rounded-full border border-transparent bg-[#16a249] text-white px-2.5 py-0.5 text-xs font-semibold">
                    PAID
                </div>
                </td>
                <td class="p-2 md:p-4 align-middle text-right">
                <button class="inline-flex h-8 w-8 md:h-10 md:w-10 items-center justify-center rounded-md font-medium transition-colors hover:bg-[#478547] hover:text-white" onclick="openPayslip()" type="button">
                    <i class="bi bi-eye h-5 w-5 md:h-7 md:w-7 text-lg"></i>
                </button>
                </td>
            </tr>

            <!-- Employee 5 -->
            <tr class="border-b transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
                <td class="p-2 md:p-4 align-middle">5</td>
                <td class="p-2 md:p-4 align-middle">Daniel Garcia</td>
                <td class="p-2 md:p-4 align-middle">Apr 01 - Apr 15, 2024</td>
                <td class="p-2 md:p-4 align-middle">Apr 16, 2024</td>
                <td class="p-2 md:p-4 align-middle">₱20,500</td>
                <td class="p-2 md:p-4 align-middle">
                <div class="inline-flex items-center rounded-full border border-transparent bg-[#16a249] text-white px-2.5 py-0.5 text-xs font-semibold">
                    PAID
                </div>
                </td>
                <td class="p-2 md:p-4 align-middle text-right">
                <button class="inline-flex h-8 w-8 md:h-10 md:w-10 items-center justify-center rounded-md font-medium transition-colors hover:bg-[#478547] hover:text-white" onclick="openPayslip()" type="button">
                    <i class="bi bi-eye h-5 w-5 md:h-7 md:w-7 text-lg"></i>
                </button>
                </td>
            </tr>
            <!-- Additional Employees -->

<!-- Employee 6 -->
<tr class="border-b transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
  <td class="p-2 md:p-4 align-middle">6</td>
  <td class="p-2 md:p-4 align-middle">Patricia Santos</td>
  <td class="p-2 md:p-4 align-middle">Apr 01 - Apr 15, 2024</td>
  <td class="p-2 md:p-4 align-middle">Apr 16, 2024</td>
  <td class="p-2 md:p-4 align-middle">₱24,750</td>
  <td class="p-2 md:p-4 align-middle">
    <div class="inline-flex items-center rounded-full border border-transparent bg-[#16a249] text-white px-2.5 py-0.5 text-xs font-semibold">
      PAID
    </div>
  </td>
  <td class="p-2 md:p-4 align-middle text-right">
    <button class="inline-flex h-8 w-8 md:h-10 md:w-10 items-center justify-center rounded-md font-medium transition-colors hover:bg-[#478547] hover:text-white" onclick="openPayslip()" type="button">
      <i class="bi bi-eye h-5 w-5 md:h-7 md:w-7 text-lg"></i>
    </button>
  </td>
</tr>

<!-- Employee 7 -->
<tr class="border-b transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
  <td class="p-2 md:p-4 align-middle">7</td>
  <td class="p-2 md:p-4 align-middle">John Paul Ramirez</td>
  <td class="p-2 md:p-4 align-middle">Apr 01 - Apr 15, 2024</td>
  <td class="p-2 md:p-4 align-middle">Apr 16, 2024</td>
  <td class="p-2 md:p-4 align-middle">₱22,300</td>
  <td class="p-2 md:p-4 align-middle">
    <div class="inline-flex items-center rounded-full border border-transparent bg-[#16a249] text-white px-2.5 py-0.5 text-xs font-semibold">
      PAID
    </div>
  </td>
  <td class="p-2 md:p-4 align-middle text-right">
    <button class="inline-flex h-8 w-8 md:h-10 md:w-10 items-center justify-center rounded-md font-medium transition-colors hover:bg-[#478547] hover:text-white" onclick="openPayslip()" type="button">
      <i class="bi bi-eye h-5 w-5 md:h-7 md:w-7 text-lg"></i>
    </button>
  </td>
</tr>

<!-- Employee 8 -->
<tr class="border-b transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
  <td class="p-2 md:p-4 align-middle">8</td>
  <td class="p-2 md:p-4 align-middle">Isabelle Fernandez</td>
  <td class="p-2 md:p-4 align-middle">Apr 01 - Apr 15, 2024</td>
  <td class="p-2 md:p-4 align-middle">Apr 16, 2024</td>
  <td class="p-2 md:p-4 align-middle">₱18,900</td>
  <td class="p-2 md:p-4 align-middle">
    <div class="inline-flex items-center rounded-full border border-transparent bg-[#16a249] text-white px-2.5 py-0.5 text-xs font-semibold">
      PAID
    </div>
  </td>
  <td class="p-2 md:p-4 align-middle text-right">
    <button class="inline-flex h-8 w-8 md:h-10 md:w-10 items-center justify-center rounded-md font-medium transition-colors hover:bg-[#478547] hover:text-white" onclick="openPayslip()" type="button">
      <i class="bi bi-eye h-5 w-5 md:h-7 md:w-7 text-lg"></i>
    </button>
  </td>
</tr>

<!-- Employee 9 -->
<tr class="border-b transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
  <td class="p-2 md:p-4 align-middle">9</td>
  <td class="p-2 md:p-4 align-middle">Gabriel Aquino</td>
  <td class="p-2 md:p-4 align-middle">Apr 01 - Apr 15, 2024</td>
  <td class="p-2 md:p-4 align-middle">Apr 16, 2024</td>
  <td class="p-2 md:p-4 align-middle">₱26,700</td>
  <td class="p-2 md:p-4 align-middle">
    <div class="inline-flex items-center rounded-full border border-transparent bg-[#16a249] text-white px-2.5 py-0.5 text-xs font-semibold">
      PAID
    </div>
  </td>
  <td class="p-2 md:p-4 align-middle text-right">
    <button class="inline-flex h-8 w-8 md:h-10 md:w-10 items-center justify-center rounded-md font-medium transition-colors hover:bg-[#478547] hover:text-white" onclick="openPayslip()" type="button">
      <i class="bi bi-eye h-5 w-5 md:h-7 md:w-7 text-lg"></i>
    </button>
  </td>
</tr>

<!-- Employee 10 -->
<tr class="border-b transition-colors hover:bg-[#f2f8f2] even:bg-[#cde4cd]">
  <td class="p-2 md:p-4 align-middle">10</td>
  <td class="p-2 md:p-4 align-middle">Marianne Lopez</td>
  <td class="p-2 md:p-4 align-middle">Apr 01 - Apr 15, 2024</td>
  <td class="p-2 md:p-4 align-middle">Apr 16, 2024</td>
  <td class="p-2 md:p-4 align-middle">₱20,950</td>
  <td class="p-2 md:p-4 align-middle">
    <div class="inline-flex items-center rounded-full border border-transparent bg-[#16a249] text-white px-2.5 py-0.5 text-xs font-semibold">
      PAID
    </div>
  </td>
  <td class="p-2 md:p-4 align-middle text-right">
    <button class="inline-flex h-8 w-8 md:h-10 md:w-10 items-center justify-center rounded-md font-medium transition-colors hover:bg-[#478547] hover:text-white" onclick="openPayslip()" type="button">
      <i class="bi bi-eye h-5 w-5 md:h-7 md:w-7 text-lg"></i>
    </button>
  </td>
</tr>

            </tbody>

          </table>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Overlay and Modal -->
<div id="payslip-overlay" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center opacity-0 transition-opacity duration-300">
  <!-- Payslip Dialog -->
  <div role="dialog" id="payslip-dialog" aria-describedby="payslip-description" aria-labelledby="payslip-title"
    class="relative grid w-full max-w-3xl gap-4 border bg-[#f8fbf8] p-6 shadow-lg sm:rounded-lg overflow-y-auto max-h-[90vh] scale-75 transition-transform duration-300">
    
    <!-- Close Button (X) -->
    <button class="absolute top-4 right-4 text-3xl font-bold ring-offset-[#f8fbf8] focus:ring-2 focus:ring-[#16a249] rounded-md" onclick="closePayslip()">
  <i class="bi bi-x"></i>
</button>



    
    <div class="flex flex-col space-y-1.5 text-left sm:text-left">
      <h2 id="payslip-title" class="text-lg font-semibold leading-none tracking-tight">Payslip Details</h2>
    </div>

    <!-- Start of Payslip Content -->
    <div class="space-y-6" id="payslip-content">
      <div class="flex justify-between items-start">
        <div>
          <h2 class="text-2xl font-bold">Migrants Venture Corporation</h2>
          <p class="text-[#478547]">123 Business Ave., Metro Manila</p>
        </div>
        <div class="text-right">
          <h3 class="font-bold">PAYSLIP</h3>
          <p class="text-sm">Mar 01 - Mar 15, 2024</p>
        </div>
      </div>

      <div class="h-[1px] w-full bg-border"></div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <h3 class="font-semibold mb-2">Employee Information</h3>
          <div class="space-y-1 text-sm">
            <p><span class="font-medium">Name:</span> John Doe</p>
            <p><span class="font-medium">ID:</span> EMP001</p>
            <p><span class="font-medium">Position:</span> HR Manager</p>
            <p><span class="font-medium">Department:</span> Human Resources</p>
          </div>
        </div>
        <div>
            <h3 class="font-semibold mb-2">Payment Details</h3>
            <div class="space-y-1 text-sm">
                <p><span class="font-medium">Basic Salary:</span> ₱50,000 / month</p>
                <p><span class="font-medium">Pay Period:</span> Mar 01 - Mar 15, 2024</p>
                <p><span class="font-medium">Payment Date:</span> Mar 16, 2024</p>
                <div class="flex items-center space-x-2">
                    <span class="font-medium">Payment Status:</span>
                    <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold">PAID</span>
                </div>
            </div>
        </div>
      </div>

      <div class="h-[1px] w-full bg-border"></div>

      <div class="space-y-4">
        <h3 class="font-semibold">Earnings & Deductions</h3>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <h4 class="text-sm font-medium mb-2">Earnings</h4>
            <table class="w-full text-sm">
              <tbody>
                <tr class="border-b">
                  <td class="p-2">Basic Pay</td>
                  <td class="p-2 text-right">₱25,000</td>
                </tr>
                <tr class="border-b">
                  <td class="p-2">Overtime</td>
                  <td class="p-2 text-right">₱1,500</td>
                </tr>
                <tr class="font-bold">
                  <td class="p-2 text-[#478547]">Total Earnings</td>
                  <td class="p-2 text-right font-semibold">₱26,500</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div>
            <h4 class="text-sm font-medium mb-2">Deductions</h4>
            <table class="w-full text-sm">
              <tbody>
                <tr class="border-b">
                  <td class="p-2">Tax</td>
                  <td class="p-2 text-right">₱2,500</td>
                </tr>
                <tr class="border-b">
                  <td class="p-2">SSS</td>
                  <td class="p-2 text-right">₱1,000</td>
                </tr>
                <tr class="border-b">
                  <td class="p-2">PhilHealth</td>
                  <td class="p-2 text-right">₱375</td>
                </tr>
                <tr class="border-b">
                  <td class="p-2">Pag-IBIG</td>
                  <td class="p-2 text-right">₱100</td>
                </tr>
                <tr class="font-bold">
                  <td class="p-2 text-[#478547]">Total Deductions</td>
                  <td class="p-2 text-right">₱3,925</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <hr class="shrink-0 bg-[#cde4cd] h-[1px] w-full">
        <div class="bg-[#f2f8f2] grid grid-cols-2 gap-4 p-4 rounded-lg">
            <div>
                <h4 class="font-semibold">Net Pay</h4>
                <p class="text-xs text-[#478547]">Total earnings minus total deductions</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-lg">₱22,000</p>
            </div>
            </div>
      </div>
    </div>
    <!-- End of Payslip Content -->

    <!-- Action Buttons -->
    <div class="flex justify-end gap-4 mt-6" id="payslip-buttons">
      <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md border border-[#cde4cd] bg-[#f8fbf8] px-4 py-2 text-sm font-medium ring-offset-[#f8fbf8] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#16a249] focus-visible:ring-offset-2 hover:bg-[#16a249] hover:text-[#ffffff] disabled:pointer-events-none disabled:opacity-50 w-32" onclick="downloadPayslip()">
      <i class="bi bi-download me-2 fs-5"></i>
      Download</button>
      <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md bg-[#16a249] text-[#ffffff] hover:bg-[#16a249]/90 text-sm font-medium ring-offset-[#f8fbf8] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#16a249] focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 w-32" onclick="printPayslip()">
      <i class="bi bi-printer me-2 fs-5"></i>
      Print</button>
    </div>

  </div>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script>
    // Function to adjust table height based on fullscreen mode
  function adjustTableHeight() {
    const tableContainer = document.getElementById('table-container');
    
    // If fullscreen mode is active, set max height to full height
    if (document.fullscreenElement || window.innerHeight === screen.height) {
      tableContainer.classList.remove('max-h-[350px]');
      tableContainer.classList.add('max-h-[60vh]');
    } else {
      // Otherwise, set the max height to 350px
      tableContainer.classList.remove('max-h-[60vh]');
      tableContainer.classList.add('max-h-[350px]');
    }
  }

  // Listen for fullscreen changes and window resize events
  document.addEventListener('fullscreenchange', adjustTableHeight);
  window.addEventListener('resize', adjustTableHeight);

  // Initial check when the page loads
  window.addEventListener('load', adjustTableHeight);

  // Function to clear the input field
  function clearInput() {
    const inputField = document.getElementById('searchInput');
    inputField.value = '';  // Clear the input field
    toggleClearButton();  // Hide the clear button
  }

  // Function to toggle the visibility of the clear button based on input content
  function toggleClearButton() {
    const inputField = document.getElementById('searchInput');
    const clearButton = document.getElementById('clearButton');
    if (inputField.value.length > 0) {
      clearButton.classList.remove('hidden');  // Show the clear button
    } else {
      clearButton.classList.add('hidden');  // Hide the clear button
    }
  }

  // Open modal
  function openPayslip() {
    const overlay = document.getElementById("payslip-overlay");
    const dialog = document.getElementById("payslip-dialog");

    overlay.classList.remove("hidden");

    // Smooth transition for overlay
    overlay.classList.remove("opacity-0");
    overlay.classList.add("opacity-100");

    // Smooth transition for dialog (scale-up effect)
    dialog.classList.remove("scale-75");
    dialog.classList.add("scale-100");

    // Add event listener to close modal when clicking outside
    overlay.addEventListener('click', closePayslip);
  }

  // Close modal
  function closePayslip() {
    const overlay = document.getElementById("payslip-overlay");
    const dialog = document.getElementById("payslip-dialog");

    // Smooth transition for overlay
    overlay.classList.remove("opacity-100");
    overlay.classList.add("opacity-0");

    // Smooth transition for dialog (scale-down effect)
    dialog.classList.remove("scale-100");
    dialog.classList.add("scale-75");

    setTimeout(() => {
      overlay.classList.add("hidden");
    }, 200); // Delay to match animation duration

    // Remove the event listener to prevent multiple listeners being added
    overlay.removeEventListener('click', closePayslip);
  }

  // Print function
  function printPayslip() {
    var printContent = document.getElementById('payslip-content');
    var printWindow = window.open('', '', 'height=600,width=800');
    printWindow.document.write('<html><head><title>Payslip</title>');
    printWindow.document.write('</head><body>');
    printWindow.document.write(printContent.innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
  }

  // Download as PDF
  function downloadPayslip() {
    // Show loading toast
    Swal.fire({
      title: 'Downloading Payslip...',
      text: 'Please wait...',
      icon: 'info',
      showConfirmButton: false,
      allowOutsideClick: false,
      willOpen: () => {
        Swal.showLoading();
      }
    });

    // Hide the buttons temporarily
    document.getElementById('payslip-buttons').style.display = 'none';

    var element = document.getElementById('payslip-content');
    var opt = {
      margin:       0.5,
      filename:     'payslip.pdf',
      image:        { type: 'jpeg', quality: 0.98 },
      html2canvas:  { scale: 2 },
      jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
    };

    html2pdf().from(element).set(opt).save().then(() => {
      // After download, show the buttons back and close the modal
      document.getElementById('payslip-buttons').style.display = 'flex';
      closePayslip();
      Swal.close();  // Close the loading toast
    });
  }
</script>



<?php require_once views_path("partials/footer"); ?>






<!-- Script to download in excel -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script> Include the xlsx library -->

<!-- /*<script>
    // Function to clear the input field
    function clearInput() {
        const inputField = document.getElementById('searchInput');
        inputField.value = '';  // Clear the input field
        toggleClearButton();  // Hide the clear button
    }

    // Function to toggle the visibility of the clear button based on input content
    function toggleClearButton() {
        const inputField = document.getElementById('searchInput');
        const clearButton = document.getElementById('clearButton');
        if (inputField.value.length > 0) {
            clearButton.classList.remove('hidden');  // Show the clear button
        } else {
            clearButton.classList.add('hidden');  // Hide the clear button
        }
    }

    // Open modal
    function openPayslip() {
        const overlay = document.getElementById("payslip-overlay");
        const dialog = document.getElementById("payslip-dialog");
        
        overlay.classList.remove("hidden");
        
        // Smooth transition for overlay
        overlay.classList.remove("opacity-0");
        overlay.classList.add("opacity-100");
        
        // Smooth transition for dialog (scale-up effect)
        dialog.classList.remove("scale-75");
        dialog.classList.add("scale-100");
    }

    // Close modal
    function closePayslip() {
        const overlay = document.getElementById("payslip-overlay");
        const dialog = document.getElementById("payslip-dialog");
        
        // Smooth transition for overlay
        overlay.classList.remove("opacity-100");
        overlay.classList.add("opacity-0");
        
        // Smooth transition for dialog (scale-down effect)
        dialog.classList.remove("scale-100");
        dialog.classList.add("scale-75");
        
        setTimeout(() => {
            overlay.classList.add("hidden");
        }, 200); // Delay to match animation duration
    }

    // Print function
    function printPayslip() {
        var printContent = document.getElementById('payslip-content');
        var printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Payslip</title>');
        printWindow.document.write('</head><body>');
        printWindow.document.write(printContent.innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }

    // Download as Excel
    function downloadPayslip() {
        // Show loading toast
        Swal.fire({
            title: 'Downloading Payslip...',
            text: 'Please wait...',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        // Hide the buttons temporarily
        document.getElementById('payslip-buttons').style.display = 'none';

        // Grab the payslip content
        var element = document.getElementById('payslip-content');

        // Convert the content to a worksheet
        var ws = XLSX.utils.table_to_sheet(element);

        // Create a new workbook and append the worksheet
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Payslip");

        // Download the workbook as an Excel file
        XLSX.writeFile(wb, "payslip.xlsx").then(() => {
            // Close the loading toast after the file is downloaded
            Swal.close();

            // After download, show the buttons back and close the modal
            document.getElementById('payslip-buttons').style.display = 'flex';
            closePayslip();
            Swal.close();  // Close the loading toast
        });
    }
</script>*/ -->
