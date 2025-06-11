<?php
$title = "Register Manager";
require_once views_path("partials/header");
echo '<script src="../public/assets/js/bootstrap/bootstrap.bundle.min.js"></script>';
echo '<script src="../public/assets/js/sweetalert2/sweetalert2.all.min.js"></script>';


?>

<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
  <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
    <div class="text-center mb-6">
      <i class="bi bi-person-plus-fill text-green-600 text-4xl"></i>
      <h2 class="text-xl font-semibold mt-2">Register New Manager</h2>
      <p class="text-gray-600">Create a new manager account</p>
    </div>

    <form action="index.php?payroll=register_manager" method="POST" id="managerRegisterForm">
      <!-- Name -->
      <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Name</label>
        <input type="text" name="name" required
          class="form-control form-control-lg ps-5 text-sm bg-[#eaf5ea] w-full rounded focus:outline-none focus:ring-2 focus:ring-green-400"
          placeholder="Enter full name">
      </div>

      <!-- Email -->
      <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Email</label>
        <input type="email" name="email" required
          class="form-control form-control-lg ps-5 text-sm bg-[#eaf5ea] w-full rounded focus:outline-none focus:ring-2 focus:ring-green-400"
          placeholder="Enter email">
      </div>

      <!-- Password -->
      <div class="mb-4">
        <label class="block text-sm font-semibold mb-1">Password</label>
        <div class="relative">
          <input type="password" name="password" id="managerRegPassword" required
            class="form-control form-control-lg ps-5 pe-10 text-sm bg-[#eaf5ea] w-full rounded focus:outline-none focus:ring-2 focus:ring-green-400"
            placeholder="Enter password">
          <span class="absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer"
                onclick="togglePassword(event, 'managerRegPassword')">
            <i class="bi bi-eye-slash text-green-600 text-lg"></i>
          </span>
        </div>
      </div>

      <!-- Submit -->
      <button type="submit"
        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-400">
        Register
      </button>
    </form>
  </div>
</div>

<script>
  function togglePassword(event, fieldId) {
    const field = document.getElementById(fieldId);
    const icon = event.currentTarget.querySelector('i');
    if (field.type === 'password') {
      field.type = 'text';
      icon.classList.replace('bi-eye-slash', 'bi-eye');
    } else {
      field.type = 'password';
      icon.classList.replace('bi-eye', 'bi-eye-slash');
    }
  }
</script>

<?php require_once views_path("partials/footer"); ?>
