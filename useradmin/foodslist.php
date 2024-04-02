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

</head>

<body>


<!--#####-->
<h1>Menu</h1>

<div>
    <table>
        <tr style="background-color: darkorange; color: black;">
            <td>ID</td>
            <td>Image</td>
            <td>Name</td>
            <td>Price</td>
            <td></td>
        </tr>

        <?php
        $result = $mysqli->query("SELECT * FROM foods");
        while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><img src="<?= '../img-uploads/' . $row['image'] ?>" style="width: 100px; height: 50px; object-fit: cover;" alt="image"/></td>
            <td><?= $row["name"] ?></td>
            <td>₱<?= $row["cost"] ?></td>
            <td><form method="post" action="updatefood.php">
                <input type="submit" name="action" value="edit"/>
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>"/>
            </form></td>
        </tr>
        <?php
        }
        ?>
    </table>
</div>

</body>
</html>
