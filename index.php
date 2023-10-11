<?php 
include "header.php"; 
include "./admin/config.php";

// Fetch distinct categories that have accepted posts
$sql = "SELECT DISTINCT category.category_id, category_name 
        FROM category 
        JOIN post ON category.category_id = post.category_id
        WHERE no_of_post > 0 AND status='accepted'";

$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Loop through the categories
    foreach ($categories as $category) {
        $categoryId = $category['category_id'];
        $categoryName = $category['category_name'];
?>

        <!-- Section for the current category -->
        <section id="<?= $categoryName ?>">
            <div class="carousel-container">
                <div class="category-heading">
                    <?php echo $categoryName; ?> <!-- Display category name -->
                </div>
                <div class="carousel">
                    <?php
                    // Fetch posts for the current category
                    $postSql = "SELECT * FROM post 
                                JOIN category ON post.category_id = category.category_id
                                JOIN users ON post.user_id = users.user_id 
                                WHERE status='accepted' AND category_name = '{$categoryName}' 
                                ORDER BY post.post_id DESC";
                    $postResult = mysqli_query($con, $postSql) or die("Query Failed");
                    if (mysqli_num_rows($postResult) > 0) {
                        while ($row = mysqli_fetch_assoc($postResult)) {
                    ?>
                            <div class="carousel-item">
                                <div class="box1">
                                    <img src="./admin/upload/<?= $row['post_img'] ?>" class="post-image">
                                    <a href="mainpage.php?id=<?= $row['post_id'] ?>" class="post-title"><?= substr($row['title'], 0, 21) ?></a>
                                    <p class="post-description"><?= substr($row['description'], 0, 30) . "........"; ?></p>
                                    <a href="mainpage.php?id=<?= $row['post_id'] ?>" class="read-more">read more</a>
                                    <br>
                                    <!-- <small class="down-bar"><?= $row['category_name']; ?></small> -->
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

<?php 
    }
}
?>
<!-- Section for the featured category -->
<section id="featured" class="featured-section">
    <div class="carousel-container">
        <div class="category-heading">
            Featured <!-- Display category name -->
        </div>
        <div class="carousel">
            <?php
            // Fetch featured posts
            $featuredPostSql = "SELECT * FROM post 
                                WHERE isfeatured = 'YES' AND status = 'accepted'
                                ORDER BY post_id DESC LIMIT 3"; // Limiting to 3 featured posts, adjust as needed
            $featuredPostResult = mysqli_query($con, $featuredPostSql) or die("Query Failed");
            if (mysqli_num_rows($featuredPostResult) > 0) {
                while ($featuredRow = mysqli_fetch_assoc($featuredPostResult)) {
            ?>
                    <!-- Featured carousel item -->
                    <div class="carousel-item">
                        <div class="box1" style="padding: 25px;">
                            <img src="./admin/upload/<?= $featuredRow['post_img'] ?>" class="post-image" alt="Featured Image">
                            <a href="mainpage.php?id=<?= $featuredRow['post_id'] ?>" class="post-title"><?= substr($featuredRow['title'], 0, 21) ?></a>
                            <p class="post-description"><?= substr($featuredRow['description'], 0, 30) . "........"; ?></p>
                            <a href="mainpage.php?id=<?= $featuredRow['post_id'] ?>" class="read-more">Read more</a>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "No featured posts available.";
            }
            ?>
        </div>
    </div>
</section>
<br><br>

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