<?php 
include 'processes/redirect.php';

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
$result = $mysqli->query("SELECT * FROM orders WHERE id = '$id'");
$order = $result->fetch_assoc();

// GET USER AND CASHIER INFO
$result = $mysqli->query(sprintf("SELECT * FROM users WHERE id = '%s'", $mysqli->real_escape_string($order["user_id"])));
$customer = $result->fetch_assoc();
$result = $mysqli->query(sprintf("SELECT * FROM users WHERE id = '%s'", $mysqli->real_escape_string($order["employee_id"])));
$cashier = $result->fetch_assoc();

// CHECK STATUS
$sql = "";
$btnstring = "Mark as paid";
if ($order["status"] === "Preparing") $btnstring = "Mark as ready";
elseif ($order["status"] === "Ready for pickup") $btnstring = "Mark as picked up";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cashier Panel | Order Details</title>
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    ?>

</head>

<body>

<!--#####-->
<section id="topBtns" style="padding-top: 30px;">
    <div class="container" style=" overflow: hidden;">
        <?php
        if (!$order["is_closed"])
        {
        ?>
        <button onclick="epicOpenModal()" style="float: right;" class="epic-btnred">Close &nbsp; Order</button>
        <?php
        } else {
        ?>
        <form action="processes/invoice.php" method="post" target="_blank">
            <input type="hidden" name="id" value="<?= $order["id"] ?>">
            <button style="float: right;" class="epic-btnr">Generate Invoice</button>
        </form>
        <?php
        }
        ?>
    </div>
</section>

<section id="order" class="padding bg_white">
    <div class="container">
    <div style="text-align: right;"><a href="../usercashier/" class="epic-a"><< Back</a></div>
        <div>
            <h2 class="heading">Order &nbsp; Details</h2>
            <hr class="heading_space">
        </div>
        <div>
            <div class="col-md-6">
                <h2>Order &nbsp; Ref# &nbsp; <?= $id ?></h2>
                <h3><?= $order["date"] ?></h3>
                <?php
                if ($order["employee_id"]) { ?> <label class="epic-txt18" style="margin: 0;"><em class="epic-sanss">Order accepted by:</em> <span class="epic-sanssb"><?= $cashier["name"] ?></span></label> <?php }
                ?>
                <br/><br/>

                <h3 class="epic-bebas">Customer</h3>
                <label class="epic-sanssb epic-txt18" style="margin: 0;"><?= $customer["name"] ?></label><br/>
                <label class="epic-sanssb epic-txt18" style="margin: 0;"><?= $customer["contact"] ?> &nbsp;•&nbsp; <?= $customer["email"] ?></label>
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
                <h2 class="epic-sanss">₱<span class="epic-sanssb"><?= getPriceFormat($order["total_cost"]) ?></span></h2>
                <label class="epic-sanssb epic-txt18" style="margin: 0;"><i><?= $paidString[$order["is_paid"]] ?></i></label><br/><br/>

                <h3 class="epic-bebas">Status</h3>
                <label class="epic-sanssb epic-txt18" style="margin: 0;"><i><?= $order["status"] ?></i></label><br/><br/>

                <?php
                if ($order["gcash_receipt"])
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
                </div></br>
                <?php
                }
                ?>
                <?php
                if (!$order["is_closed"])
                {
                ?>
                <form enctype="multipart/form-data" action="processes/updateorder-process.php" method="post">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input class="epic-btnr" type="submit" name="update" value="<?= $btnstring ?>">
                </form>
                <?php
                } elseif ($order["close_reason"])
                {
                ?>
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
                        <h4 class="epic-sanssb"><span class="epic-sanss">₱</span><?= getPriceFormat($row["food_cost"]) ?> ea.</h4>
                    </div>
                </div>
                <div class="col-md-4 right" style="margin-top: 10px;">
                    <em>subtotal</em>
                    <h4 class="epic-sanssb"><span class="epic-sanss">₱</span><?= getPriceFormat($row["subtotal"]) ?></h4>
                    <p class="epic-sanssb"><i>amount: <?= $row["amount"] ?></i></p>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!-- The Modal -->
<div id="epicModal" class="epic-modal">
    <div class="epic-modal-content" style="width: 50%;">
        <div class="epic-modal-header">
            <span class="epic-modal-close">&times;</span>
            <h2>Close &nbsp; Order</h2>
        </div>
        <div class="epic-modal-body">
            <em class="epic-sanssb epic-txt16">State your reason here..</em></br>
            <form enctype="multipart/form-data" action="processes/updateorder-process.php" method="post" style="overflow: hidden;">
                <textarea placeholder="Type here..." style="width: 100%; height: 100px; padding: 10px; overflow: auto; resize: none;" name="reason" required></textarea>
                <input class="epic-btnred" style="float: right;" name="close" type="submit" value="Close &nbsp; Order">
                <input type="hidden" name="id" value="<?= $id ?>">
            </form>
        </div>
        <div class="epic-modal-footer"><i>tummy-avenue.com</i></div>
    </div>
</div>

<!--JS-->
<?php 
include '../global/uf/js.html';
include '../global/uf/adminfooter.php';
?>

</body>
</html>