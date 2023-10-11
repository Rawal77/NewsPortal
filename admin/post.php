<?php include "header.php"; ?>
<section>
  <div class="container my-3">
    <div class="d-flex justify-content-between align-items-center">
      <p class="lead">All Posts</p>

      <a href="add-post.php" class="btn btn-outline-dark btn-sm">Add Posts</a>
    </div>
    <div class="table-responsive my-3">
      <?php
      include "config.php";
      if ($_SESSION['role'] == '3') {
        $sql = "SELECT * FROM post JOIN category ON post.category_id = category.category_id
        JOIN users ON post.user_id = users.user_id ORDER BY post.post_id DESC";
      } else if ($_SESSION['role'] == '1') {
        $sql = "SELECT * FROM post JOIN category ON post.category_id = category.category_id
        JOIN users ON post.user_id = users.user_id WHERE post.user_id={$_SESSION['user_id']} ORDER BY post.post_id DESC";
      } else if ($_SESSION['role'] == '2') {

        $sql = "SELECT *
        FROM post
        JOIN category ON post.category_id = category.category_id JOIN users ON post.user_id = users.user_id
        WHERE category.category_id IN (
            SELECT category_id
            FROM users
            WHERE user_id = {$_SESSION['user_id']}
        )
        ORDER BY post.post_id DESC;";
      }


      $result = mysqli_query($con, $sql) or die('Query Failed');
      if (mysqli_num_rows($result) > 0) {
      ?>
        <table class="table text-center">
          <thead>
            <tr>
              <th>s.n.</th>
              <th colspan="2">Title</th>
              <th>Category</th>
              <th>Date</th>
              <th>Author</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
              <tr>
                <td><?= $row['post_id'] ?></td>
                <td colspan="2"><?= $row['title'] ?></td>
                <td><?= $row['category_name'] ?></td>
                <td><?= $row['post_date'] ?></td>
                <td><?= $row['username'] ?></td>
                <td>
                  <a href="update-post.php?id=<?= $row['post_id'] ?>" class="text-warning"><i class="bi bi-pencil-square"></i></a>
                </td>
                <td>
                  <a href="delete-post.php?id=<?= $row['post_id']; ?>&catid=<?=$row['category_id'];?>" class="text-danger"><i class="bi bi-trash3"></i></a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } ?>
    </div>
  </div>


</section>