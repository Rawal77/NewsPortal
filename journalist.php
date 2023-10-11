<?php
include "header2.php";
?>
    <main class="container">
        <?php
        include "./admin/config.php";
        if(isset($_GET['jid'])){
            $authid = $_GET['jid'];
            $sql = "SELECT * FROM users WHERE user_id = '$authid'";
    $result = mysqli_query($con, $sql) or die("Query Failed");
    if ($row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
?>
        <h1><?= $username ?></h1>
        <?php }
        $sql = "SELECT * FROM post JOIN category ON post.category_id=category.category_id JOIN users ON post.user_id = users.user_id WHERE post.user_id = '$authid'";
        $result = mysqli_query($con, $sql) or die("Query Failed");
        while($row = mysqli_fetch_assoc($result)){
            
        ?>
                <!-- <h1><?=$row['username']?></h1> -->
                <div class="meta">
                    <!-- <a href="#">
                        <span class="author"><i class="bi bi-person-fill"></i> <?=$row['username']?></span>
                    </a> -->
                        | <span class="date" style="color: black;"><i class="bi bi-calendar-fill"> </i><?=$row['post_date']?></span>
                </div>
                <img src="admin/upload/<?=$row['post_img']?>" alt="News Image" class="image">
                <div class="content">
                    <?=$row['description']?>
                </div>

        <?php }  }?>

    </main>
    <script src="./js/app.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
      $('#Search').on('click',function(){
        $('#search_form').toggle(500)
      });
    })
  </script>