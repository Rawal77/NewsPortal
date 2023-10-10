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
    <link rel="stylesheet" href="./css/styles5.css" />
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
                <img src="./images/logo.svg" alt="logo" class="logo">
                <button class="nav-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <!-- links -->
            <div class="links-container">
            <?php
                include "./admin/config.php";
                $sql = "SELECT DISTINCT category.*
                FROM category
                JOIN post ON category.category_id = post.category
                WHERE category.no_of_post > 0 AND post.status = 'accepted';
                ";
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
                                    <input type="text" name="search"
                                     class="form-control" placeholder="Enter search items">
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