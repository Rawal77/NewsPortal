<?php 
include "header.php";
include "config.php";

if($_SESSION['role'] == '1' || $_SESSION['role'] == '2'){
    header("Location: $hostname/admin/post.php");
}

if(isset($_POST['submit'])){
    $userid = mysqli_real_escape_string($con,$_POST['user_id']);
    $fname = mysqli_real_escape_string($con,$_POST['f_name']);
    $lname = mysqli_real_escape_string($con,$_POST['l_name']);
    $uname = mysqli_real_escape_string($con,$_POST['username']);
    $role = mysqli_real_escape_string($con,$_POST['role']);
    $category = mysqli_real_escape_string($con,$_POST['category']);

    if(empty($fname)){
        $error = "Firstname is required";
    }else if(strlen($fname) < 5){
        $error = "Firstname must be more than 5 characters";
    }else if(empty($lname)){
        $error = "Lastname is required";
    }else if(empty($uname)){
        $error = "Username is required";
    }else if(empty($role)){
        $error = "Role is required";
    }else{
        $sql = "UPDATE users SET first_name='$fname', last_name='$lname', username='$uname', role='$role', category = '$category' WHERE user_id='$userid'";
        if(mysqli_query($con,$sql)){
            header("Location: $hostname/admin/users.php");
        }
    }
}
 ?>
<div class="container my-3">
    <h5 class="text-center">Update User</h5>
    <div class="row align-items-center">
        <?php
        include "config.php";
        $id = $_GET['id'];
        $sql = "SELECT * FROM users WHERE user_id='$id'";
        $result = mysqli_query($con,$sql) or die('Query failed');
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
        ?>
        <?php
        if(isset($error)){
            echo "<p class='text-danger m-0'>$error</p>";
        }
        ?>
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" class="my-2">
            <div class="form-floating mb-3">
                <input type="hidden" class="form-control" name="user_id" value="<?=$row['user_id'];?>">
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="f_name" id="fname" placeholder="First Name"
                value="<?= isset($error) ? $fname : $row['first_name'] ?>">
                <label for="fname">First Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="l_name" id="lname" placeholder="Last Name"
                value="<?=isset($error) ? $lname : $row['last_name'] ?>">
                <label for="lname">Last Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="username" id="uname" placeholder="User Name"
                value="<?=isset($error) ? $uname : $row['username'] ?>">
                <label for="uname">User Name</label>
            </div>
            <div class="form-floating mb-3">
                <select name="role" id="role" class="form-select" placeholder="User Role"
                value="<?=$row['role'];?>">
                    <option value="1"
                    <?= isset($error) ? ($role==1 ? 'selected': '') : 
                    ($row['role'] == 1 ? 'selected' : '') ?>>Journalist</option>
                    <option value="2" 
                    <?= isset($error) ? ($role==2 ? 'selected': '') : 
                    ($row['role'] == 2 ? 'selected' : '') ?>>Editor</option>
                    <option value="3" 
                    <?= isset($error) ? ($role==3 ? 'selected': '') : 
                    ($row['role'] == 3 ? 'selected' : '') ?>>Admin</option>
                </select>
                <label for="category">User Role</label>
            </div>
            <div id="additionalFields" style="display: none;">
                <div class="form-floating mb-3">
                    <select name="category" id="category" class="form-select" placeholder="category">
                        <option value="" disabled>Select Category</option>
                        <?php
                        include "config.php";
                        $sql = "SELECT * FROM category";
                        $result = mysqli_query($con, $sql) or die('Query fialed');
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option 
                                value='{$row['category_id']}'> {$row['category_name']} </option>";
                            }
                        }
                        ?>
                    </select>
                    <label for="category">Category</label>
                </div>
            </div>

            <input type="submit" name="submit" class="btn btn-primary" value="Save">
        </form>
        <?php } } ?>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="./script.js"></script>