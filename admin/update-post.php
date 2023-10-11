<?php
include "header.php";
include "config.php";
include "../phpMailer.php";
if (isset($_POST['update'])) {
    if (empty($_FILES['new_image']['name'])) {
        $filename = $_POST['old_image'];
    } else {
        $filename = $_FILES['new_image']['name'];
        $filesize = $_FILES['new_image']['size'];
        $tmpname = $_FILES['new_image']['tmp_name'];
        $filename = $_FILES['new_image']['name'];
        $fileext = end(explode('.', $filename));
        $ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fileext, $ext)) {
            if ($filesize  > 3000000) {
                $error = "Image size should be less than 6mb";
            }
        } else {

            $error = "Please choose jpg,jpeg,png or gif format";
        }
        move_uploaded_file($tmpname, "upload/" . $filename);
    }
    $sql = "UPDATE post SET title='{$_POST["post_title"]}', description='{$_POST["postdesc"]}',category={$_POST["category"]},post_img='$filename',isfeatured='{$_POST["featured"]}',status='{$_POST["status"]}' WHERE post_id={$_POST["post_id"]}";
    $sql2 = "SELECT * FROM post JOIN category ON post.category = category.category_id
    JOIN users ON post.user_id = users.user_id WHERE post_id={$_POST["post_id"]}";
    $res2 = mysqli_query($con,$sql2);
    $row2 = mysqli_fetch_assoc($res2);
    $username = $row2['username'];
    $date = date("d--m-y");
    // phpmailer('raolgins@gmail.com',"News has been edited by '$username' on '$date'");

    $result = mysqli_query($con, $sql);
    if ($result) {
        header("Location: $hostname/admin/post.php");
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



        include "config.php";
        $post_id = $_GET['id'];
        $sql = "SELECT * FROM post JOIN category ON post.category = category.category_id
        JOIN users ON post.users = users.user_id WHERE post.post_id='$post_id'";
        $result = mysqli_query($con, $sql) or die('Query Failed');
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
                <form action="" method="POST" enctype="multipart/form-data" class="my-2 w-50 mx-auto">
                    <div class="form-floating mb-3">
                        <input type="hidden" class="form-control" name="post_id" value="<?= $row['post_id'] ?>">
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="post_title" id="title" placeholder="Title" value="<?= $row['title'] ?>" required>
                        <label for="title">Title</label>
                    </div>
                    <div class="form-floating mb-3 ">
                        <textarea name="postdesc" id="description" rows="5" class="form-control" placeholder="Description" required>
                <?= $row['description'] ?></textarea>
                        <label for="description">Description</label>
                    </div>
                    <div class="form-floating mb-3 d-none">
                        <input type="hidden" name="category" value="<?=$row['category']?>">
                    </div>


                    <?php if ($_SESSION['role'] == '2' || $_SESSION['role'] == '3') { ?>
                <div class="form-floating mb-3">
                    <select name="featured" id="featured" class="form-select" placeholder="Want to feature" required>
                        <option value="">Feature</option>
                        <option value="YES" <?=$row['isfeatured']=='YES' ?  'selected' : '' ?>>YES</option>
                        <option value="NO"  <?=$row['isfeatured']=='NO' ?  'selected' : '' ?>>NO</option>
                    </select>
                    <label for="featured">Want to feature</label>
                </div>
                <div class="form-floating mb-3">
                    <select name="status" id="status" class="form-select" placeholder="Display the news" required>
                        <option value="">Display the news</option>
                        <option value="accepted" <?=$row['status']=='accepted' ?  'selected' : '' ?>>ACCEPTED</option>
                        <option value="declined" <?= $row['status']=='declined' ? 'selected' : '' ?>>DECLINED</option>
                    </select>
                    <label for="status">Display the news</label>
                </div>
            <?php } ?>

                    <div class="form-floating mb-3">
                        <input type="file" class="form-control" name="new_image" id="fileToUpload" placeholder="Post Image">
                        <img src="upload/<?= $row['post_img']; ?>" alt="" class="w-25 m-2 img-fluid">
                        <input type="hidden" name="old_image" value="<?= $row['post_img']; ?>">
                        <label for="fileToUpload">Post Image</label>
                    </div>
                    <input type="submit" name="update" class="btn btn-primary" value="Save">
                </form>
        <?php }
        } ?>
    </div>
</div>