<?php
include "config.php";
session_start();
if(!isset($_SESSION['username'])){
    header("Location: $hostname/admin/");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel ="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <header class="bg-info text-white p-3">
        <div class="container d-flex justify-content-between">
            <img src="./logo.svg" alt="" class="img-fluid">
            <span class="text-dark m-2">Hello <?= $_SESSION['username'] ;?></span>
            <a href="./logout.php" class="btn btn-outline-dark">Logout</a>
        </div>
    </header>
    <nav class="navbar navbar-expand-lg bg-light nav-secondary">
        <div class="container">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="post.php" class="nav-link  lead"><h6>Post</h6></a>
                </li>
                <?php 
                if($_SESSION['role'] == '3'){
                ?>
                <li class="nav-item">
                    <a href="category.php" class="nav-link lead"><h6>Category</h6></a>
                </li>
                <li class="nav-item">
                    <a href="users.php" class="nav-link  lead"><h6>Users</h6></a>
                </li>
              <?php } ?>
            </ul>
        </div>
    </nav>