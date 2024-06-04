<?php 
include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

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

// GET ORDER
$id = $_POST["id"];
$result = $mysqli->query(sprintf("SELECT * FROM orders WHERE id = '%s'", $mysqli->real_escape_string($id)));
$order = $result->fetch_assoc();

// GET USER AND CASHIER INFO
$result = $mysqli->query(sprintf("SELECT * FROM users WHERE id = '%s'", $mysqli->real_escape_string($order["user_id"])));
$customer = $result->fetch_assoc();
$result = $mysqli->query(sprintf("SELECT * FROM users WHERE id = '%s'", $mysqli->real_escape_string($order["employee_id"])));
$cashier = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tummy Avenue | Order Details</title>
    
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
            <h2 class="heading">Order &nbsp; Details</h2>
            <hr class="heading_space">
        </div>
        <div>
            <div class="col-md-6">
                <h2>Order &nbsp; Ref# &nbsp; <?= $id ?></h2>
                <h3><?= $order["date"] ?></h3>
                <br/><br/>

                <h3 class="epic-bebas">Customer</h3>
                <label class="epic-sanssb epic-txt18"><?= $customer["name"] ?></label><br/>
                <label class="epic-sanssb epic-txt18"><?= $customer["contact"] ?> &nbsp;•&nbsp; <?= $customer["email"] ?></label>
                <?php
                if ($order["remarks"])
                {
                ?>
                <p class="epic-sanss epic-txt16" style="margin: 0;">"<i><?= $order["close_reason"] ?></i>"</p><br/><br/>
                <?php
                }
                ?>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <h3 class="epic-bebas">Payment</h3>
                <h2 class="epic-sanss">₱<span class="epic-sanssb"><?= $order["total_cost"] ?>.00</span></h2>
                <label class="epic-sanssb epic-txt18"><i><?= $paidString[$order["is_paid"]] ?></i></label>
                <br/><br/>

                <h3 class="epic-bebas">Status</h3>
                <label class="epic-sanssb epic-txt18"><i><?= $order["status"] ?></i></label>
                <br/><br/>

                <?php
                if ($order["status"] === "Waiting for payment")
                {
                ?>
                <h3 class="epic-bebas">Pay &nbsp; here</h3>
                <div style="overflow: hidden; padding: 5px;">
                    <div class="work-item" style="width: 100px; height: 100px; box-shadow: 2px 2px 5px; float: right;">
                        <div class="item-container">
                            <img src="../img-uploads/<?= $vars["qrcode"] ?>" style="width: center; height: 100px; object-fit: cover;" alt="QR Code"/>
                            <div class="overlay">
                                <a class="fancybox overlay-inner" href="../img-uploads/<?= $vars["qrcode"] ?>" data-fancybox-group="gallery"><i class=" icon-eye6"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <label class="epic-sanssb epic-txt18"><?= $vars["gcashnum"] ?></label>
                <div style="overflow: hidden; margin-top: 20px;">
                    <form style="text-align: left; float: right; max-width: 360px;" enctype="multipart/form-data" method="post" action="processes/order-process.php">
                        <label>GCash Transaction Receipt</label>
                        <input class="epic-txtbox" name="image" type="file" required>
                        <button name="gcashtrans" class="epic-btnr" style="float: right; margin-top: 10px;">Upload GCash Receipt</button>
                        <input type="hidden" name="id" value="<?= $id ?>">
                    </form>
                </div>
                <?php
                } elseif ($order["gcash_receipt"])
                {
                ?>
                <h3 class="epic-bebas">GCash &nbsp; Receipt</h3>
                <div style="overflow: hidden; padding: 5px;">
                    <div class="work-item" style="width: 100px; height: 100px; box-shadow: 2px 2px 5px; float: right;">
                        <div class="item-container">
                            <img src="../img-uploads/<?= $order["gcash_receipt"] ?>" style="width: center; height: 100px; object-fit: cover;" alt="Receipt"/>
                            <div class="overlay">
                                <a class="fancybox overlay-inner" href="../img-uploads/<?= $order["gcash_receipt"] ?>" data-fancybox-group="gallery"><i class=" icon-eye6"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                } if ($order["close_reason"])
                {
                ?>
                </br>
                <h3 class="epic-bebas">Reason &nbsp; for &nbsp; Closing</h3>
                <p class="epic-sanss epic-txt16" style="margin: 0;">"<i><?= $order["close_reason"] ?></i>"</p><br/><br/>
                <?php
                }
                ?>
            </div>
        </div>
        
        <div class="col-md-12" style="margin-top: 40px;">
            <h3 class="epic-bebas">Items &nbsp; (<?= $order["total_items"] ?>)</h3>
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
    <div style="text-align: center; margin-top: 50px;">
        <label class="epic-sansb epic-txt16">Satisfied with our food and service?</label></br>
        <button onclick="epicOpenModal()" class="epic-btn">Leave us a Feedback!</button>
    </div>
</section>


<!--Page Footer-->
<?php 
include '../global/uf/footer.html';
?>
<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!-- The Modal -->
<div id="epicModal" class="epic-modal">
    <div class="epic-modal-content" style="width: 50%;">
        <div class="epic-modal-header">
            <span class="epic-modal-close">&times;</span>
            <h2>Leave &nbsp; a &nbsp; Feedback</h2>
        </div>
        <div class="epic-modal-body">
            <h3>Your feedback</h3>
            <form enctype="multipart/form-data" action="processes/feedback-process.php" method="post" style="overflow: hidden;">
                <textarea placeholder="Type here..." style="width: 100%; height: 100px; padding: 10px; overflow: auto; resize: none;" name="feedback" required></textarea>
                <input class="epic-btn" style="float: right;" type="submit">
            </form>
        </div>
        <div class="epic-modal-footer"><i>tummy-avenue.com</i></div>
    </div>
</div>

<!--JS-->
<?php 
include '../global/uf/js.html';
?>

</body>
</html>