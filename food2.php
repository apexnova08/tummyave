<?php
$mysqli = require __DIR__ . "/database.php";
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tummy Avenue | Food</title>

<!--CSS-->
<?php 
include 'global/customercss.html';
?>

<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>

<?php 
include 'global/loader.html';
?>

<?php 
include 'global/customerheader.php';
?>

<!--Page header & Title-->
<section id="page_header">
<div class="page_title">
  <div class="container">
    <div class="rowfoods">
      <div class="col-md-12">
         <h2 class="title">Our Food</h2>
         <p>Check out our menu and some of our special, featured best sellers!</p>
      </div>
    </div>
  </div>
</div>  
</section>

<!--Featured Food -->
<section id="news" class="bg_grey padding">
  <div class="container">
    <div class="rowfoods">
      <div class="col-md-12 text-center">
      <h2 class="heading">Featured &nbsp; Food</h2>
      <hr class="heading_space">
      </div>
    </div>
    <div class="rowfoods">
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

<!--Food Facilities-->
<section id="food" class="padding bg_grey">
  <div class="container">
    <div class="rowfoods">
      <div class="col-md-12">
        <h2 class="heading">Our &nbsp; Menu &nbsp; Categories</h2>
        <hr class="heading_space">
      </div>
    </div>
    <div class="rowfoods">
    <div class="col-md-4">
        <ul class="menu_widget">
          <li>All Day Breakfast</li>
          <li>Appetizers</li>
          <li>Bowls</li>
          <li>Burgers & Sandwiches</li>
          <li>Chicken Wings</li>
          <li>Chao Panlaban</li>
          <li>Pasta</li>
          <li>Group Treats</li>
          <li>Add-ons & Extras</li>
          
        </ul>
      </div>
      <div class="col-md-8 grid_layout">
      <div class="rowfoods">
      <div class="zerogrid">
          <div class="wrap-container">
            <div class="wrap-content clearfix">

              <?php
              $result = $mysqli->query("SELECT * FROM foods");
              while ($rowfoods = $result->fetch_assoc()) {
              ?>

              <div class="col-1-2">
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

<!-- testinomial -->
<section id="testinomial" class="padding">
  <div class="container">
  <div class="rowfoods">
      <div class="col-md-12 text-center">
      <h2 class="heading">Our &nbsp; Happy &nbsp; Customers</h2>
      <hr class="heading_space">
      </div>
    </div>
    <div class="rowfoods">
      <div class="col-md-12">
      <div id="testinomial-slider" class="owl-carousel text-center">
        <div class="item">
          <h3>5 Stars!! I'll invite my friends next time!!</h3>
          <p>Jedaiah Carmel</p>
        </div>
        <div class="item">
          <h3>Good food, Nice staff and customer care. A good service overall</h3>
          <p>Dex Amit</p>
        </div>
        <div class="item">
          <h3>Awesome Food!! I want to order more!!</h3>
          <p>Harold Caimol</p>
        </div>
       </div>
      </div>
    </div>
  </div>
</section>

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
