<?php 
include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

session_start();
$userid = "empty";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
session_abort();

// GET FOODS
$foodarray = array();
$foodresult = $mysqli->query("SELECT * FROM foods");
while ($foodrow = $foodresult->fetch_assoc())
{
    $foodarray[$foodrow["id"]] = $foodrow;
}

$foodtotal = 0;
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
    include '../global/uf/top.html';
    ?>

</head>

<body>

<!--#####-->
<section id="order" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="orders.php" class="epic-a"><< Back</a></div>
        <div>
            <h2 class="heading">Checkout</h2>
            <hr class="heading_space">
        </div>
        <div>
            <div>
                <h2><?= getCurrentDate() ?></h2><br/><br/>

                <h3 class="epic-bebas">Customer</h3>
                <label class="sanssb" style="font-weight: normal; font-size: 18px; margin: 0;"><?= $user["name"] ?></label><br/>
                <label class="sanssb" style="font-weight: normal; font-size: 18px; margin: 0;"><?= $user["contact"] ?></label>
            </div>
        </div>
        
        <div class="col-md-12" style="margin-top: 40px;">
            <h3 class="epic-bebas">Items</h3>
            <?php
            $result = $mysqli->query("SELECT * FROM carts WHERE user_id = '$userid'");
            while ($row = $result->fetch_assoc()) {
                $foodtotal = $foodtotal + ($foodarray[$row["food_id"]]["cost"] * $row["amount"]);
            ?>
            <div class="row epic-li">
                <div class="col-md-8" style="overflow: hidden; margin-bottom: 10px;">
                    <img src="<?= '../img-uploads/' . $foodarray[$row["food_id"]]["image"] ?>" style="width: 100px; height: 70px; object-fit: cover; float: left" alt="image"/>
                    <div style="margin: 10px 0 0 20px; float: left;">
                        <h3 class="epic-bebas"><?= $foodarray[$row["food_id"]]["name"] ?></h3>
                        <h4 class="epic-sanssb"><span class="epic-sanss">₱</span><?= $foodarray[$row["food_id"]]["cost"] ?>.00 ea.</h4>
                    </div>
                </div>
                <div class="col-md-4 right" style="margin-top: 10px;">
                    <em>subtotal</em>
                    <h4 class="epic-sanssb"><span class="epic-sanss">₱</span><?= $foodarray[$row["food_id"]]["cost"] * $row["amount"] ?>.00</h4>
                    <p class="epic-sanssb"><i>amount: <?= $row["amount"] ?></i></p>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
    <div class="container" style="margin-top: 50px; overflow: hidden;">
        <form enctype="multipart/form-data" action="processes/checkout-process.php" method="post">
            <button class="epic-btn">Place Order</button>
            <label class="epic-sanss epic-txt25" style="margin-left: 30px;">₱<span class="epic-sanssb"><?= $foodtotal ?>.00</span></label>
        </form>
    </div>
</section>


<!--Page Footer-->
<?php 
include 'footer.html';
?>
<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include '../global/uf/js.html';
?>

</body>
</html>