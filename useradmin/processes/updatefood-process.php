<?php
require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$id = $_POST["id"];

if (isset($_POST["info"]))
{
    $name = $_POST["name"];
    $ctg = $_POST["ctg"];
    $cost = $_POST["cost"];
    $desc = $_POST["desc"];
    
    $sql = "UPDATE foods SET name = ?, cost = ?, description = ?, category = ? WHERE id = '$id'";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "ssss", $name, $cost, $desc, $ctg);
    if ($stmt->execute())
    {
        header("location: ../../useradmin/");
    }
    else die ("error");
}
elseif (isset($_POST["img"]))
{
    $image = uploadImage(generateID(getCurrentDateTime()));
    
    $sql = "UPDATE foods SET image = ? WHERE id = '$id'";
    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "s", $image);
    if ($stmt->execute())
    {
        header("location: ../../useradmin/");
    }
    else die ("error");
}
elseif (isset($_POST["disable"]))
{
    $sql = "UPDATE foods SET archived = true WHERE id = '$id'";
    if ($mysqli->query($sql)) header("location: ../../useradmin/");
    else die ("error");
}
elseif (isset($_POST["enable"]))
{
    $sql = "UPDATE foods SET archived = false WHERE id = '$id'";
    if ($mysqli->query($sql)) header("location: ../../useradmin/");
    else die ("error");
}
elseif (isset($_POST["unavail"]))
{
    $sql = "UPDATE foods SET available = false WHERE id = '$id'";
    if ($mysqli->query($sql)) echo '<script type="text/javascript">', 'history.go(-1);', '</script>';
    else die ("error");
}
elseif (isset($_POST["avail"]))
{
    $sql = "UPDATE foods SET available = true WHERE id = '$id'";
    if ($mysqli->query($sql)) echo '<script type="text/javascript">', 'history.go(-1);', '</script>';
    else die ("error");
}
elseif (isset($_POST["unfeature"]))
{
    $sql = "UPDATE foods SET featured = false WHERE id = '$id'";
    if ($mysqli->query($sql)) echo '<script type="text/javascript">', 'history.go(-1);', '</script>';
    else die ("error");
}
elseif (isset($_POST["feature"]))
{
    $sql = "UPDATE foods SET featured = true WHERE id = '$id'";
    if ($mysqli->query($sql)) echo '<script type="text/javascript">', 'history.go(-1);', '</script>';
    else die ("error");
}

// # VARIANTS
elseif (isset($_POST["edvariants"]))
{
    $newval = $boolstring[!$_POST["edvariants"]];
    $sql = "UPDATE foods SET hasVariations = $newval WHERE id = '$id'";
    if ($mysqli->query($sql)) echo '<script type="text/javascript">', 'history.go(-1);', '</script>';
    else die ("error");
}
elseif (isset($_POST["variant"]))
{
    $name = $_POST["name"];
    $cost = $_POST["cost"];
    
    if ($_POST["variantId"])
    {
        $variantid = $_POST["variantId"];
        $sql = "UPDATE food_variations SET food_id = ?, name = ?, cost = ? WHERE id = '$variantid'";
    }
    else $sql = "INSERT INTO food_variations (food_id, name, cost, disabled) VALUES (?, ?, ?, true)";

    $stmt = $mysqli->stmt_init();
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->errno);
    }
    mysqli_stmt_bind_param($stmt, "sss", $id, $name, $cost);
    if ($stmt->execute()) echo '<script type="text/javascript">', 'history.go(-1);', '</script>';
    else die("error");
}
elseif (isset($_POST["eVariant"]))
{
    $variantid = $_POST["variantId"];
    $sql = "UPDATE food_variations SET `disabled` = false WHERE id = '$variantid'";
    if ($mysqli->query($sql)) echo '<script type="text/javascript">', 'history.go(-1);', '</script>';
    else die ("error");
}
elseif (isset($_POST["dVariant"]))
{
    $variantid = $_POST["variantId"];
    $sql = "UPDATE food_variations SET `disabled` = true WHERE id = '$variantid'";
    if ($mysqli->query($sql)) echo '<script type="text/javascript">', 'history.go(-1);', '</script>';
    else die ("error");
}
?>