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
    <title>Admin Panel | Menu</title>
    
    <!--CSS-->
    <?php 
    include 'cfolder/css.html';
    ?>
    
    <!--NAV-->
    <?php 
    include 'nav.php';
    ?>

</head>

<body>

<!-- ## CONTENT HERE ## -->
<section id="section_name" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="closedorders.php" class="epic-a">View closed orders ></a></div>
        <div>
            <h2 class="heading">Your &nbsp; Orders</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result = $mysqli->query("SELECT * FROM orders WHERE user_id = '$userid' AND NOT is_closed");
            while ($row = $result->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-8">
                    <h3 class="epic-bebas"><?= getLongDateFormat($row["date"]) ?></h3></br>
                    <h4 class="epic-sanssb"><?= $row["total_items"] ?> items &nbsp;•&nbsp; <span class="epic-sanss">₱</span><?= $row["total_cost"] ?>.00</h4>
                    <p class="epic-sanssb"><i><?= $row["status"] ?></i></p>
                </div>
                <div class="col-md-4 right">
                    <form enctype="multipart/form-data" method="post" action="orderpage.php">
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                        <input type="submit" class="epic-btn" value="Details">
                    </form>
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
include 'cfolder/footer.html';
?>
<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

</body>
</html>
