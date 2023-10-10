<?php 
include "header.php"; 
include "./admin/config.php";

// $sql = "SELECT * FROM category JOIN post ON category.category_id WHERE no_of_post > 0 AND status='accepted'";
$sql = "SELECT DISTINCT category.category_id, category_name 
        FROM category 
        JOIN post ON category.category_id = post.category 
        WHERE no_of_post > 0 AND status='accepted'";

// $sql = "SELECT * FROM category, post WHERE category.category_id = post.category AND no_of_post > 0 AND status='accepted'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result)) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $categoryCount = count($categories);
    $i = 0;
    foreach ($categories as $category) {
        $categoryId = $category['category_id'];
        $categoryName = $category['category_name'];
        $i++;
?>

<!-- Section -->
<section id="<?=$categoryName?>">
    <div class="carousel-container">
        <div class="carousel">
            <?php
            $sql = "SELECT * FROM post JOIN category ON post.category = category.category_id
           JOIN users ON post.users = users.user_id WHERE status='accepted' AND category_name = '{$categoryName}' ORDER BY post.post_id DESC";
        //    $sql = "SELECT * FROM category, post WHERE category.category_id = post.category AND no_of_post > 0 AND status='accepted'";
            $result = mysqli_query($con, $sql) or die("Query Failed");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="carousel-item">
                <div class="box1">
                    <img src="./admin/upload/<?=$row['post_img']?>" class="post-image">
                    <a href="mainpage.php?id=<?=$row['post_id']?>" class="post-title"><?=$row['title']?></a>
                    <p class="post-description"><?=substr($row['description'], 0, 30)."........";?></p>
                    <a href="mainpage.php?id=<?=$row['post_id']?>" class="read-more">read more</a>
                    <br>
                    <small class="down-bar"><?=$row['category_name'];?></small>
                </div>
            </div>
            <?php 
                }
            } 
            ?>
        </div>
    </div>
</section>
<br><br>
<section id="featured">
    <div class="carousel-container">
        <div class="carousel">
        <?php
            $sql = "SELECT * FROM post JOIN category ON post.category = category.category_id
            JOIN users ON post.users = users.user_id WHERE isfeatured='YES' AND status='accepted' AND category_name = '{$categoryName}' ORDER BY post.post_id DESC";
            // $sql = "SELECT * FROM category, post WHERE category.category_id = post.category AND no_of_post > 0 AND status='accepted'";
            $result = mysqli_query($con, $sql) or die("Query Failed");
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="carousel-item">
                <div class="box1">
                    <img src="./admin/upload/<?=$row['post_img']?>" class="post-image">
                    <a href="mainpage.php?id=<?=$row['post_id']?>" class="post-title"><?=$row['title']?></a>
                    <p class="post-description"><?=substr($row['description'], 0, 30)."........";?></p>
                    <a href="mainpage.php?id=<?=$row['post_id']?>" class="read-more">read more</a>
                    <br>
                    <!-- <small class="down-bar"><?=$row['category_name'];?></small> -->
                </div>
            </div>
            <?php 
                }
            } 
            ?>
        </div>
    </div>
</section>

<?php
        // Add a line break after each category except the last one
        if ($i < $categoryCount) {
            echo "<br>";
        }
    }
}
?>

  <!-- footer -->
  <footer class="section">
    <p>copyright &copy; News Buzz <span id="date">2020</span>.all rights reserved</p>
  </footer>
  <!-- back to top button -->
  <a href="#home" class="scroll-link top-link">
    <i class="fas fa-arrow-up"></i>
  </a>
  <!-- javascript -->
  <script src="./js/app.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
      $('#Search').on('click',function(){
        $('#search_form').toggle(500)
      });
    })
  </script>
</body>

</html>