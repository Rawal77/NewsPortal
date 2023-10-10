<?php
include "header.php";
include "config.php";
include "../phpMailer.php";

if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($con, $_POST['post_title']);
    $desc = mysqli_real_escape_string($con, $_POST['postdesc']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $caption = mysqli_real_escape_string($con, $_POST['caption']);
    // $featured = mysqli_real_escape_string($con, $_POST['featured']);
    // $display = mysqli_real_escape_string($con,$_POST['status']);
    $featured = isset($_POST['featured']) ? mysqli_real_escape_string($con, $_POST['featured']) : 'FALSE';
    $display = isset($_POST['status']) ? mysqli_real_escape_string($con, $_POST['status']) : 'pending';
    // $image = mysqli_real_escape_string($con,$_POST['fileUpload']);
    $date = date("d-M-Y");
    $author = $_SESSION['user_id'];
    if (empty($title)) {
        $error = "Title is required";
    } else if (empty($desc)) {
        $error = "Description is required";
    } else if (empty($caption)) {
        $error = "Caption is required";
    } else {

        if (isset($_POST['submit'])) {
            $filename = $_FILES['fileUpload']['name'];
            $filesize = $_FILES['fileUpload']['size'];
            $tmpname = $_FILES['fileUpload']['tmp_name'];
            $filename = $_FILES['fileUpload']['name'];
            $fileext = end(explode('.', $filename));
            $ext = ['jpg', 'jpeg', 'png', 'gif'];


            if (in_array($fileext, $ext)) {
                if ($filesize  > 3000000) {
                    $error = "Image size should be less than 6mb";
                } else {
                    move_uploaded_file($tmpname, "upload/" . $filename);
                    $sql = "INSERT INTO post(title,description,post_date,post_img,category,users,isfeatured,status)
                    VALUES('$title','$desc','$date','$filename','$category','$author','$featured','$display');";
                    $sql .= "UPDATE category SET no_of_post = no_of_post +1 WHERE category_id = '$category'";
                    $sql2 = "SELECT * FROM post JOIN category ON post.category = category.category_id
                    JOIN users ON post.users = users.user_id WHERE users='$author'";
                    $res = mysqli_query($con,$sql2);
                    $row = mysqli_fetch_assoc($res);
                    $username = $row['username'];
                    // phpmailer('raolgins@gmail.com',"News has been posted by '$username' on '$date'");
                    if (mysqli_multi_query($con, $sql)) {
                        header("Location: $hostname/admin/post.php");
                    } else {
                        $error = "Query Failed";
                    }
                }
            } else {
                $error = "Please choose jpg,jpeg,png or gif format";
            }
        }
    }
}
?>
<div class="container my-3">
    <h5 class="text-center">Add News Post</h5>
    <div class="row align-items-center">
        <?php
        if (isset($error)) {
            echo "<p class='text-danger text-center m-0'>$error</p>";
        }
        ?>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" class="my-2 w-50 mx-auto">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="post_title" id="title" placeholder="Title" value="<?= isset($error) ? $title : '' ?>">
                <label for="title">Title</label>
            </div>
            <div class="form-floating mb-3">
                <textarea name="postdesc" id="description" rows="25" class="form-control" placeholder="Description" value="<?= isset($error) ? $desc : '' ?>"></textarea>
                <label for="description">Description</label>
            </div>

            <div class="form-floating mb-3">
                <?php
                $sql = "SELECT * FROM users WHERE user_id={$_SESSION['user_id']}";
                $res = mysqli_query($con, $sql);
                $row = mysqli_fetch_assoc($res);
                $final = $row['category'];
                ?>
                <input type="hidden" class="form-control" name="category" id="formId1" value="<?= $row['category'] ?>">
                <label for="formId1">Name</label>
            </div>

            <div class="form-floating mb-3">
                <input type="file" class="form-control" name="fileUpload" id="fileToUpload" placeholder="Post Image" required>
                <label for="fileToUpload">Post Image</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="caption" id="caption" placeholder="Image Caption" value="<?= isset($error) ? $caption : '' ?>">
                <label for="caption">Image Caption</label>
            </div>

            <?php if ($_SESSION['role'] == '2' || $_SESSION['role'] == '3') { ?>
                <div class="form-floating mb-3">
                    <select name="featured" id="featured" class="form-select" placeholder="Want to feature">
                        <option value="">Feature</option>
                        <option value="YES" <?= isset($error) ? ($featured == 'YES' ? 'selected' : '') : '' ?>>YES</option>
                        <option value="NO" <?= isset($error) ? ($featured == 'NO' ? 'selected' : '') : '' ?>>NO</option>
                    </select>
                    <label for="featured">Want to feature</label>
                </div>

                <div class="form-floating mb-3">
                    <select name="status" id="status" class="form-select" placeholder="Display the news">
                        <option value="">Display the news</option>
                        <option value="accepted" <?= isset($error) ? ($status == 'accepted' ? 'selected' : '') : '' ?>>ACCEPTED</option>
                        <option value="declined" <?= isset($error) ? ($featured == 'declined' ? 'selected' : '') : '' ?>>DECLINED</option>
                    </select>
                    <label for="status">Display the news</label>
                </div>
            <?php } ?>
            <input type="submit" name="submit" class="btn btn-primary" value="Save">
        </form>
    </div>


</div>