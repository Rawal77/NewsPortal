<?php
include "header.php";
include "config.php";
if ($_SESSION['role'] == '1' || $_SESSION['role'] == '2') {
    header("Location: $hostname/admin/post.php");
}

if (isset($_POST['save'])) {
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $opwd = $_POST['password'];
    $user = mysqli_real_escape_string($con, $_POST['user']);
    $password = mysqli_real_escape_string($con, md5($_POST['password']));
    $role = mysqli_real_escape_string($con, $_POST['role']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    if (empty($fname)) {
        $error = "First name is required";
    } else if (empty($lname)) {
        $error = "Last name is required";
    } else if (strlen($fname) < 5) {
        $error = "first name must be more than 5 characters";
    } else if (empty($user)) {
        $error = "Username field is required";
    } else if (empty($opwd)) {
        $error = "Password field is required";
    } else if (empty($role)) {
        $error = "Role field is required";
    } else {
        $sql = "SELECT username FROM users WHERE username = '$user'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) > 0) {
            $error = "Username already exist's";
        } else {
            $sql1 = "INSERT INTO users(first_name,last_name,username,password,role,category_id) VALUES ('$fname','$lname','$user','$password','$role','$category')";
            if (mysqli_query($con, $sql1)) {
                header("Location: {$hostname}/admin/users.php");
            }
        }
    }
}
?>
<div class="container my-3">
    <h5 class="text-center">Add User</h5>
    <?php
    if (isset($error)) {
        echo "<p class='text-danger m-0'>$error</p>";
    }
    ?>
    <div class="row align-items-center">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="my-2">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="fname" id="fname" placeholder="First Name" value="<?= isset($error) ? $fname : '' ?>">
                <label for="fname">First Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name" value="<?= isset($error) ? $lname : '' ?>">
                <label for="lname">Last Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="user" id="uname" placeholder="User Name" value="<?= isset($error) ? $user : '' ?>">
                <label for="uname">User Name</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <label for="password">Password</label>
            </div>
            <div class="form-floating mb-3">
                <select name="role" id="role" class="form-select" placeholder="User Role" required>
                    <option value="">Select an option</option>
                    <option value="1" <?= isset($error) ? ($role == 1 ? 'selected' : '') : '' ?>>Journalist</option>
                    <option value="2" <?= isset($error) ? ($role == 2 ? 'selected' : '') : '' ?>>Editor</option>
                    <option value="3" <?= isset($error) ? ($role == 3 ? 'selected' : '') : '' ?>>Admin</option>
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
                                echo "<option value='{$row['category_id']}'> {$row['category_name']} </option>";
                            }
                        }
                        ?>
                    </select>
                    <label for="category">Category</label>
                </div>
            </div>
            <input type="submit" name="save" class="btn btn-primary" value="Save">
        </form>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="./script.js"></script>