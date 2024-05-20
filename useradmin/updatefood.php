<?php 
include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$id = $_POST["id"];
$sql = sprintf("SELECT * FROM foods WHERE id = '%s'", $mysqli->real_escape_string($id));
$result = $mysqli->query($sql);
$item = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | Menu</title>
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    ?>

</head>

<body>

<!--#####-->
<section id="topBtns" style="padding-top: 30px;">
    <div class="container">
        <form style="overflow: hidden;" enctype="multipart/form-data" action="processes/updatefood-process.php" method="post">
            <?php
            if (!$item["archived"])
                echo '<button style="float: right;" name="disable" class="epic-btnred">Remove &nbsp; Food &nbsp; from &nbsp; Menu</button>';
            else
                echo '<button style="float: right;" name="enable" class="epic-btn">Add &nbsp; Food &nbsp; to &nbsp; Menu</button>';
            ?>
            <input type="hidden" name="id" value="<?= $id ?>"/>
        </form>
    </div>
</section>

<section class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="../useradmin/" class="epic-a"><< Back</a></div>
        <div>
            <h2 class="heading">Update &nbsp; Food &nbsp; Info</h2>
            <hr class="heading_space">
        </div>
        <div class="col-md-6">
            <form style="overflow: hidden;" enctype="multipart/form-data" action="processes/updatefood-process.php" method="post">
                <h3 class="epic-sanssb epic-txt25 epic-upper">Food Information</h3></br>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Name</label>
                    <input placeholder="Food Name" class="epic-txtbox" type="text" name="name" value="<?= $item['name'] ?>" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Category</label></br>
                    <select class="epic-txtbox" style="text-align: center;" name="ctg" required>
                        <option value="0" <?php if ($item["category"] === '0') echo "selected"; ?>>Uncategorized</option>
                        <?php
                        $result = $mysqli->query("SELECT * FROM categories WHERE NOT hidden");
                        while ($row = $result->fetch_assoc()) { ?> <option value="<?= $row["id"] ?>" <?php if ($item["category"] === $row["id"]) echo "selected"; ?>><?= $row["name"] ?></option> <?php }
                        ?>
                    </select>
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Cost</label>
                    <input placeholder="0" class="epic-txtbox" type="number" name="cost" value="<?= $item['cost'] ?>" required>
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Description</label>
                    <textarea placeholder="Type here..." class="epic-txtbox" name="desc" style="resize: none; height: 150px;" required><?= $item['description'] ?></textarea>
                </div>
                <input style="float: right;" class="epic-btn" type="submit" name="info" value="Update &nbsp; Food &nbsp; Info">
                <input type="hidden" name="id" value="<?= $id ?>"/>
            </form></br></br></br></br>

            <form style="overflow: hidden;" enctype="multipart/form-data" action="processes/updatefood-process.php" method="post" >
                <h3 class="epic-sanssb epic-txt25 epic-upper">Food Image</h3></br>
                <div style="margin-bottom: 20px;">
                    <label class="epic-sanssb epic-txt16">Image</label>
                    <input class="epic-txtbox" type="file" name="image" required>
                </div>
                <input style="float: right;" class="epic-btn" type="submit" name="img" value="Update &nbsp; Food &nbsp; Image">
                <input type="hidden" name="id" value="<?= $id ?>"/>
            </form>
        </div>
    </div>
</section>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include '../global/uf/js.html';
?>

</body>
</html>