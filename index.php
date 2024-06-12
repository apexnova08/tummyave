<?php
$mysqli = require __DIR__ . "/database.php";
require __DIR__ . "/global/funcs.php";

session_start();
$userid = "empty";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
session_abort();

// GET USERS
$users = array();
$result_users = $mysqli->query("SELECT * FROM users");
while ($rowuser = $result_users->fetch_assoc())
{
    $users[$rowuser["id"]] = $rowuser;
}
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

<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body>

<?php 
include 'global/loader.html';
include 'global/customerheader.php';
?>

<!-- REVOLUTION SLIDER -->			
				<div id="rev_slider_34_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container" data-alias="news-gallery34" style="margin:0px auto;background-color:#ffffff;padding:0px;margin-top:0px;margin-bottom:0px;">
				<!-- START REVOLUTION SLIDER 5.0.7 fullwidth mode -->
					<div id="rev_slider_34_1" class="rev_slider fullwidthabanner" style="display:none;" data-version="5.0.7">
						<ul>	<!-- SLIDE  -->
							<li data-index="rs-129" data-transition="fade" data-slotamount="default" data-rotate="0"  data-fstransition="fade" data-fsmasterspeed="1500" data-fsslotamount="7"  data-title="" data-description="">
								<!-- MAIN IMAGE -->
								<img src="images/Tummy1.jpg" alt=""  data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
								<!-- LAYER NR. 2 -->
								<h1 class="tp-caption tp-resizeme" 
                          data-x="left" data-hoffset="15"
                          data-y="70" 
                          data-transform_idle="o:1;"
                          data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;" 
                          data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;" 
                          data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
                          data-mask_out="x:0;y:0;s:inherit;e:inherit;" 
                          data-start="500" 
                          data-splitin="none" 
                          data-splitout="none" 
                          style="z-index: 6;">
                          <span class="small_title">Looking for </span> <br> a &nbsp; place &nbsp; to &nbsp;<span class="color">hang out?</span>
                       </h1>
								<!-- LAYER NR. 2 -->
                        <p class="tp-caption tp-resizeme"
                          data-x="left" data-hoffset="15"
                          data-y="210" 
                          data-transform_idle="o:1;"
                          data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;" 
                          data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;" 
                          data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
                          data-mask_out="x:0;y:0;s:inherit;e:inherit;" 
                          data-start="800"
                          style="z-index: 9;">Enjoy Our Outdoor Seating!
                          
                        </p>
                        <div class="tp-caption fade tp-resizeme"
                           data-x="left" data-hoffset="15"
                           data-y="280"
                           data-width = "full"  
                           data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
                           data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"  
                           data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
                           data-mask_out="x:0;y:0;s:inherit;e:inherit;" 
                          data-start="1200"
                           style="z-index: 12;">
                       <a href="food.php#food" class="btn-common btn-white page-scroll">Order Now</a>
                       </div>
                        
                       
							</li>
							
							<li class="text-center" data-index="rs-130" data-transition="slideleft" data-slotamount="default" data-rotate="0"  data-title="" data-description="">
								<img src="images/SouthPerks.png"  alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
                        <h1 class="tp-caption tp-resizeme" 
                          data-x="center" data-hoffset="15"
                          data-y="70" 
                          data-transform_idle="o:1;"
                          data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;" 
                          data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;" 
                          data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
                          data-mask_out="x:0;y:0;s:inherit;e:inherit;" 
                          data-start="500" 
                          data-splitin="none" 
                          data-splitout="none" 
                          style="z-index: 6;">
                          <span class="small_title">  Delicious Food </span> <br> made &nbsp; as you &nbsp; <span class="color">Order &nbsp;</span>
                        </h1>
                        <p class="tp-caption tp-resizeme"
                          data-x="center" data-hoffset="15"
                          data-y="210" 
                          data-transform_idle="o:1;"
                          data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;" 
                          data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;" 
                          data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
                          data-mask_out="x:0;y:0;s:inherit;e:inherit;" 
                          data-start="800"
                          style="z-index: 9;">Enjoy Delicious Food!
                        </p>
							
                            
                          <div class="tp-caption fade tp-resizeme"
                           data-x="center" data-hoffset="15"
                           data-y="280"
                           data-width = "full"  
                           data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
                           data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"  
                           data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
                           data-mask_out="x:0;y:0;s:inherit;e:inherit;" 
                          data-start="1200"
                           style="z-index: 12;">
                          <a href="food.php#food" class="btn-common btn-orange page-scroll">Order &nbsp; Now</a>
                       </div>  
                            </li>
						
							<li class="text-right" data-index="rs-131" data-transition="slideleft"   data-rotate="0" data-title="" data-description="">
								<img src="images/Tummy2.png" alt="" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat" class="rev-slidebg" data-no-retina>
                        <h1 class="tp-caption tp-resizeme" 
                          data-x="right" data-hoffset="" 
                          data-y="70" 
                          data-transform_idle="o:1;"
                          data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;" 
                          data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;" 
                          data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
                          data-mask_out="x:0;y:0;s:inherit;e:inherit;" 
                          data-start="500" 
                          data-splitin="none" 
                          data-splitout="none" 
                          style="z-index: 6;">
                          <span class="small_title">Prepared from</span> <br> <span class="color">Fresh Ingredients</span>
                        </h1>
                        <p class="tp-caption tp-resizeme"
                          data-x="right" data-hoffset="" 
                          data-y="210" 
                          data-transform_idle="o:1;"
                          data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;" 
                          data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;" 
                          data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
                          data-mask_out="x:0;y:0;s:inherit;e:inherit;" 
                          data-start="800"
                          style="z-index: 9;">Enjoy Delicious Food!
                        </p>
							
                           <div class="tp-caption fade tp-resizeme"
                           data-x="right" data-hoffset=""
                           data-y="280"
                           data-width = "full" 
                           data-transform_idle="o:1;"
                           data-transform_in="y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;s:1500;e:Power3.easeInOut;"
                           data-transform_out="auto:auto;s:1000;e:Power3.easeInOut;"  
                           data-mask_in="x:0px;y:0px;s:inherit;e:inherit;" 
                           data-mask_out="x:0;y:0;s:inherit;e:inherit;" 
                          data-start="1200"
                           style="z-index: 12;">
                       <a href="food.php#food" class="btn-common btn-white page-scroll">Order Now</a>
                       </div>  
                            </li>
							<!-- SLIDE  -->
						</ul>
					</div>
				</div>
 <!-- END REVOLUTION SLIDER -->

<section id="news" class="padding bg_white">
  <div class="container">
      <div>
          <h2 class="heading">Tummy &nbsp; News</h2>
          <hr class="heading_space">
      </div>
        <div class="col-md-12">
            <div class="cheffs_wrap_slider">
                <div id="news-slider" class="owl-carousel">
                <?php
                $resultnews = $mysqli->query("SELECT * FROM news WHERE NOT hidden ORDER BY `date` DESC");
                while ($row = $resultnews->fetch_assoc()) {
                ?>
                <div id="newsItem" class="item epic-texthover">
                  <div class="news_content" style="pointer-events: none; padding-top: 10px;">
                    <img src="img-uploads/<?= $row["image"] ?>" style="width: center; height: 255px; object-fit: cover; box-shadow: 2px 2px 10px;"  alt="news banner">
                    <div style="margin-top: 10px;">
                        <h3><?= $row["title"] ?></h3>
                        <p><?= getLongDateFormat($row["date"]) ?></p>
                    </div>
                    <form>
                      <input type="hidden" value="<?= $row["content"] ?>">
                    </form>
                  </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
  </div>
</section>



<!-- image with content -->
<section class="info_section paralax">
  <div class="container">
    <div class="row">
      <div class="col-md-2"> </div>
      <div class="col-md-8">
         <div class="text-center">
         <h2 class="heading_space">Freshly Cooked Food</h2>
         <p class="heading_space detail">Enjoy Delicious Food!</p>
         <a href="food.php#food" class="btn-common-white page-scroll">Order Now</a>
         </div>          
      </div>
      <div class="col-md-2"></div>
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
        <?php
        $resultfb = $mysqli->query("SELECT * FROM feedbacks WHERE NOT hidden");
        while ($row = $resultfb->fetch_assoc()) {
        ?>
        <div class="item">
          <div class="epic-starcontainer" style="pointer-events: none;">
              <?php
              for ($i = 0; $i < 5; $i++)
              {
                  if ($i < (int)$row["rating"]) echo '<span class="epic-star fa fa-star epic-starc" style="margin: 0 2px;"></span>';
                  else echo '<span class="epic-star fa fa-star" style="margin: 0 2px;"></span>';
              }
              ?>
          </div>
          <h3><?= $row["feedback"] ?></h3>
          <p><?= $users[$row["user_id"]]["name"] ?></p>
        </div>
        <?php
        }
        ?>
       </div>
      </div>
    </div>
  </div>
</section>

<!-- Gallery -->
<section id="gallery" class="padding bg_white">
    <div class="container">
        <div class="text-center">
            <h2 class="heading">Tummy &nbsp; Gallery</h2>
            <hr class="heading_space">
        </div>
        <div class="col-md-12">
            <div class="cheffs_wrap_slider">
                <div id="news-slider" class="owl-carousel">

                    <?php
                    $resultfeat = $mysqli->query("SELECT * FROM gallery ORDER BY `date` DESC");
                    while ($row = $resultfeat->fetch_assoc()) {
                    ?>
                    <a class="fancybox" href="img-uploads/<?= $row["filename"] ?>"><div id="newsItem" class="item epic-texthover" style="padding: 0; margin: 10px; box-shadow: 2px 2px 10px;">
                        <div class="news_content" style="pointer-events: none;">
                            <img src="img-uploads/<?= $row["filename"] ?>" style="width: center; height: 255px; object-fit: cover;" alt="image">
                        </div>
                    </div></a>
                    <?php
                    }
                    ?>
                    
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
include 'global/customerfooter.html';
?>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!-- The Modal -->
<div id="epicModal" class="epic-modal">
    <div class="epic-modal-content" style="width: 50%;">
        <div class="epic-modal-header">
            <span class="epic-modal-close">&times;</span>
            <h2>Tummy &nbsp; News</h2>
        </div>
        <div class="epic-modal-body row">
          <img id="modalNewsImage" class="col-md-12" src="img-uploads/placeholder.png" style="object-fit: cover;" alt="news image"/>
            <div class="col-md-12 container" style="margin-top: 20px;">
                <h2 id="modalNewsTitle">News Title</h2>
                <p id="modalNewsDate" class="epic-sanssb" style="font-size: 18px;">Date</p>
            </div>
            <div class="col-md-12 container" style="margin-top: 20px;">
                <p id="modalNewsContent" class="epic-sanssb">Content</p>
            </div>
        </div>
        <div class="epic-modal-footer"><i>tummy-avenue.com</i></div>
    </div>
</div>

<!--JS-->
<?php 
include 'global/customerjs.html';
?>
<script>
const newsArr = document.querySelectorAll("#newsItem");

newsArr.forEach(bt=>{
    bt.addEventListener('click', (e) => {
      const newsitem = e.target.children[0].children;
      document.getElementById("modalNewsImage").src = newsitem[0].src;
      document.getElementById("modalNewsTitle").innerHTML = newsitem[1].children[0].innerHTML;
      document.getElementById("modalNewsDate").innerHTML = newsitem[1].children[1].innerHTML;
      document.getElementById("modalNewsContent").innerHTML = newsitem[2].children[0].value;
      epicOpenModal();
    })
})
</script>
 
</body>
</html>
