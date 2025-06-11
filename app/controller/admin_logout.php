<?php
session_start();
unset($_SESSION['admin']); // Only remove admin session
header("Location: index.php?payroll=login1&type=admin");
exit;
