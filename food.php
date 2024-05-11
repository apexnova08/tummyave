<?php
$mysqli = require __DIR__ . "/database.php";
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tummy Avenue</title>

<!--CSS-->
<?php 
include 'global/customercss.html';
?>
</head>

<body>
<?php 
include 'global/loader.html';
include 'global/customerheader.php';
?>
<!--Page header & Title-->
<section id="page_header">
    <div class="page_title">
        <div class="container">
            <div class="col-md-12">
                <h2 class="title">Our Food</h2>
                <p>Check out our menu and some of our special, featured best sellers!</p>
            </div>
        </div>
    </div>  
</section>

<!-- ## CONTENT HERE ## -->
<section id="news" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Featured &nbsp; Food</h2>
            <hr class="heading_space">
        </div>
            <div>
                <div class="col-md-12">
                    <div class="cheffs_wrap_slider">
                        <div id="news-slider" class="owl-carousel">
                            <div class="item">
                                <div class="news_content">
                                <img src="images/NA.jpg" alt="Docotor">
                                <div class="date_comment">
                                    <span>22<small>apr</small></span>
                                    <a href="#."><i class="icon-comment"></i> 5</a>
                                </div>
                                <div class="comment_text">
                                    <h3><a href="#.">Food Name</a></h3>
                                    <p>Description</p>
                                </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="news_content">
                                <img src="images/NA.jpg" alt="Docotor">
                                <div class="date_comment">
                                    <span>22<small>apr</small></span>
                                    <a href="#."><i class="icon-comment"></i> 5</a>
                                </div>
                                <div class="comment_text">
                                    <h3><a href="#.">Food Name</a></h3>
                                    <p>Description</p>
                                </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="news_content">
                                <img src="images/NA.jpg" alt="Docotor">
                                <div class="date_comment">
                                    <span>22<small>apr</small></span>
                                    <a href="#."><i class="icon-comment"></i> 5</a>
                                </div>
                                <div class="comment_text">
                                    <h3><a href="#.">Food Name</a></h3>
                                    <p>Description</p>
                                </div>
                                </div>
                            </div>
                            
                            <div class="item">
                                <div class="news_content">
                                <img src="images/NA.jpg" alt="Docotor">
                                <div class="date_comment">
                                    <span>22<small>apr</small></span>
                                    <a href="#."><i class="icon-comment"></i> 5</a>
                                </div>
                                <div class="comment_text">
                                    <h3><a href="#.">Food Name</a></h3>
                                    <p>Description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="food" class="padding bg_grey">
    <div class="container">
        <div>
        <div class="col-md-12">
            <h2 class="heading">Our &nbsp; Menu &nbsp; Categories</h2>
            <hr class="heading_space">
        </div>
        </div>
        <div>
        <div class="col-md-12 grid_layout">
        <div>
        <div class="zerogrid">
            <div class="wrap-container">
                <div class="wrap-content clearfix">

                <?php
                $result = $mysqli->query("SELECT * FROM foods");
                while ($rowfoods = $result->fetch_assoc()) {
                ?>

                <div class="col-1-3">
                    <div class="wrap-col first">
                    <div class="item-container">
                    <img src="<?= 'img-uploads/' . $rowfoods['image'] ?>" style="width: center; height: 255px; object-fit: cover;" alt="<?= $rowfoods['name']; ?>"/>
                    <div class="overlay">
                        <form action="usercustomer/foodpage.php" method="post" style="height: 100%;">
                        <input class="overlay-inner" type="submit" value="<?= $rowfoods['name']; ?>" style="height:100%; width:100%; cursor: pointer"/>
                        <input type="hidden" name="foodId" value="<?= $rowfoods['id']; ?>"/>
                        </form>
                    </div>
                    </div>
                    </div>
                </div>

                <?php
                }
                ?>

                </div>
            </div>
            </div>
            </div>
        </div>
        </div>
    </div>
</section>


<section id="section_name" class="padding bg_grey">
    <div class="container">
        <div>
            <h2 class="heading">Title &nbsp; Grey &nbsp; Section</h2>
            <hr class="heading_space">
        </div>
    </div>
</section>

<!--Page Footer-->
<?php 
include 'global/customerfooter.html';
?>
<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include 'global/customerjs.html';
?>
 
</body>
</html>