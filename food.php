<?php
$mysqli = require __DIR__ . "/database.php";
require __DIR__ . "/global/funcs.php";

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
$reqscountraw = $mysqli->query("SELECT COUNT(*) AS total FROM foods WHERE NOT archived AND featured");
$reqscount = $reqscountraw->fetch_assoc();
if ($reqscount['total'] != "0")
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

<?php
$cartcountraw = $mysqli->query("SELECT COUNT(*) AS total FROM carts WHERE user_id = '$userid'");
$cartcount = $cartcountraw->fetch_assoc();
if ($cartcount['total'] != "0")
{
?>
<section id="cart" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Your &nbsp; Cart</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result_cart = $mysqli->query("SELECT * FROM carts WHERE user_id = '$userid'");
            while ($row = $result_cart->fetch_assoc()) {
                $foodtotalcost = $foodtotalcost + ($foodarray[$row["food_id"]]["cost"] * $row["amount"]);
            ?>
            <div class="row epic-li">
                <div class="col-md-8" style="overflow: hidden; margin-bottom: 10px;">
                    <img src="<?= 'img-uploads/' . $foodarray[$row["food_id"]]["image"] ?>" style="width: 100px; height: 70px; object-fit: cover; float: left" alt="image"/>
                    <div style="margin: 10px 0 0 20px; float: left;">
                        <h3 class="epic-bebas"><?= $foodarray[$row["food_id"]]["name"] ?></h3>
                        <h4 class="epic-sanssb"><span class="epic-sanss">₱</span><?= getPriceFormat($foodarray[$row["food_id"]]["cost"]) ?> ea.</h4>
                    </div>
                </div>
                <div class="col-md-4 right" style="margin-top: 10px;">
                    <form enctype="multipart/form-data" action="usercustomer/processes/cart-process.php" method="post" style="float: right; margin: 10px 0 0 20px;">
                        <button class="epic-btn">Remove</button>
                        <input type="hidden" name="id" value="<?= $row['id']; ?>"/>
                    </form>
                    <div style="float: right;">
                        <em>subtotal</em>
                        <h4 class="epic-sanssb"><span class="epic-sanss">₱</span><?= getPriceFormat($foodarray[$row["food_id"]]["cost"] * $row["amount"]) ?></h4>
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
                <a href="usercustomer/checkout.php"><button class="epic-btn" style="margin-top: 20px;">Checkout</button></a>
            </div>
            
            <?php } ?>
        </div>
    </div>
</section>
<?php
}
?>

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
                                <div class="wrap-col first" style="overflow: hidden; padding: 0 0 10px 0; margin: 0 10px 30px 10px; box-shadow: 2px 2px 10px;">
                                    <div class="item-container" style="border-bottom: 2px solid #E25111;">
                                        <img src="img-uploads/<?=$row['image'] ?>" style="width: center; height: 255px; object-fit: cover;" alt="<?= $row['name'] ?>"/>
                                        <div class="overlay food-item" style="cursor: pointer;">
                                            <p class="overlay-inner" style="pointer-events: none;"><?= $row['name'] ?></p>
                                            <input type="hidden" value="<?= $row['id'] ?>"/>
                                            <input type="hidden" value="<?= $row['cost'] ?>"/>
                                            <input type="hidden" value="<?= $row['image'] ?>"/>
                                            <input type="hidden" value="<?= $row['description'] ?>"/>
                                        </div>
                                    </div>
                                    <div class="epic-orangetxt" style="float: right; padding-right: 10px;">
                                        ₱<span style="font-size: 25px;"><?= getPriceFormat($row['cost']) ?></span>
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

<!-- The Modal -->
<div id="epicModal" class="epic-modal">
    <div class="epic-modal-content">
        <div class="epic-modal-header">
            <span class="epic-modal-close">&times;</span>
            <h2>Add &nbsp; to &nbsp; Cart</h2>
        </div>
        <div class="epic-modal-body row">
            <img id="modalFoodImage" class="col-md-4" src="img-uploads/placeholder.png" style="width: 255px; height: 255px; object-fit: cover;" alt="food image"/>
            <div class="col-md-8 container">
                <h2 id="modalFoodName">Food Name</h2>
                <p id="modalFoodDesc" style="margin: 20px 0; height: 150px; overflow: auto;">Description</p>
                <form action="usercustomer/processes/addtocart-process.php" method="post">
                    <input id="modalFoodId" type="hidden" name="foodId" value="0"/>
                    <button class="epic-btnr" style="padding: 10px 20px;" onclick="amountSubtract()" type="button"><i class="fa fa-minus"></i></button>
                    <input id="modalFoodAmount" class="epic-txtbox" style="width: 100px; text-align: center;" type="number" name="amount" value="1">
                    <button class="epic-btnr" style="padding: 10px 20px;" onclick="amountAdd()" type="button"><i class="fa fa-plus"></i></button>
                    <input class="epic-btn" style="margin-left: 20px;" type="submit">
                    <label class="epic-orangetxt" style="margin-left: 20px;">₱<span id="modalFoodCost" style="font-size: 25px;">0.00</span></label>
                </form>
            </div>
        </div>
        <div class="epic-modal-footer"><i>tummy-avenue.com</i></div>
    </div>
</div>

<!--JS-->
<?php 
include 'global/customerjs.html';
?>
<script>
const foodArr = document.querySelectorAll(".food-item");
var txtAmount = document.getElementById("modalFoodAmount");
var selectedFoodCost = 0;

foodArr.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        document.getElementById("modalFoodImage").src = "img-uploads/" + e.target.children[3].value;
        document.getElementById("modalFoodName").innerHTML = e.target.children[0].innerHTML;
        document.getElementById("modalFoodDesc").innerHTML =  e.target.children[4].value;
        document.getElementById("modalFoodId").value =  e.target.children[1].value;

        selectedFoodCost = parseInt(e.target.children[2].value);
        document.getElementById("modalFoodCost").innerHTML = getPriceFormat(e.target.children[2].value);
        txtAmount.value = "1";

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
</script>
 
</body>
</html>