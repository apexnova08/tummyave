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
        <button style="float: right;" class="epic-btn" onClick="window.location.reload();">Refresh &nbsp; Orders</button>
    </div>
</section>

<section id="orders" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="orderhistory.php" class="epic-a">View history ></a></div>
        <div>
            <h2 class="heading">Active &nbsp; Orders</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result = $mysqli->query("SELECT * FROM orders WHERE NOT is_closed ORDER BY date DESC");
            while ($row = $result->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-6">
                    <div style="float: left; margin: 10px;">
                        <h3 class="epic-bebas">Order &nbsp; Ref#<?= $row["id"] ?></h3>
                        <label class="epic-sanssb"><?= getLongDateFormat($row["date"]) ?></label>
                    </div>
                </div>
                <div class="col-md-6 right">
                    <form style="float: right; margin: 10px;" enctype="multipart/form-data" method="post" action="orderpage.php">
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                        <input type="submit" class="epic-btn" value="Update">
                    </form>
                    <div style="float: right; margin: 10px;">
                        <h4 class="epic-sanssb"><?= $row["total_items"] ?> items &nbsp;•&nbsp; <span class="epic-sanss">₱</span><?= $row["total_cost"] ?>.00</h4>
                        <label class="epic-sanssb"><i><?= $row["status"] ?></i></label>
                    </div>
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
?>

</body>
</html>
