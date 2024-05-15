<?php

session_start();
$userId = $_SESSION["user_id"];
session_abort();

include 'processes/redirect.php';
require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

$foodarray = array();
$foodresult = $mysqli->query("SELECT * FROM foods");
while ($foodrow = $foodresult->fetch_assoc())
{
    $foodarray[$foodrow["id"]] = $foodrow;
}

$foodtotalcost = 0;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $foodid = $_POST["id"];
    $mysqli->query("DELETE FROM carts WHERE id = $foodid");
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | Menu</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">

</head>

<body>


<!--#####-->
<a href="../food.php"><button>Get more food</button></a>
<h1>Your Cart</h1>

<div>
    <table>
        <tr style="background-color: darkorange; color: black;">
            <td>Image</td>
            <td>Name</td>
            <td>Amount</td>
            <td>Subtotal</td>
            <td></td>
        </tr>

        <?php
        $result = $mysqli->query("SELECT * FROM carts WHERE user_id = '$userId'");
        while ($row = $result->fetch_assoc()) {

            $foodtotalcost = $foodtotalcost + ($foodarray[$row["food_id"]]["cost"] * $row["amount"]);
        ?>
        <tr>
            <td><img src="<?= '../img-uploads/' . $foodarray[$row["food_id"]]["image"] ?>" style="width: 100px; height: 50px; object-fit: cover;" alt="image"/></td>
            <td><?= $foodarray[$row["food_id"]]["name"] ?></td>
            <td><?= $row["amount"] ?></td>
            <td>₱<?= $foodarray[$row["food_id"]]["cost"] * $row["amount"] ?></td>
            <td><form method="post">
                <input type="submit" name="action" value="remove" style="background-color: red;"/>
                <input type="hidden" name="id" value="<?= $row['id']; ?>"/>
            </form></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php
    if (mysqli_num_rows($result) === 0)
    {
        echo "<h2 style='width: 100%; text-align: center;'>(Empty)</h2>";
    } else {
    ?>
    <h2>₱<?= $foodtotalcost ?> Total</h2>
    <a href="checkout.php"><button>Checkout</button></a>
    <?php } ?>
</div>



</body>
</html>
