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
    <title>Tummy Avenue | Login</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

</head>

<body>


<!--#####-->
<h1>Order details</h1>

<h2>Info</h2>
<label>Order ID: <?= $id ?></label><br/>
<label><?= $order["date"] ?></label><br/><br/>

<label><b>Customer</b></label><br/>
<label><?= $user["name"] ?></label><br/>
<label><?= $user["email"] ?></label><br/>
<label><?= $user["contact"] ?></label><br/><br/>

<label><b>Payment</b></label><br/>
<label>₱<?= $order["total_cost"] ?></label>
<label><i><?php if ($order["is_paid"]) { echo "Paid"; } else { echo "Unpaid"; } ?></i></label><br/><br/>

<label><b>Status</b></label><br/>
<label><?= $order["status"] ?></label><br/><br/><br/>

<?php
if (!$order["is_closed"])
{
?>
<form enctype="multipart/form-data" method="post">
    <input type="submit" name="update" value="Mark as Paid"/>
    <input type="hidden" name="id" value="<?= $id ?>"/>
</form>
<?php
}
?>
<br/><br/>

<h2>Items</h2>
<div>
    <table>
        <tr style="background-color: darkorange; color: black;">
            <td>Image</td>
            <td>Name</td>
            <td>Amount</td>
            <td>Subtotal</td>
        </tr>

        <?php
        $result = $mysqli->query("SELECT * FROM order_items WHERE order_id = '$id'");
        while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><img src="<?= '../img-uploads/' . $foodarray[$row["food_id"]]["image"] ?>" style="width: 100px; height: 50px; object-fit: cover;" alt="image"/></td>
            <td><?= $foodarray[$row["food_id"]]["name"] ?></td>
            <td><?= $row["amount"] ?></td>
            <td>₱<?= $foodarray[$row["food_id"]]["cost"] * $row["amount"] ?></td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>

</body>
</html>