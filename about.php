<?php
require __DIR__ . "/global/funcs.php";
$mysqli = require __DIR__ . "/database.php";

// GET VARS
$vars = array();
$resultvars = $mysqli->query("SELECT * FROM vars");
while ($row = $resultvars->fetch_assoc())
{
    $vars[$row["name"]] = $row["value"];
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tummy Avenue | About Us</title>

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
                <h2 class="title">About &nbsp; Us</h2>
                <p>Page description</p>
            </div>
        </div>
    </div>  
</section>

<!-- ## CONTENT HERE ## -->
<section id="about" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">About &nbsp; Tummy &nbsp; Avenue</h2>
            <hr class="heading_space">
        </div>
        <?php
        $result = $mysqli->query("SELECT * FROM about ORDER BY `order_num` ASC");
        while ($row = $result->fetch_assoc()) {
        ?>
        <div style="overflow: hidden; margin: 50px 0;">
            <div class="col-md-4">
                <img src="img-uploads/<?= $row["image"] ?>" style="width: 100%; object-fit: cover;" alt="image"/>
            </div>
            <div class="col-md-8">
                <h2 class="epic-sanssb epic-upper"><?= $row["title"] ?></h2>
                <p class="epic-sanss epic-txt16" style="margin: 20px 0;"><?= $row["text"] ?></p>
            </div>
        </div>
        <?php
        } if (mysqli_num_rows($result) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
        ?>
    </div>
</section>


<section id="location" class="padding bg_white">
    <div class="container">
        <div class="text-center">
            <h2 class="heading">Where &nbsp; We &nbsp; Are</h2>
            <hr class="heading_space">
        </div>
        <div>
        <iframe src="<?= $vars["map_link"] ?>" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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