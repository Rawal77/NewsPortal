<?php 
include "header.php";
if($_SESSION['role'] == '1' || $_SESSION['role'] == '2'){
  header("Location: $hostname/admin/post.php");
}

 ?>
<section>
        <div class="container my-3">
            <div class="d-flex justify-content-between align-items-center">
                <p class="lead">All Categories</p>
                <a href="add-category.php" class="btn btn-outline-dark btn-sm">Add Category</a>
            </div>
            <div class="table-responsive my-3">
                 <?php
                  include "config.php";
                  $sql = "SELECT * FROM category ORDER BY category_id DESC";
                  $result = mysqli_query($con, $sql) or die('Query Failed');
                  if (mysqli_num_rows($result) > 0) {
                  ?>
                <table class="table text-center">
                    <thead>
                      <tr>
                        <th>s.n.</th>
                        <th colspan="2">Category Name</th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                      <tr>
                        <td><?= $row['category_id']?></td>
                        <td colspan="2"><?=$row['category_name']?></td>
                        <td>
                        <a href="update-category.php?id=<?=$row['category_id']?>" class="text-warning"><i class="bi bi-pencil-square"></i></a>
                        </td>
                        <td>
                        <a href="delete-category.php?id=<?=$row['category_id']?>" class="text-danger"><i class="bi bi-trash3"></i></a>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  <?php } ?>
            </div>
        </div>
    </section>