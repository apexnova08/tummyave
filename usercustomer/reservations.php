<?php
include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

session_start();
$userid = "empty";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
session_abort();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tummy Avenue | Your Reservations</title>
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    include 'nav.php';
    ?>

</head>

<body>

<!-- ## CONTENT HERE ## -->
<section id="reservations" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="../reservation.php" class="epic-a">Go to reservation page ></a></div>
        <div>
            <h2 class="heading">Your &nbsp; Venue &nbsp; Reservation &nbsp; History</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result = $mysqli->query("SELECT * FROM reservations WHERE user_id = '$userid' AND ((NOT status = 'Requested' AND NOT status = 'Reserved') OR DATE(rsv_date) <= '" . getCurrentDate() . "') ORDER BY rsv_date desc");
            while ($row = $result->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-8">
                    <h3 class="epic-bebas"><?= getLongDateFormat($row["rsv_date"]) ?></h3>
                    <p class="epic-sanssb"><?= getWeekDayName($row["rsv_date"])["dddd"] ?> &nbsp;•&nbsp; <?= $row["event"] ?></p>
                </div>
                <div class="col-md-4" style="text-align: right;">
                    <em class="epic-sanssb" style="margin-right: 20px; color: <?= getRHSColor($row["status"]) ?>;"><?= getRHS($row["status"]) ?></em>
                </div>
            </div>
            <?php
            } if (mysqli_num_rows($result) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
            ?>
        </div>
    </div>
</section>

<!--Page Footer-->
<?php 
include '../global/uf/footer.html';
?>
<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include '../global/uf/js.html';
?>

</body>
</html>
