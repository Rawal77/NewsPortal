<?php
include "config.php";
session_start();
if($_SESSION['role'] == '1' || $_SESSION['role'] == '2'){
    header("Location: $hostname/admin/post.php");
}
$id = $_GET['id'];
$sql = "DELETE FROM category WHERE category_id='$id'";
if(mysqli_query($con,$sql)){
header("Location:$hostname/admin/category.php");
}else{
    echo "<p>There is something wrong while deleteing the user</p>";
}

?>