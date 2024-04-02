<?php 
include 'processes/redirect.php';
?>

<?php
require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}
if (isset($_POST["id"]))
{
    $id = $_POST["id"];
    $sql = sprintf("SELECT * FROM foods WHERE id = '%s'", $mysqli->real_escape_string($id));
    $result = $mysqli->query($sql);
    $item = $result->fetch_assoc();
}
if (isset($_POST["name"]))
{
    $id = $_POST["id2"];
    $name = $_POST["name"];
    $cost = $_POST["cost"];
    $desc = $_POST["desc"];
    
    $sql = "UPDATE foods SET name = ?, cost = ?, description = ?, category = 'N/A' WHERE id = '$id'";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "sss", $name, $cost, $desc);
    if ($stmt->execute())
    {
        header("javascript:history.go(-1)");
    }
    else
    {
        echo "sex";
        die ("sex");
    }
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
<h1>Update Food</h1>

<form method="post">
    <h2>Info</h2>
    <div>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?= $item['name'] ?>">
    </div>
    <div>
        <label for="cost">Cost</label>
        <input type="text" id="cost" name="cost" value="<?= $item['cost'] ?>">
    </div>
    <div>
        <label for="desc">Description</label>
        <input type="text" id="desc" name="desc" value="<?= $item['description'] ?>">
    </div>
    <br/>
    <button>Update</button>
    <input type="hidden" name="id2" value="<?= $id ?>"/>
</form>
<br/><br/>

<form enctype="multipart/form-data" method="post">
    <h2>Image</h2>
    <img src="<?= '../img-uploads/' . $item['image'] ?>" style="width: 500px; height: 255px; object-fit: cover;" alt="image"/>
    <div>
        <label for="image">Image</label>
        <input type="file" id="image" name="image">
    </div>
    <br/>
    <button>Update</button>
    <input type="hidden" name="id2" value="<?= $id ?>"/>
</form>
<br/><br/>

<form method="post">
    <button style="background-color: red;">Disable</button>
</form>

<div style="background-color:black; width:50px; height:50px; position:absolute; margin:auto; top: 0"></div>

</body>
</html>