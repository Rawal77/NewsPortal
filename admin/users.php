<?php 
require "header.php";
if($_SESSION['role'] == '1' || $_SESSION['role'] == '2'){
  header("Location: $hostname/admin/post.php");
}
 ?>

<section>
  <div class="container my-3">
    <div class="d-flex justify-content-between align-items-center">
      <p class="lead">All Users</p>

      <a href="add-user.php" class="btn btn-outline-dark btn-sm">Add Users</a>
    </div>
    <div class="table-responsive my-3">
      <?php
      include "config.php";
      // $sql = "SELECT * FROM users ORDER BY user_id DESC";
      $sql = "SELECT * FROM users WHERE role <> 3 ORDER BY user_id DESC"; 
      $result = mysqli_query($con, $sql) or die('Query Failed');
      if (mysqli_num_rows($result) > 0) {
      ?>
        <table class="table text-center">
          <thead>
            <tr>
              <th>s.n.</th>
              <th colspan="2">Full Name</th>
              <th>Username</th>
              <th>Role</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>

              <tr>
                <td><?= $row['user_id']; ?></td>
                <td colspan="2"><?= $row['first_name'] . " " . $row['last_name'] ?></td>
                <td><?= $row['username'] ?></td>
                <td><?= $row['role'] == 1 ? 'Journalist' : ($row['role'] == 2 ? 'Editor' : 'Admin'); ?></td>
                <td>
                  <a href="update-user.php?id=<?= $row['user_id'] ?>" class="text-warning"><i class="bi bi-pencil-square"></i></a>
                </td>
                <td>
                  <a href="delete-user.php?id=<?= $row['user_id'] ?>" class="text-danger"><i class="bi bi-trash3"></i></a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>
    </div>
  </div>

</section>