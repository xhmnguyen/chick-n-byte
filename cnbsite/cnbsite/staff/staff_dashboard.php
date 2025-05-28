<?php
session_start();
if (!isset($_SESSION['staff_id'])) {
    header("Location: staff_login.php");
    exit();
}

$role = $_SESSION['role'];

switch ($role) {
    case 'delivery_driver':
        header("Location: delivery_dashboard.php");
        break;
    case 'kitchen_staff':
        header("Location: kitchen_dashboard.php");
        break;
    case 'manager':
        header("Location: manager_dashboard.php");
        break;
    default:
        echo "Invalid role.";
        session_destroy();
        exit();
}
?>