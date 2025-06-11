<?php
$title = "Admin Registration"; 
require_once views_path("partials/header");
?>

<div class="min-h-screen bg-[#f8fbf8] flex items-center justify-center p-4">
    <div class="max-w-4xl w-full bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <!-- Left Section with Image -->
            <div class="hidden md:block bg-[#f2f8f2] p-6">
                <div class="h-full flex flex-col items-center justify-center">
                    <img src="../public/assets/image/image2.svg" alt="Register Illustration" class="w-full max-w-xs">
                    <div class="mt-6 text-center">
                        <h2 class="text-xl font-bold text-[#133913]">Welcome to Migrants Venture</h2>
                        <p class="mt-2 text-sm text-[#478547]">Join our team and manage the system efficiently</p>
                    </div>
                </div>
            </div>

            <!-- Right Section with Register Form -->
            <div class="p-6 md:p-8">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-[#133913]">Admin Registration</h2>
                    <p class="mt-2 text-[#478547]">Create your admin account to get started</p>
                </div>

                <!-- Displaying Error or Success Message -->
                <?php if(isset($msg)): ?>
                    <div class="mb-6 p-2 rounded-lg animate-fade-in <?php echo strpos($msg, 'successfully') !== false ? 'text-green-800' : 'text-red-800'; ?>">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-[#133913] mb-1">Full Name</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="w-full px-3 py-2 text-sm rounded-lg border border-[#cde4cd] focus:outline-none focus:ring-2 focus:ring-[#16a249] focus:border-transparent transition-all duration-200"
                               placeholder="Enter your full name"
                               value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>"
                               required>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-[#133913] mb-1">Email Address</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="w-full px-3 py-2 text-sm rounded-lg border border-[#cde4cd] focus:outline-none focus:ring-2 focus:ring-[#16a249] focus:border-transparent transition-all duration-200"
                               placeholder="Enter your email address"
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                               required>
                    </div>

                    <div class="relative">
                        <label for="password" class="block text-sm font-medium text-[#133913] mb-1">Password</label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full px-3 py-2 text-sm rounded-lg border border-[#cde4cd] focus:outline-none focus:ring-2 focus:ring-[#16a249] focus:border-transparent transition-all duration-200 pr-10"
                               placeholder="Enter your password"
                               required>
                        <button type="button" 
                                id="togglePassword" 
                                class="absolute right-3 mt-[19px] -translate-y-1/2 text-[#478547] hover:text-[#16a249] transition-colors duration-200">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>

                    <div class="relative">
                        <label for="confirmPassword" class="block text-sm font-medium text-[#133913] mb-1">Confirm Password</label>
                        <input type="password" 
                               id="confirmPassword" 
                               name="confirm-password" 
                               class="w-full px-3 py-2 text-sm rounded-lg border border-[#cde4cd] focus:outline-none focus:ring-2 focus:ring-[#16a249] focus:border-transparent transition-all duration-200 pr-10"
                               placeholder="Confirm your password"
                               required>
                        <button type="button" 
                                id="toggleConfirmPassword" 
                                class="absolute right-3 mt-[19px] -translate-y-1/2 text-[#478547] hover:text-[#16a249] transition-colors duration-200">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>

                    <button type="submit" 
                            name="submit" 
                            class="w-full py-2.5 px-4 bg-[#16a249] text-white rounded-lg font-medium hover:bg-[#16a249]/90 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#16a249] focus:ring-offset-2">
                        Register
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-[#478547]">
                        Already registered? 
                        <a href="index.php?payroll=login1" class="text-[#16a249] hover:text-[#133913] font-medium transition-colors duration-200">
                            Log in
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-out;
    }

    input:focus {
        transform: translateY(-1px);
    }

    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        z-index: 50;
        animation: slideIn 0.3s ease-out;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    .notification.success {
        color: #16a249;
        border: 1px solid #16a249;
        background-color: #f0fdf4;
    }

    .notification.error {
        color: #dc2626;
        border: 1px solid #dc2626;
        background-color: #fef2f2;
    }
</style>

<script>
    // Password toggle functionality
    function togglePasswordVisibility(inputId, buttonId) {
        const input = document.getElementById(inputId);
        const button = document.getElementById(buttonId);
        const icon = button.querySelector('i');

        button.addEventListener('click', () => {
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    }

    // Initialize password toggles
    togglePasswordVisibility('password', 'togglePassword');
    togglePasswordVisibility('confirmPassword', 'toggleConfirmPassword');

    // Form validation and notification
    document.querySelector('form').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (password !== confirmPassword) {
            e.preventDefault();
            showNotification('Passwords do not match!', 'error');
        }
    });

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Add input focus animations
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', () => {
            input.classList.add('transform', 'transition-transform', 'duration-200');
        });
        input.addEventListener('blur', () => {
            input.classList.remove('transform', 'transition-transform', 'duration-200');
        });
    });
</script>

<?php require views_path("/partials/footer"); ?>
