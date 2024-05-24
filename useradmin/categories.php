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
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    include 'nav.php';
    ?>

</head>

<body>

<!--#####-->
<section id="topBtns" style="padding-top: 30px;">
    <div class="container" style=" overflow: hidden;">
        <button onclick="addCtg()" style="float: right;" class="epic-btn">Add &nbsp; Category &nbsp; +</button>
    </div>
</section>

<section id="section_name" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Categories</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result = $mysqli->query("SELECT * FROM categories ORDER BY `hidden`");
            while ($row = $result->fetch_assoc()) {
            ?>
            <div class="row epic-li">
                <div class="col-md-8" style="overflow: hidden; margin-bottom: 10px;">
                    <h3 class="epic-bebas"><?= $row["name"] ?></h3>
                    <label class="epic-sanssb">Item ID: <?= $row["id"] ?> &nbsp; &nbsp; <i style="color: <?= $boolColor[$row["hidden"]] ?>;"><?= $enabledString[$row["hidden"]] ?></i></label>
                </div>
                <div class="col-md-4 right">
                    <form enctype="multipart/form-data" method="post">
                        <button id="btnEdit" class="epic-btn" type="button">Edit</button>
                        <input type="hidden" name="id" value="<?= $row['id']; ?>"/>
                    </form>
                </div>
            </div>
            <?php
            } if (mysqli_num_rows($result) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
            ?>
        </div>
    </div>
</section>

<!-- The Modal -->
<div id="epicModal" class="epic-modal">
    <div class="epic-modal-content" style="width: 50%;">
        <div class="epic-modal-header">
            <span class="epic-modal-close">&times;</span>
            <h2 id="modalHeaderString">Header</h2>
        </div>
        <div class="epic-modal-body" style="overflow: hidden;">
            <p class="epic-sanssb epic-txt16">Category Name</p>
            <form id="modalForm" enctype="multipart/form-data" method="post">
                <input id="modalVal" placeholder="Category Name" class="epic-txtbox" name="name" required>
                <input class="epic-btn" style="float: right; margin-top: 20px;" type="submit">
                <input id="modalId" type="hidden" name="id"/>
            </form>
            <form enctype="multipart/form-data" action="processes/updatectg-process.php" method="post" style="overflow: hidden;">
                <input id="modalBtnE" class="epic-btn" name="enable" style="float: right; margin: 20px 20px 0 0" type="submit" value="Enable">
                <input id="modalBtnD" class="epic-btnred" name="disable" style="float: right; margin: 20px 20px 0 0" type="submit" value="Disable">
                <input id="modalIdEd" type="hidden" name="id"/>
            </form>
        </div>
        <div class="epic-modal-footer"><i>tummy-avenue.com</i></div>
    </div>
</div>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include '../global/uf/js.html';
?>

<script>
let txtHeader = document.getElementById("modalHeaderString");
let form = document.getElementById("modalForm");
let btnE = document.getElementById("modalBtnE");
let btnD = document.getElementById("modalBtnD");
let idString = document.getElementById("modalId");
let idStringED = document.getElementById("modalIdEd");
let valText = document.getElementById("modalVal");

function addCtg()
{
    txtHeader.innerHTML = "Add &nbsp; Category"
    valText.value = "";
    form.action = "processes/createctg-process.php";
    btnE.hidden = true;
    btnD.hidden = true;

    epicOpenModal();
}

const btnArr = document.querySelectorAll("#btnEdit");
btnArr.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        txtHeader.innerHTML = "Edit &nbsp; Category"
        valsSec = e.target.parentElement.parentElement.parentElement.children[0];
        valText.value = valsSec.children[0].innerHTML;
        
        idString.value = e.target.nextElementSibling.value;
        idStringED.value = e.target.nextElementSibling.value;
        form.action = "processes/updatectg-process.php";
        
        btnE.hidden = true;
        btnD.hidden = true;
        if (valsSec.children[1].innerHTML.includes("Disabled")) btnE.hidden = false;
        else if (valsSec.children[1].innerHTML.includes("Enabled")) btnD.hidden = false;
        
        epicOpenModal();
    })
})
</script>

</body>
</html>
