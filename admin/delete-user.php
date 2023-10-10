<?php
include "config.php";

// Start the session
session_start();

// Check user role and permissions
if ($_SESSION['role'] != '1' && $_SESSION['role'] != '2' && $_SESSION['role'] != '3') {
    echo "You don't have the required permissions.";
    exit();
}

$id = $_GET['id'];

// Delete the user
$sql_delete_user = "DELETE FROM users WHERE user_id='$id'";

if(mysqli_query($con, $sql_delete_user)){
    header("Location:$hostname/admin/users.php");
} else {
    echo "Error deleting user: " . mysqli_error($con);
}
?>
