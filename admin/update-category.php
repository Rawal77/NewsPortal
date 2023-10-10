<?php
include "header.php";
include "config.php";

if ($_SESSION['role'] == '1' || $_SESSION['role'] == '2') {
    header("Location: $hostname/admin/post.php");
}

if (isset($_POST['update'])) {
    $catname = mysqli_real_escape_string($con, $_POST['cat_name']);
    $post = mysqli_real_escape_string($con, $_POST['no_of_post']); // Update no_of_post
    $id = $_GET['id'];

    if (empty($catname)) {
        $error = "Category name is required";
    } else {
        $sql = "UPDATE category SET category_name='$catname', no_of_post='$post' WHERE category_id='$id'";

        if (mysqli_query($con, $sql)) {
            header("Location: $hostname/admin/category.php");
        }
    }
}
?>

<div class="container my-3">
    <h5 class="text-center">Update Category</h5>
    <div class="row align-items-center">
        <?php
        if (isset($error)) {
            echo "<p class='text-danger m-0'>$error</p>";
        }

        $id = $_GET['id'];
        $sql = "SELECT * FROM category WHERE category_id='$id'";
        $result = mysqli_query($con, $sql) or die('Query failed');

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <form action="" method="POST" class="my-2">
                    <div class="form-floating mb-3">
                        <input type="hidden" name="no_of_post" id="no_of_post" value="<?= $row['no_of_post'] ?>">
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="cat_name" id="category" placeholder="Title" value="<?= isset($error) ? $catname : $row['category_name'] ?>">
                        <label for="category">Category</label>
                    </div>
                    <input type="submit" name="update" class="btn btn-primary" value="Save">
                </form>
        <?php
            }
        }
        ?>
    </div>
</div>
