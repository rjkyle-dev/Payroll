<?php
$title = "My Profile";
require_once views_path("partials/header");

echo '<script src="../public/assets/js/bootstrap/bootstrap.bundle.min.js"></script>';
echo '<script src="../public/assets/js/sweetalert2/sweetalert2.all.min.js"></script>';


?>

<div class="flex min-h-screen overflow-hidden">
    <!-- Main content -->
    <main id="mainContent" class="flex-1 p-6 bg-gray-100 transition-margin duration-300 ease-in-out" style="margin-left: 256px;">
        <?php require_once views_path("branch/branch_sidebar"); ?>

        <div>
            <span class="text-2xl font-bold tracking-tight">My Profile</span>
            <p class="text-gray-600">View and manage your personal information.</p>
        </div>

        <div class="max-w-4xl border-2 border-emerald-600 mx-auto mt-8 bg-white shadow-sm rounded-lg p-6">
            <div class="flex flex-col items-center text-center space-y-4 mt-2">
                <!-- Profile Image Placeholder for Manager -->
                <img src="../public/assets/image/man (1).png"
                     alt="Profile Photo"
                     class="w-32 h-32 rounded-full  border-2 border-emerald-600 shadow">

                <!-- Manager Name and Branch -->
                <div class="flex flex-row gap-6 justify-center">
                    <div>
             <p class="text-md text-gray-400"><?= htmlspecialchars($managers['name']) ?> | <?= htmlspecialchars($managers['branch'] ?? 'N/A') ?></p>
        </div>
                </div>

                <div class="-mt-4 mb-4">
                    <a href="index.php?payroll=edit_profile" class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2 rounded shadow-sm">
                        <i class="bi bi-pencil-fill mr-2"></i> Edit Profile
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Email</label>
                    <p class="text-gray-800 bg-gray-100 p-2 rounded">
                        <?= htmlspecialchars(($managers['email'] ?? 'N/A')) ?>
                    </p>

                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Branch</label>
                    <p class="text-gray-800 bg-gray-100 p-2 rounded">
                        <?= htmlspecialchars(ucwords($managers['branch'] ?? 'N/A')) ?>
                    </p>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Created At</label>
                    <p class="text-gray-800 bg-gray-100 p-2 rounded">
                        <?= isset($managers['created_at']) ? htmlspecialchars(date("F d, Y", strtotime($managers['created_at']))) : 'N/A' ?>
                    </p>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Last Updated</label>
                    <p class="text-gray-800 bg-gray-100 p-2 rounded">
                        <?= isset($managers['updated_at']) ? htmlspecialchars(date("F d, Y", strtotime($managers['updated_at']))) : 'N/A' ?>
                    </p>
                </div>
            </div>
        </div>
    </main>
</div>
