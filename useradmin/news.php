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
    <title>Admin Panel | News</title>
    
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
        <a href="createnews.php"><button style="float: right;" class="epic-btn">Publish &nbsp; News &nbsp; +</button></a>
    </div>
</section>

<section id="section_name" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Tummy &nbsp; News</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result = $mysqli->query("SELECT * FROM news ORDER BY `date` DESC");
            while ($row = $result->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-7" style="overflow: hidden; margin-bottom: 10px;">
                    <img src="<?= '../img-uploads/' . $row["image"] ?>" style="width: 150px; height: 80px; object-fit: cover; float: left" alt="image"/>
                    <div style="margin: 10px 0 0 20px; float: left;">
                        <h3><?= $row["title"] ?></h3>
                        <label class="epic-sanssb"><?= getLongDateFormat($row["date"]) ?></label>
                    </div>
                </div>
                <div class="col-md-5 right">
                    <form enctype="multipart/form-data" method="post" action="updatenews.php">
                        <label class="epic-sanssb" style="color: <?= $boolColor[$row["hidden"]] ?>;"><em><?= $publicString[$row["hidden"]] ?></em></label>
                        <button class="epic-btn" style="margin-left: 20px;">Edit</button>
                        <input type="hidden" name="id" value="<?= $row['id']; ?>"/>
                    </form>
                </div>
            </div>
            <?php
            } if (mysqli_num_rows($result) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
            ?>
        </div>
    </div>
</section>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include '../global/uf/js.html';
include '../global/uf/adminfooter.php';
?>

</body>
</html>
