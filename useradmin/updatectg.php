<?php 
include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$id = $_POST["id"];
$result = $mysqli->query("SELECT * FROM categories WHERE id = '$id'");
$ctg = $result->fetch_assoc();

$val = "empty string";
$sql = "";
if (isset($_POST["name"]))
{
    $val = $_POST["name"];
    $sql = "UPDATE categories SET name = ? WHERE id = '$id'";
}
elseif (isset($_POST["edstatus"]))
{
    if ($ctg["hidden"]) $val = "0";
    else $val = "1";
    $sql = "UPDATE categories SET hidden = ? WHERE id = '$id'";
}
if ($sql != "")
{
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "s", $val);
    if ($stmt->execute())
    {
        header("location: categories.php");
    }
    else die("error");
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
<h1>Update Category</h1>

<form method="post">
    <h2>Info</h2>
    <div>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?= $ctg['name'] ?>">
    </div>
    <button>Update</button>
    <input type="hidden" name="id" value="<?= $id ?>"/>
</form></br>

<form method="post">
    <input style="background-color: red;" type="submit" name="edstatus" value="Disable"/>
    <input type="hidden" name="id" value="<?= $id ?>"/>
</form> 

</body>
</html>