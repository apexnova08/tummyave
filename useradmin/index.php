<?php 
include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | Menu</title>
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    include 'nav.php';
    ?>

</head>

<body>

<!--#####-->
<section id="topBtns" style="padding-top: 30px;">
    <div class="container" style=" overflow: hidden;">
        <a href="createfood.php"><button style="float: right;" class="epic-btn">Add &nbsp; Food &nbsp; +</button></a>
    </div>
</section>

<section id="section_name" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Foods &nbsp; List</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result = $mysqli->query("SELECT * FROM foods");
            while ($row = $result->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-8" style="overflow: hidden; margin-bottom: 10px;">
                    <img src="<?= '../img-uploads/' . $row["image"] ?>" style="width: 150px; height: 100px; object-fit: cover; float: left" alt="image"/>
                    <div style="margin: 10px 0 0 20px; float: left;">
                        <h3 class="epic-bebas"><?= $row["name"] ?></h3>
                        <h4 class="epic-sanssb"><span class="epic-sanss">₱</span><?= $row["cost"] ?>.00</h4></br>
                        <label class="epic-sanssb">Item ID: <?= $row["id"] ?> &nbsp; &nbsp; <i style="color: <?= $boolColor[$row["archived"]] ?>;"><?= $enabledString[$row["archived"]] ?></i></label>
                    </div>
                </div>
                <div class="col-md-4 right" style="margin-top: 10px;">
                    <form enctype="multipart/form-data" method="post" action="updatefood.php" style="float: right; margin: 10px 0 0 20px;">
                        <button class="epic-btn">Edit</button>
                        <input type="hidden" name="id" value="<?= $row['id']; ?>"/>
                    </form>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include '../global/uf/js.html';
?>

</body>
</html>
