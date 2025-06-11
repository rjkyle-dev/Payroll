<?php
// $currentPage = $_GET['payroll'] ?? basename($_SERVER['PHP_SELF']);
require_once views_path("partials/header");
?>

<nav id="navbar" class="transition-all duration-300 fixed top-0 z-30 bg-white text-gray-800 shadow-md flex items-center justify-between px-6 py-3 h-16" 
     style="left: 250px; width: calc(100% - 250px);">


    <!-- Page Title -->
    <div class="text-lg font-semibold tracking-wide uppercase">
        Dashboard
    </div>

    <!-- Right Side -->
    <div class="flex items-center gap-4">
        <!-- Search -->
        <div class="hidden md:flex items-center bg-gray-100 rounded-md px-3 py-1">
            <input type="text" placeholder="Search..." class="bg-transparent outline-none text-sm text-gray-700" />
            <i class="bi bi-search ml-2 text-gray-600"></i>
        </div>

        <!-- Notification -->
        <button class="relative hover:bg-gray-100 p-2 rounded-full transition">
            <i class="bi bi-bell text-xl"></i>
            <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs w-4 h-4 flex items-center justify-center rounded-full">3</span>
        </button>

        <!-- User -->
        <div class="relative group">
            <button class="flex items-center gap-2 hover:bg-gray-100 px-3 py-1.5 rounded-md transition">
                <div class="bg-green-700 text-white w-8 h-8 rounded-full flex items-center justify-center font-semibold text-sm">
                    JD
                </div>
                <span class="hidden md:block text-sm font-medium">John Doe</span>
                <i class="bi bi-caret-down-fill text-xs hidden md:inline"></i>
            </button>

            <!-- Dropdown -->
            <div class="absolute right-0 mt-2 bg-white text-gray-700 rounded shadow-lg hidden group-hover:block w-40">
                <a href="index.php?payroll=profile" class="block px-4 py-2 hover:bg-gray-100">My Profile</a>
                <a href="logout.php" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
            </div>
        </div>
    </div>
</nav>

