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
    <link rel="stylesheet" href="./css/styles7.css">
    <style>
         /* Navigation Styles */
    #nav {
        background-color: whitesmoke;
    }
    
    #nav .links-container .links a {
        color: black;
    }
    
    /* Content Styles */
    main.container {
        background-color: whitesmoke;
        color: black;
    }
    
    main.container h1 {
        color: black;
    }
    
    main.container .meta a {
        color: black;
    }
    
    main.container .content {
        color: black;
    }
    .meta{
        color:black;
    }
    </style>
</head>

<body>
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
                $sql = "SELECT * FROM category WHERE no_of_post > 0";
                $result = mysqli_query($con, $sql);
                if (mysqli_num_rows($result)) {
                ?>
                <ul class="links">
                <?php while ($row = mysqli_fetch_assoc($result)) {
                            echo "<li>
              <a href='$hostname/index.php' class='scroll-link'>{$row['category_name']}</a>
            </li>";
                        } ?>
                    <li class="search_icon">
                        <a href="javascript:;" id="Search"><i class="fa fa-search"></i></a>
                    </li>
                    <div class="search_form" id="search_form" style="display: none;">
                        <div class="form">
                            <form action="search.php">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="search" placeholder="Enter search items">
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
    <main class="container">
        <?php
        include "./admin/config.php";
        if(isset($_GET['search'])){
            $searchterm = $_GET['search'];
        ?>
        <h2>Search: <?=$searchterm?></h2>
        <?php
        $sql = "SELECT * FROM post JOIN category ON post.category_id = category.category_id JOIN users ON post.user_id = users.user_id WHERE post.title LIKE '%$searchterm%'";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
        ?>
                <h1><?=$row['title']?></h1>
                <div class="meta">
                    <span class="author" style="color: black;"><i class="bi bi-person-fill"></i> <?=$row['username']?></span> | <span class="date" style="color: black;"><i class="bi bi-calendar-fill"> </i><?=$row['post_date']?></span>
                </div>
                <img src="admin/upload/<?=$row['post_img']?>" alt="News Image" class="image">
                <div class="content">
                    <?=$row['description']?>
                </div>
        <?php 
        }  }else{
            echo "<h1>No results found</h1>";
        }}?>

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