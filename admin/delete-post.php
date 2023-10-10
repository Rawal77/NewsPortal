<?php

include "config.php";
include "../phpMailer.php";
$post_id = $_GET['id'];
$cat_id = $_GET['catid'];


$sql1 = "SELECT * FROM post WHERE post_id = $post_id";
$result = mysqli_query($con,$sql1);
$row = mysqli_fetch_assoc($result);
unlink("upload/".$row['post_img']);




$sql = "DELETE FROM post WHERE post_id=$post_id;";
$sql .= "UPDATE category SET no_of_post = no_of_post -1 WHERE category_id = $cat_id";
$sql2 = "SELECT * FROM post JOIN category ON post.category = category.category_id
    JOIN users ON post.users = users.user_id WHERE post_id='$post_id'";
    $res2 = mysqli_query($con,$sql2);
    $row2 = mysqli_fetch_assoc($res2);
    $username = $row2['username'];
    $date = date("d--m-y");
    // phpmailer('raolgins@gmail.com',"News has been deleted by '$username' on '$date'");
// phpmailer('raolgins@gmail.com',"News has been deleted by '$author' on '$date'");


if(mysqli_multi_query($con,$sql)){
    header("Location: $hostname/admin/post.php");
}else{
    echo "query failed";
}
?>