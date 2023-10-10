<?php 
include "header.php";
include "config.php";
if($_SESSION['role'] == '1' || $_SESSION['role'] == '2'){
    header("Location: $hostname/admin/post.php");
} 
if(isset($_POST['submit'])){
    $cat = mysqli_real_escape_string($con,$_POST['cat']);
    if(empty($cat)){
        $error = "Category is required";
    }else{
        $sql = "INSERT INTO category(category_name,no_of_post)VALUES('$cat','0')";
        if(mysqli_query($con,$sql)){
            header("Location: $hostname/admin/category.php");
        }
    }
}
 ?>
<div class="container my-3">
    <h5 class="text-center">Add News Category</h5>
    <div class="row align-items-center">
        <?php
        if (isset($error)) {
            echo "<p class='text-danger text-center m-0'>$error</p>";
        }
        ?>
        <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST" class="my-2">
            <div class="form-floating mb-3">
                <input type="title" class="form-control" name="cat" id="category" placeholder="Title">
                <label for="category">Category</label>
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Save">
        </form>
    </div>
</div>

