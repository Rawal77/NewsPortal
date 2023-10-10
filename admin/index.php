<?php
include "config.php";
session_start();
if(isset($_SESSION['username'])){
    header("Location: $hostname/admin/post.php");
}


if (isset($_POST['login'])) {
    $uname = mysqli_real_escape_string($con, $_POST['username']);
    $opwd = $_POST['password'];
    $pwd = mysqli_real_escape_string($con, md5($_POST['password']));
    if (empty($uname)) {
        $error = "Username is required";
    } else if(empty($opwd)){
        $error = "Password is required";
    } else {
        $sql = "SELECT user_id,username,role FROM users WHERE username='$uname' AND password='$pwd'";
        $result = mysqli_query($con, $sql) or die('Query failed');
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)){
               
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['role'] = $row['role'];
                header("Location:$hostname/admin/post.php");
            }
        } else {
            $error = "Username and password are not matched";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>

    </style>
</head>

<body>
    <div class="container d-flex vh-100 justify-content-center align-items-center">
        <?php
        if (isset($error)) {
            echo "<p class='text-danger'>$error</p>";
        }
        ?>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <p class="display-6 text-center">Login</p>
            <div class="form-floating my-2">
                <input type="text" name="username" id="username" class="form-control" placeholder="username" value="<?= isset($error) ? $uname : '' ?>">
                <label for="username">Username</label>
            </div>
            <div class="form-floating my-2">
                <input type="password" name="password" id="password" class="form-control" placeholder="password" >
                <label for="password">Password</label>
            </div>
            <input type="submit" name="login" class="btn btn-primary" value="login">

        </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


