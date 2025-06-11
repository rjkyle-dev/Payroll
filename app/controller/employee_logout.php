<?php
session_start();
unset($_SESSION['employee']); // Only remove employee session
header("Location: index.php?payroll=login1&type=employee");
exit;

