<?php 
include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

session_start();
$userid = "empty";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
session_abort();

// GET VARS
$vars = array();
$resultvars = $mysqli->query("SELECT * FROM vars");
while ($row = $resultvars->fetch_assoc())
{
    $vars[$row["name"]] = $row["value"];
}

// GET FOODS
$foodarray = array();
$foodresult = $mysqli->query("SELECT * FROM foods");
while ($foodrow = $foodresult->fetch_assoc())
{
    $foodarray[$foodrow["id"]] = $foodrow;
}

// GET FOOD VARIATIONS
$variantarray = array();
$result_variants = $mysqli->query("SELECT * FROM food_variations");
while ($rowvariant = $result_variants->fetch_assoc())
{
    $variantarray[$rowvariant["id"]] = $rowvariant;
}

$foodtotalcost = 0;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tummy Avenue | Checkout</title>
    
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
        <div style="text-align: right;"><a href="../food.php#cart" class="epic-a"><< Back</a></div>
        <div>
            <h2 class="heading">Checkout</h2>
            <hr class="heading_space">
        </div>
        <div>
            <div>
                <h2><?= getLongDateFormat(getCurrentDate()) ?></h2><br/><br/>

                <h3 class="epic-bebas">Customer</h3>
                <label class="epic-sanssb epic-txt18"><?= $user["name"] ?></label><br/>
                <label class="epic-sanssb epic-txt18"><?= $user["contact"] ?> &nbsp;•&nbsp; <?= $user["email"] ?></label>
            </div>
        </div>
        
        <div class="col-md-12" style="margin-top: 40px;">
            <h3 class="epic-bebas">Items</h3>
            <?php
            $abletoorder = true;
            $result = $mysqli->query("SELECT * FROM carts WHERE user_id = '$userid'");
            while ($row = $result->fetch_assoc()) {
                $cartitemcost = $foodarray[$row["food_id"]]["cost"];
                $cartitemname = $foodarray[$row["food_id"]]["name"];
                if ($row["variation_id"] != "0")
                {
                    $cartitemcost = $variantarray[$row["variation_id"]]["cost"];
                    $cartitemname = $foodarray[$row["food_id"]]["name"] . " &nbsp; (" . $variantarray[$row["variation_id"]]["name"] . ")";
                }
                $foodtotalcost = $foodtotalcost + ($cartitemcost * $row["amount"]);

                $cartitemavailable = true;
                if ($foodarray[$row["food_id"]]["archived"] || !$foodarray[$row["food_id"]]["available"] || ($foodarray[$row["food_id"]]["hasVariations"] && $row["variation_id"] === "0") || (!$foodarray[$row["food_id"]]["hasVariations"] && $row["variation_id"] != "0") || ($row["variation_id"] != "0" && $variantarray[$row["variation_id"]]["disabled"]))
                {
                    $abletoorder = false;
                    $cartitemavailable = false;
                    $cartitemname = $cartitemname . ' &nbsp; <span style="color: red;">[UNAVAILABLE]</span>';
                }
            ?>
            <div class="row epic-li">
                <div class="col-md-8 <?php if (!$cartitemavailable) echo("epic-graytxt"); ?>" style="overflow: hidden; margin-bottom: 10px;">
                    <img src="<?= '../img-uploads/' . $foodarray[$row["food_id"]]["image"] ?>" style="width: 100px; height: 70px; object-fit: cover; float: left" alt="image"/>
                    <div style="margin: 10px 0 0 20px; float: left;">
                        <h3 class="epic-bebas"><?= $cartitemname ?></h3>
                        <h4 class="epic-sanssb"><span class="epic-sanss">₱</span><?= getPriceFormat($cartitemcost) ?> ea.</h4>
                    </div>
                </div>
                <div class="col-md-4 right" style="margin-top: 10px;">
                    <em>subtotal</em>
                    <h4 class="epic-sanssb"><span class="epic-sanss">₱</span><?= getPriceFormat($cartitemcost * $row["amount"]) ?></h4>
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
            <button class="epic-btn" <?php if ($vars["store_closed"] || !$abletoorder || mysqli_num_rows($result) === 0) echo "disabled" ?>>Place Order</button>
            <label class="epic-sanss epic-txt25" style="margin-left: 30px;">₱<span class="epic-sanssb"><?= getPriceFormat($foodtotalcost) ?></span></label>
        </form>
        <?php if ($vars["store_closed"]) echo "<p class='epic-sansr' style='color: #777'>( Orders are disabled during closing hours )</p>" ?>
    </div>
</section>


<!--Page Footer-->
<?php 
include '../global/uf/footer.html';
?>
<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--Notifications-->
<section id="notifContainer" class="epic-notifcontainer">
</section>

<!--JS-->
<?php 
include '../global/uf/js.html';
?>

<script type="text/javascript">
    loadDoc(1);
</script>

</body>
</html>