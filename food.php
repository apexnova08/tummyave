<?php
$mysqli = require __DIR__ . "/database.php";
require __DIR__ . "/global/funcs.php";

session_start();
$userid = "empty";
if (isset($_SESSION["user_id"])) $userid = $_SESSION["user_id"];
session_abort();

// GET FOODS
$foodarray = array();
echo ('<script>let foodVDict = {};</script>');
$result_food = $mysqli->query("SELECT * FROM foods");
while ($rowfood = $result_food->fetch_assoc())
{
    $foodarray[$rowfood["id"]] = $rowfood;
    echo ("<script>foodVDict[" . $rowfood["id"] . "] = " . $rowfood["hasVariations"] . ";</script>");
}
$foodtotalcost = 0;

// GET FOOD VARIATIONS
$variantarray = array();
echo ('<script>const variationsArr = [];</script>');
$result_variants = $mysqli->query("SELECT * FROM food_variations");
while ($rowvariant = $result_variants->fetch_assoc())
{
    $variantarray[$rowvariant["id"]] = $rowvariant;
}

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
<title>Tummy Avenue | Our Food</title>

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
                <h2 class="title">Our &nbsp; Food</h2>
                <p>Check out our menu and some of our special, featured best sellers!</p>
            </div>
        </div>
    </div>  
</section>

<!-- ## CONTENT HERE ## -->
<?php
$ftscountraw = $mysqli->query("SELECT COUNT(*) AS total FROM foods WHERE NOT archived AND featured");
$ftscount = $ftscountraw->fetch_assoc();
if ($ftscount['total'] != "0")
{
?>
<section id="featured" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Featured &nbsp; Food</h2>
            <hr class="heading_space">
        </div>
        <div class="col-md-12">
            <div class="cheffs_wrap_slider">
                <div id="news-slider" class="owl-carousel">

                    <?php
                    $resultfeat = $mysqli->query("SELECT * FROM foods WHERE NOT archived AND featured");
                    while ($row = $resultfeat->fetch_assoc()) {
                    ?>
                    <a href="#food"><div id="newsItem" class="item epic-texthover" style="padding: 0; margin: 10px; box-shadow: 2px 2px 10px;">
                        <div class="news_content" style="pointer-events: none;">
                            <img src="img-uploads/<?= $row["image"] ?>" style="width: center; height: 255px; object-fit: cover;" alt="image">
                            <h3 style="padding: 10px;"><?= $row["name"] ?></h3>
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
}
?>

<section id="cart" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Your &nbsp; Cart</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $abletocheckout = true;
            $result_cart = $mysqli->query("SELECT * FROM carts WHERE user_id = '$userid'");
            while ($row = $result_cart->fetch_assoc()) {
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
                    $abletocheckout = false;
                    $cartitemavailable = false;
                    $cartitemname = $cartitemname . ' &nbsp; <span style="color: red;">[UNAVAILABLE]</span>';
                }
            ?>
            <div class="row epic-li">
                <div class="col-md-8 <?php if (!$cartitemavailable) echo("epic-graytxt"); ?>" style="overflow: hidden; margin-bottom: 10px;">
                    <img src="<?= 'img-uploads/' . $foodarray[$row["food_id"]]["image"] ?>" style="width: 100px; height: 70px; object-fit: cover; float: left" alt="image"/>
                    <div style="margin: 10px 0 0 20px; float: left;">
                        <h3 class="epic-bebas"><?= $cartitemname ?></h3>
                        <h4 class="epic-sanssb"><span class="epic-sanss">₱</span><?= getPriceFormat($cartitemcost) ?> ea.</h4>
                    </div>
                </div>
                <div class="col-md-4 right" style="margin-top: 10px;">
                    <form enctype="multipart/form-data" action="usercustomer/processes/cart-process.php" method="post" style="float: right; margin: 10px 0 0 20px;">
                        <button class="epic-btn">Remove</button>
                        <input type="hidden" name="id" value="<?= $row['id']; ?>"/>
                    </form>
                    <div style="float: right;" <?php if (!$cartitemavailable) echo("class='epic-graytxt'"); ?>>
                        <em>subtotal</em>
                        <h4 class="epic-sanssb"><span class="epic-sanss">₱</span><?= getPriceFormat($cartitemcost * $row["amount"]) ?></h4>
                        <p class="epic-sanssb"><i>amount: <?= $row["amount"] ?></i></p>
                    </div>
                    
                </div>
            </div>
            <?php
            } if (mysqli_num_rows($result_cart) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
            else {
            ?>
            <div style="margin-top: 30px;">
                <h3 class="epic-bebas">Total</h3>
                <h2 class="epic-sanss">₱<span class="epic-sanssb"><?= getPriceFormat($foodtotalcost) ?></span></h2>
                <a href="usercustomer/checkout.php"><button class="epic-btn" style="margin-top: 20px;" <?php if (!$abletocheckout) echo("disabled"); ?>>Checkout</button></a>
            </div>
            
            <?php } ?>
        </div>
    </div>
</section>

<section id="food" class="padding bg_white">
    <div class="container">
        <div class="text-center">
            <h2 class="heading">Our &nbsp; Menu</h2>
            <hr class="heading_space">
            <div class="work-filter">
                <ul class="text-center">
                    <li><a href="javascript:;" data-filter="all" class="active filter">All Foods</a></li>
                    <?php
                    $resultctg = $mysqli->query("SELECT * FROM categories WHERE NOT hidden");
                    while ($row = $resultctg->fetch_assoc()) {
                    ?>
                    <li><a href="javascript:;" data-filter=".<?= $row["id"] ?>" class="filter"><?= $row["name"] ?></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div>
            <div class="grid_layout">
                <div class="zerogrid">
                    <div class="wrap-container">
                        <div>

                            <?php
                            $result = $mysqli->query("SELECT * FROM foods WHERE NOT archived");
                            while ($row = $result->fetch_assoc()) {
                            ?>

                            <div class="col-1-3 mix work-item <?= $row["category"] ?>">
                                <div class="first" style="overflow: hidden; margin: 0 10px 30px 10px; box-shadow: 2px 2px 10px;">
                                    <div class="item-container" style="border-bottom: 2px solid #E25111;">
                                        <img src="img-uploads/<?=$row['image'] ?>" style="width: center; height: 255px; object-fit: cover;" alt="<?= $row['name'] ?>"/>
                                        <?php if ($row["available"]) { ?>
                                        <div class="overlay food-item" style="cursor: pointer;">
                                            <p class="overlay-inner" style="pointer-events: none;"><?= $row['name'] ?></p>
                                            <input type="hidden" value="<?= $row['id'] ?>"/>
                                            <input type="hidden" value="<?= $row['cost'] ?>"/>
                                            <input type="hidden" value="<?= $row['image'] ?>"/>
                                            <input type="hidden" value="<?= $row['description'] ?>"/>
                                        </div>
                                        <?php } else { ?>
                                            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; text-align: center; background-color: black; opacity: .7;">
                                                <label style="margin-top: 110px; color: white;" class="epic-sanss epic-txt20">UNAVAILABLE</label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div style="height: 30px; overflow: hidden; padding: 0 5px;">
                                        <div style="float: left; width: 70%; padding-top: 5px;">
                                            <h4><?= chars25Max($row['name']) ?></h4>
                                        </div>
                                        <div class="epic-orangetxt" style="float: right; width: 30%; text-align: right;">
                                            ₱<span class="epic-txt20"><?php if ($row["hasVariations"])
                                            {
                                                $foodid = $row["id"];
                                                $rcostraw = $mysqli->query("SELECT cost AS c FROM food_variations WHERE food_id = '$foodid' AND NOT `disabled` LIMIT 1");
                                                $rcost = $rcostraw->fetch_assoc();
                                                echo(getPriceFormat($rcost["c"]));
                                            } else echo getPriceFormat($row['cost']) ?></span>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="reviews" class="padding bg_white">
    <div class="container">
        <div class="col-md-12 text-center">
            <h2 class="heading">Our &nbsp; Happy &nbsp; Customers</h2>
            <hr class="heading_space">
        </div>
        <div class="row">
      <div class="col-md-12">
        <div id="testinomial-slider" class="owl-carousel text-center">
            <?php
            $resultnews = $mysqli->query("SELECT * FROM feedbacks WHERE NOT hidden");
            while ($row = $resultnews->fetch_assoc()) {
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
</section>



<!--Page Footer-->
<?php 
include 'global/customerfooter.html';
?>
<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--Notifications-->
<section id="notifContainer" class="epic-notifcontainer">
</section>

<!-- The Modal -->
<div id="epicModal" class="epic-modal">
    <div class="epic-modal-content">
        <div class="epic-modal-header">
            <span class="epic-modal-close">&times;</span>
            <h2>Add &nbsp; to &nbsp; Cart</h2>
        </div>
        <div class="epic-modal-body row">
            <img id="modalFoodImage" class="col-md-4 epicm-width100p" src="img-uploads/placeholder.png" style="width: 255px; height: 255px; object-fit: cover;" alt="food image"/>
            <div class="col-md-8 container">
                <h2 id="modalFoodName" class="epicm-margintop10">Food Name</h2>
                <p id="modalFoodDesc" style="margin: 20px 0; height: 150px; overflow: auto;">Description</p>
                <form action="usercustomer/processes/addtocart-process.php" method="post">
                    <input id="modalFoodId" type="hidden" name="foodId" value="0"/>
                    <button class="epic-btnr" style="padding: 10px 20px;" onclick="amountSubtract()" type="button"><i class="fa fa-minus"></i></button>
                    <input id="modalFoodAmount" class="epic-txtbox" style="width: 100px; text-align: center;" type="number" name="amount" value="1">
                    <button class="epic-btnr" style="padding: 10px 20px;" onclick="amountAdd()" type="button"><i class="fa fa-plus"></i></button>
                    <input class="epic-btn" style="margin-left: 20px;" type="submit">
                    <label class="epic-orangetxt" style="margin-left: 20px;">₱<span id="modalFoodCost" style="font-size: 25px;">0.00</span></label>
                    
                    <!-- VARIATIONS -->
                    <input type="hidden" id="modalVariantID" name="variantID">
                </form>
                <ul id="modalVariants" class="epic-variants">
                </ul>
            </div>
        </div>
        <div class="epic-modal-footer"><i>tummy-avenue.com</i></div>
    </div>
</div>

<!--JS-->
<?php 
include 'global/customerjs.html';

// APPEND FOOD VARIATIONS TO JS ARRAY

echo ('<script>const variationsArr = [];</script>');
foreach ($variantarray as $variant)
{
    if (!$variant["disabled"]) echo ("<script>variationsArr.push(new EpicVariation('" . $variant['id'] . "', '" . $variant['food_id'] . "', '" . $variant['name'] . "', '" . $variant['cost'] . "'));</script>");
}
?>

<script>
const foodArr = document.querySelectorAll(".food-item");
var txtAmount = document.getElementById("modalFoodAmount");
var variantID = document.getElementById("modalVariantID");
var selectedFoodCost = 0;
var selectedFoodName = "";

let variantContainer = document.getElementById("modalVariants");
foodArr.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        foodid = e.target.children[1].value;
        selectedFoodName = e.target.children[0].innerHTML;
        document.getElementById("modalFoodImage").src = "img-uploads/" + e.target.children[3].value;
        document.getElementById("modalFoodName").innerHTML = selectedFoodName;
        document.getElementById("modalFoodDesc").innerHTML =  e.target.children[4].value;
        document.getElementById("modalFoodId").value = foodid;

        selectedFoodCost = parseInt(e.target.children[2].value);
        document.getElementById("modalFoodCost").innerHTML = getPriceFormat(e.target.children[2].value);
        txtAmount.value = "1";

        variantID.value = "0";
        variantContainer.innerHTML = '';
        if (foodVDict[foodid])
        {
            variantID.value = "0";
            variationsArr.forEach(v=>{
                if (v.foodId === foodid)
                {
                    const node = document.createElement("li");
                    const textnode = document.createTextNode(v.name);
                    node.appendChild(textnode);
                    node.addEventListener('click', (e) => {
                        epicSelectVariation(e);
                        selectVariation(v);
                    })

                    if (variantID.value === "0")
                    {
                        node.classList.add("epic-vActive");
                        selectVariation(v);
                    }
                    variantContainer.appendChild(node);
                }
            });
        }
        epicOpenModal();
    })
})

function amountAdd()
{
    var amount = parseInt(txtAmount.value) + 1
    setNewAmount(amount);
}
function amountSubtract()
{
    var amount = parseInt(txtAmount.value) - 1
    setNewAmount(amount);
}
txtAmount.addEventListener('input', (e) => {
    if (txtAmount.value.length === 0) txtAmount.value = "1";
    setNewAmount(parseInt(txtAmount.value))
});
function setNewAmount(amount)
{
    var newAmount = amount;
    if (amount > 99) newAmount = 99;
    else if (amount < 1) newAmount = 1;

    txtAmount.value = newAmount.toString();
    document.getElementById("modalFoodCost").innerHTML = getPriceFormat(selectedFoodCost * newAmount);
}

function selectVariation(variation)
{
    variantID.value = variation.id;
    document.getElementById("modalFoodName").innerHTML = selectedFoodName + " &nbsp; (" + variation.name + ")";
    selectedFoodCost = variation.cost;
    setNewAmount(txtAmount.value);
}

loadDoc();
</script>
 
</body>
</html>