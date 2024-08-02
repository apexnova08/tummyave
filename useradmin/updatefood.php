<?php 
include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    exit('GET request method required');
}

$id = $_GET["id"];
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
    <div class="container" style="overflow: hidden;">
        <form style="float: right;" enctype="multipart/form-data" action="processes/updatefood-process.php" method="post">
            <?php
            if ($item["featured"])
                echo '<button name="unfeature" class="epic-btnrwhite"><span class="epic-star fa fa-star epic-starc"></span></button>';
            else
                echo '<button name="feature" class="epic-btnrwhite"><span class="epic-star fa fa-star"></span></button>';
            ?>
            
            <input type="hidden" name="id" value="<?= $id ?>"/>
        </form>
        <form style="float: right; margin-left: 10px;" enctype="multipart/form-data" action="processes/updatefood-process.php" method="post">
            <?php
            if ($item["available"])
                echo '<button name="unavail" style="color: green;" class="epic-btnrwhite">Item Available</button>';
            else
                echo '<button name="avail" style="color: red;" class="epic-btnrwhite">Item Unavailable</button>';
            ?>
            <input type="hidden" name="id" value="<?= $id ?>"/>
        </form>
        <form style="float: right;" enctype="multipart/form-data" action="processes/updatefood-process.php" method="post">
            <?php
            if (!$item["archived"])
                echo '<button name="disable" class="epic-btnred">Remove &nbsp; Food &nbsp; from &nbsp; Menu</button>';
            else
                echo '<button name="enable" class="epic-btn">Add &nbsp; Food &nbsp; to &nbsp; Menu</button>';
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
                <div style="margin-bottom: 20px;" <?php if ($item["hasVariations"]) echo "hidden"; ?>>
                    <label class="epic-sanssb epic-txt16">Cost</label>
                    <input placeholder="0" class="epic-txtbox" type="number" id="txtCost" name="cost" value="<?= $item['cost'] ?>" required>
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
            </form></br></br></br></br>

            <!-- ## VARIATIONS -->
            <form id="edVariants" style="overflow: hidden;" enctype="multipart/form-data" action="processes/updatefood-process.php" method="post">
                <a href="javascript:{}" onclick="document.getElementById('edVariants').submit();">
                    <label style="float: right;" class="epic-switch">
                        <input type="checkbox" <?php if ($item["hasVariations"]) echo "checked"; ?>>
                        <span class="epic-slider"></span>
                    </label>
                </a>
                <input type="hidden" name="id" value="<?= $id ?>"/>
                <input type="hidden" name="edvariants" value="<?= $item["hasVariations"] ?>"/>
                <h3 id="FoodVariations" style="float: left;" class="epic-sanssb epic-txt25 epic-upper">Food Variations</h3></br>
            </form>

            <div <?php if (!$item["hasVariations"]) echo "hidden"; ?>>
                <?php
                if ($item["hasVariations"])
                {
                    $result = $mysqli->query("SELECT * FROM food_variations WHERE food_id = $id ORDER BY `disabled`");
                    while ($row = $result->fetch_assoc()) {
                ?>
                <div class="row epic-li">
                    <div class="col-md-9" style="overflow: hidden; margin-bottom: 10px;">
                        <div style="margin-left: 20px; float: left;">
                            <h3 class="epic-bebas"><?= $row["name"] ?></h3>
                            <h4 class="epic-sanssb" style="margin: 0;"><span class="epic-sanss">₱</span><?= getPriceFormat($row["cost"]) ?></h4></br>
                            <label class="epic-sanssb" style="margin: 0;">Item ID: <?= $row["id"] ?> &nbsp; &nbsp; <i style="color: <?= $boolColor[$row["disabled"]] ?>;"><?= $enabledString[$row["disabled"]] ?></i></label>
                        </div>
                        <input type="hidden" value="<?= $row["cost"] ?>">
                    </div>
                    <div class="col-md-3 right" style="margin-top: 10px;">
                        <button id="variantEdit" class="epic-btn" style="float: right;">Edit</button>
                        <input type="hidden" name="id" value="<?= $row['id']; ?>"/>
                    </div>
                </div>
                <?php
                    } if (mysqli_num_rows($result) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
                ?>
                <button style="margin: 10px; width: 100%;" class="epic-btn" onclick="addVariant()">Add</button>
                <?php
                }
                ?>
            </div></br></br></br></br>
        </div>
    </div>
</section>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!-- The Modal -->
<div id="epicModal" class="epic-modal">
    <div class="epic-modal-content" style="width: 50%;">
        <div class="epic-modal-header">
            <span class="epic-modal-close">&times;</span>
            <h2>Food &nbsp; Variation</h2>
        </div>
        <div class="epic-modal-body" style="overflow: hidden;">
            <form enctype="multipart/form-data" action="processes/updatefood-process.php" method="post">
                <div style="overflow: hidden;">
                    <div style="float: left; padding: 5px; width: 50%;">
                        <p class="epic-sanssb epic-txt16">Name</p>
                        <input id="modalName" placeholder="Variation Name" class="epic-txtbox" name="name" required>
                    </div>
                    <div style="float: right; padding: 5px; width: 40%;">
                        <p class="epic-sanssb epic-txt16">Cost</p>
                        <input id="modalCost" placeholder="0" class="epic-txtbox" type="number" id="txtCost" name="cost" required>
                    </div>
                </div>

                <input class="epic-btn" style="float: right; margin-top: 20px;" type="submit" name="variant">
                <input id="modalId" type="hidden" name="variantId" value="<?= $id ?>"/>
                <input type="hidden" name="id" value="<?= $id ?>"/>
            </form>
            <form enctype="multipart/form-data" action="processes/updatefood-process.php" method="post" style="overflow: hidden;">
                <input id="modalBtnE" class="epic-btn" name="eVariant" style="float: right; margin: 20px 20px 0 0" type="submit" value="Enable">
                <input id="modalBtnD" class="epic-btnred" name="dVariant" style="float: right; margin: 20px 20px 0 0" type="submit" value="Disable">
                <input id="modalIdEd" type="hidden" name="variantId"/>
                <input type="hidden" name="id" value="<?= $id ?>"/>
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

<script>
let btnE = document.getElementById("modalBtnE");
let btnD = document.getElementById("modalBtnD");
let idString = document.getElementById("modalId");
let idStringED = document.getElementById("modalIdEd");
let txtName = document.getElementById("modalName");
let txtCost = document.getElementById("modalCost");

function addVariant()
{
    txtName.value = "";
    txtCost.value = "";

    idString.value = null;
    idStringED.value = null;
    btnE.hidden = true;
    btnD.hidden = true;

    epicOpenModal();
}

const btnArr = document.querySelectorAll("#variantEdit");
btnArr.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        valsSec = e.target.parentElement.parentElement.children[0].children[0];
        txtName.value = valsSec.children[0].innerHTML;
        txtCost.value = valsSec.nextElementSibling.value;
        
        idString.value = e.target.nextElementSibling.value;
        idStringED.value = e.target.nextElementSibling.value;
        btnE.hidden = true;
        btnD.hidden = true;

        if (valsSec.children[3].innerHTML.includes("Disabled")) btnE.hidden = false;
        else if (valsSec.children[3].innerHTML.includes("Enabled")) btnD.hidden = false;
        
        epicOpenModal();
    })
})
</script>

</body>
</html>