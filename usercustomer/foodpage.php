<?php 
if ($_SERVER["REQUEST_METHOD"] !== "POST")
{
    exit('POST request method required');
}
$mysqli = require __DIR__ . "/../database.php";

if ($foodId = $_POST["foodId"])
{
    $sql = sprintf("SELECT * FROM foods WHERE id = '%s'", $mysqli->real_escape_string($foodId));
    $result = $mysqli->query($sql);
    $food = $result->fetch_assoc();
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
<h1><?= $food["name"] ?></h1>
<form action="processes/addtocart-process.php" method="post">
    <input type="number" name="amount"/>
    <input type="submit" value="Add to cart"/>
    <input type="hidden" name="foodId" value="<?= $foodId ?>"/>
</form>

</body>
</html>