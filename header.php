<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Scroll</title>
  <!-- font-awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
  <!-- styles -->
  <link rel="stylesheet" href="./css/styles.css" />
  <!-- <link rel="stylesheet" href="./css/styles2.css" /> -->
  <link rel="stylesheet" href="./css/styles3.css" />
  <link rel="stylesheet" href="./css/styles4.css" />
  <style>
    .post {
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      margin-bottom: 20px;
      background-color: #f5f5f5;
    }

    .post-image {
      display: block;
      margin-bottom: 10px;
      width: 100%;
      height: auto;
    }

    .post-title {
      font-size: 20px;
      font-weight: bold;
      color: #333;
      text-decoration: none;
    }

    .post-description {
      font-size: 16px;
      color: #666;
      margin-bottom: 10px;
    }

    .read-more {
      float: right;
      color: red;
      margin: 5px 0;
      text-decoration: none;
    }
  </style>

</head>


<body>
  <!-- Header -->
  <header id="home">
    <!-- navbar -->
    <nav id="nav">
      <div class="nav-center">
        <!-- nav header -->
        <div class="nav-header">
          <a href="index.php">
          <img src="./images/logo.svg" alt="logo" class="logo">
          </a>
          <button class="nav-toggle">
            <i class="fas fa-bars"></i>
          </button>
        </div>
        <!-- links -->
        <div class="links-container">
          <?php
          include "./admin/config.php";
          // $sql = "SELECT * FROM post JOIN category ON post.category = category.category_id
          // JOIN users ON post.users = users.user_id WHERE post.post_id = '$postid'";
          // $sql = "SELECT * FROM category JOIN post ON category.category_id WHERE category.no_of_post > 0 AND post.status='accepted'";
          // $sql = "SELECT * FROM category, post WHERE category.category_id = post.category AND no_of_post > 0 AND status='accepted'";

          $sql = "SELECT DISTINCT category.*
FROM category
JOIN post ON category.category_id = post.category_id
WHERE category.no_of_post > 0 AND post.status = 'accepted'";

          $result = mysqli_query($con, $sql);
          // print_r($result);
          if (mysqli_num_rows($result)) {

          ?>
            <ul class="links">
              <?php while ($row = mysqli_fetch_assoc($result)) {

                echo "<li>
              <a href='#{$row['category_name']}' class='scroll-link'>{$row['category_name']}</a>
            </li>";
              } ?>
              <li class="search_icon">
                <a href="javascript:;" id="Search"><i class="fa fa-search"></i></a>
              </li>
              <div class="search_form" id="search_form" style="display: none;">
                <div class="form">
                  <form action="search.php">
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Enter search items" name="search">
                      <button>search</button>
                    </div>
                  </form>
                </div>
              </div>
            </ul>
          <?php } ?>
        </div>
      </div>
    </nav>

    <!-- banner -->
    <div class="banner">
      <div class="container">
        <h1>Scroll Project</h1>
        <p>News Buzz is a news portal. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Non ullam eaque obcaecati!</p>
        <?php
        // Modify the SQL query to select featured categories
        $sql_featured = "SELECT DISTINCT category.*
                     FROM category
                     JOIN post ON category.category_id = post.category_id
                     WHERE category.no_of_post > 0 AND post.isfeatured = 'YES'";

        $result_featured = mysqli_query($con, $sql_featured);

        if (mysqli_num_rows($result_featured)) {
          $row_featured = mysqli_fetch_assoc($result_featured);
          $featured_category_name = $row_featured['category_name'];

          echo "<a href='#featured' class='scroll-link btn btn-white'>Featured</a>";
        } else {
          echo "<a href='#featured' class='scroll-link btn btn-white'>Featured</a>";
        }
        ?>
        <!-- <a href="#featured" class="scroll-link btn btn-white">Featured</a> -->
      </div>
    </div>
  </header>