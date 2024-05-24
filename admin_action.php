<?php
session_start();
if (!isset($_SESSION['adminloginid'])) {
    header("Location: admin_login.php"); // Redirect to admin login page if admin is not logged in
    exit;
}

// Include database connection
include_once 'admin_connection.php';

// Check if delete user button is clicked
if(isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    $sql = "DELETE FROM users WHERE Uid = $user_id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_users.php"); // Redirect to admin users page after deleting user
        exit;
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}
?>
