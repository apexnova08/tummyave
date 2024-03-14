<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tummy Avenue | Food</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/JKS-icons.css">
<link rel="stylesheet" type="text/css" href="css/settings.css">
<link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="css/owl.transitions.css">
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css">
<link rel="stylesheet" type="text/css" href="css/zerogrid.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/loader.css">
<link rel="shortcut icon" href="images/LogoIcon.jpg">

<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>

<!--Loader-->
<div class="loader"> 
   <div class="cssload-container">
     <div class="cssload-circle"></div>
     <div class="cssload-circle"></div>
   </div>
</div>

<?php 
include 'global/customerheader.php';
?>

<!--Page header & Title-->
<section id="page_header">
<div class="page_title">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
         <h2 class="title">Our Food</h2>
         <p>Check out our menu and some of our special, featured best sellers!</p>
      </div>
    </div>
  </div>
</div>  
</section>



<!--Welcome-->
<section id="welcome" class="padding">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
         <h2 class="heading">Welcome to Tummy Avenue</h2>
         <hr class="heading_space">
      </div>
      <div class="col-md-7 col-sm-6">
        <p class="half_space">Launched in Kawit, Cavite. Tummy Avenue has grown from a...</p>
        <p class="half_space"></p>
        <p class="half_space">Further Info.</p>
        
      </div>
      <div class="col-md-5 col-sm-6">
       <img class="img-responsive" src="images/NA.jpg" alt="welcome JKS">
      </div>
    </div>
  </div>
</section> 


<!--Food Facilities-->
<section id="food" class="padding bg_grey">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="heading">Our &nbsp; Menu &nbsp; Categories</h2>
        <hr class="heading_space">
      </div>
    </div>
    <div class="row">
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
      <div class="row">
      <div class="zerogrid">
          <div class="wrap-container">
            <div class="wrap-content clearfix">
              <div class="col-1-2">
              <div class="wrap-col first">
                  <div class="item-container"> 
                   <img src="images/Different Wings.jpg" style="width: center; height: 255px;" alt="cook"/>
                   <div class="overlay">
                       <a class="overlay-inner fancybox" href="images/Different Wings.jpg" data-fancybox-group="gallery">
                           Chicken Wings
                       </a> 
                   </div>
                  </div>
                </div>
              </div>
              <div class="col-1-2">
              <div class="wrap-col first">
                  <div class="item-container"> 
                   <img src="images/burger sizzle.jpg" style="width: center; height: 255px;" alt="cook"/> 
                   <div class="overlay">
                      <a class="overlay-inner fancybox" href="images/burger sizzle.jpg" data-fancybox-group="gallery">
                         Burger
                      </a>
                   </div>
                   </div>
                </div>
              </div>
              <div class="col-1-2">
              <div class="wrap-col">
                  <div class="item-container"> 
                   <img src="images/Shrimp in a Bowl.jpg" style="width: center; height: 255px;" alt="cook"/> 
                   <div class="overlay">
                       <a class="overlay-inner fancybox" href="images/Shrimp in a Bowl.jpg" data-fancybox-group="gallery">
                          Bowls
                       </a>
                   </div>
                    </div>
                </div>
              </div>
              <div class="col-1-2">
              <div class="wrap-col">
                  <div class="item-container"> 
                   <img src="images/Carbonara.jpg" style="width: center; height: 255px;" alt="cook"/> 
                   <div class="overlay">
                       <a class="fancybox overlay-inner" href="images/Carbonara.jpg" data-fancybox-group="gallery"> 
                         Pasta
                       </a>
                    </div>
                   </div>
                 </div>
               </div>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!--Featured Food -->
<section id="news" class="bg_grey padding">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
      <h2 class="heading">Featured &nbsp; Food</h2>
      <hr class="heading_space">
      </div>
    </div>
    <div class="row">
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


<!-- testinomial -->
<section id="testinomial" class="padding">
  <div class="container">
  <div class="row">
      <div class="col-md-12 text-center">
      <h2 class="heading">Our &nbsp; Happy &nbsp; Customers</h2>
      <hr class="heading_space">
      </div>
    </div>
    <div class="row">
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
include 'global/customerfooter.php';
?>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<script src="js/jquery-2.2.3.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/jquery.parallax-1.1.3.js"></script>
<script src="js/jquery.appear.js"></script>  
<script src="js/jquery-countTo.js"></script> 
<script src="js/owl.carousel.min.js" type="text/javascript"></script>
<script src="js/jquery.fancybox.js"></script>
<script src="js/jquery.mixitup.min.js"></script>
<script src="js/functions.js" type="text/javascript"></script>

</body>
</html>
