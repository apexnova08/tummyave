<?php
include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

session_start();
$userid = "empty";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
session_abort();

$foodarray = array();
$foodresult = $mysqli->query("SELECT * FROM foods");
while ($foodrow = $foodresult->fetch_assoc())
{
    $foodarray[$foodrow["id"]] = $foodrow;
}

$foodtotalcost = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cartid = $_POST["id"];
    $mysqli->query("DELETE FROM carts WHERE id = $cartid");
}
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
<section id="cart" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="../food.php" class="epic-a">Get more food ></a></div>
        <div>
            <h2 class="heading">Your &nbsp; Cart</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result_active = $mysqli->query("SELECT * FROM carts WHERE user_id = '$userid'");
            while ($row = $result_active->fetch_assoc()) {
                $foodtotalcost = $foodtotalcost + ($foodarray[$row["food_id"]]["cost"] * $row["amount"]);
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
                    <form enctype="multipart/form-data" method="post" style="float: right; margin: 10px 0 0 20px;">
                        <button class="epic-btn">Remove</button>
                        <input type="hidden" name="id" value="<?= $row['id']; ?>"/>
                    </form>
                    <div style="float: right;">
                        <em>subtotal</em>
                        <h4 class="epic-sanssb"><span class="epic-sanss">₱</span><?= $foodarray[$row["food_id"]]["cost"] * $row["amount"] ?>.00</h4>
                        <p class="epic-sanssb"><i>amount: <?= $row["amount"] ?></i></p>
                    </div>
                    
                </div>
            </div>
            <?php
            } if (mysqli_num_rows($result_active) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
            else {
            ?>
            <div style="margin-top: 30px;">
                <h3 class="epic-bebas">Total</h3>
                <h2 class="epic-sanss">₱<span class="epic-sanssb"><?= $foodtotalcost ?>.00</span></h2>
                <a href="checkout.php"><button class="epic-btn" style="margin-top: 20px;">Checkout</button></a>
            </div>
            
            <?php } ?>
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
