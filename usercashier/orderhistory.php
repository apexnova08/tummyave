<?php

include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | Menu</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    
    <!--NAV-->
    <?php 
    include 'nav.php';
    ?>

</head>

<body>


<!--#####-->
<div>
    <div style="position: relative; display: inline-block; width: 100%">
        <h1 style="float: left; margin: 0;">History</h1>
        <a href="../usercashier/" style="float: right;"><button>Back</button></a>
    </div>
    <table>
        <tr style="background-color: darkorange; color: black;">
            <td>Order</td>
            <td>Qty.</td>
            <td>Total Cost</td>
            <td>Payment Status</td>
            <td>Order Status</td>
            <td></td>
        </tr>

        <?php
        $result = $mysqli->query("SELECT * FROM orders WHERE is_closed = true");
        while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><?= $row["total_items"] ?> items</td>
            <td>₱<?= $row["total_cost"] ?></td>
            <?php
            if ($row["is_paid"]) {
            ?>
            <td>Paid</td>
            <?php
            } else {
            ?>
            <td>Unpaid</td>
            <?php
            }
            ?>
            <td><?= $row["status"] ?></td>
            <td><form method="post" action="orderpage.php">
                <input type="submit" name="action" value="details"/>
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
    }
    ?>
</div>

</body>
</html>
