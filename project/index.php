<?php
session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        header("Location: dashboard_admin.php");
    } elseif ($_SESSION['role'] == 'user') {
        header("Location: dashboard_user.php");
    }
} else {
    header("Location: login.php");
}
?>
