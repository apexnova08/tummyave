<?php 
include 'processes/redirect.php';
?>

<?php
require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

// GET FOODS
$foodarray = array();
$foodresult = $mysqli->query("SELECT * FROM foods");
while ($foodrow = $foodresult->fetch_assoc())
{
    $foodarray[$foodrow["id"]] = $foodrow;
}

// GET ORDER
$id = $_POST["id"];
$sql = sprintf("SELECT * FROM orders WHERE id = '%s'", $mysqli->real_escape_string($id));
$result = $mysqli->query($sql);
$order = $result->fetch_assoc();

// GET USER INFO
$sql = sprintf("SELECT * FROM users WHERE id = '%s'", $mysqli->real_escape_string($order["user_id"]));
$result = $mysqli->query($sql);
$user = $result->fetch_assoc();

// UPDATE
if (isset($_POST["update"]))
{
    if ($order["is_paid"] === '0')
    {
        $sql = "UPDATE orders SET is_paid = '1', status = 'Preparing' WHERE id = '$id'";
    }
    elseif ($order["status"] === "Preparing")
    {
        $sql = "UPDATE orders SET status = 'Ready for pickup' WHERE id = '$id'";
    }
    elseif ($order["status"] === "Ready for pickup")
    {
        $sql = "UPDATE orders SET status = 'Picked up', is_closed = true WHERE id = '$id'";
    }
    
    if ($mysqli->query($sql))
    {
        header("location: ../usercashier/");
    }
    else die ("Error updating order.");
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
    include 'top.php';
    ?>

</head>

<body>

<!--#####-->
<section id="order" class="padding bg_white">
    <div class="container">
    <div style="text-align: right;"><a href="orders.php" class="epic-a"><< Back</a></div>
        <div>
            <h2 class="heading">Order &nbsp; Details</h2>
            <hr class="heading_space">
        </div>
        <div>
            <div class="col-md-6">
                <h2>Order &nbsp; Ref# &nbsp; <?= $id ?></h2>
                <h3><?= $order["date"] ?></h3><br/><br/>

                <h3 class="epic-bebas">Customer</h3>
                <label class="sanssb" style="font-weight: normal; font-size: 18px; margin: 0;"><?= $user["name"] ?></label><br/>
                <label class="sanssb" style="font-weight: normal; font-size: 18px; margin: 0;"><?= $user["contact"] ?></label>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <h3 class="epic-bebas">Payment</h3>
                <h2 class="epic-sanss">₱<span class="epic-sanssb"><?= $order["total_cost"] ?>.00</span></h2>
                <label class="sanssb" style="font-weight: normal; font-size: 18px; margin: 0;"><i><?= $paidString[$order["is_paid"]] ?></i></label><br/><br/>

                <h3 class="epic-bebas">Status</h3>
                <label class="sanssb" style="font-weight: normal; font-size: 18px; margin: 0;"><i><?= $order["status"] ?></i></label>
            </div>
        </div>
        
        <div class="col-md-12" style="margin-top: 40px;">
            <h3 class="epic-bebas">Items</h3>
            <?php
            $result = $mysqli->query("SELECT * FROM order_items WHERE order_id = '$id'");
            while ($row = $result->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-8" style="overflow: hidden; margin-bottom: 10px;">
                    <img src="<?= '../img-uploads/' . $foodarray[$row["food_id"]]["image"] ?>" style="width: 100px; height: 70px; object-fit: cover; float: left" alt="image"/>
                    <div style="margin: 10px 0 0 20px; float: left;">
                        <h3 class="epic-bebas"><?= $foodarray[$row["food_id"]]["name"] ?></h3>
                        <h4 class="epic-sanssb"><span class="epic-sanss">₱</span><?= $row["food_cost"] ?>.00 ea.</h4>
                    </div>
                </div>
                <div class="col-md-4 right" style="margin-top: 10px;">
                    <em>subtotal</em>
                    <h4 class="epic-sanssb"><span class="epic-sanss">₱</span><?= $row["subtotal"] ?>.00</h4>
                    <p class="epic-sanssb"><i>amount: <?= $row["amount"] ?></i></p>
                </div>
            </div>
            <?php
            }
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