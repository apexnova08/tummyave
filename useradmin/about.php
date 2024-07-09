<?php
include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
$mysqli = require __DIR__ . "/../database.php";

$countraw = $mysqli->query("SELECT COUNT(*) AS total FROM about");
$count = $countraw->fetch_assoc()["total"];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | About Section</title>
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    ?>
</head>

<body>

<!-- ##### -->
<section id="topBtns" style="padding-top: 30px;">
    <div class="container" style=" overflow: hidden;">
        <a href="createabout.php"><button style="float: right;" class="epic-btn">Add &nbsp; +</button></a>
    </div>
</section>

<section id="about" class="padding bg_white">
    <div class="container">
        <div style="text-align: right;"><a href="tummy.php" class="epic-a"><< Back</a></div>
        <div>
            <h2 class="heading">About &nbsp; Us &nbsp; Page</h2>
            <hr class="heading_space">
        </div>
        <div>
            <?php
            $result = $mysqli->query("SELECT * FROM about ORDER BY `order_num` ASC");
            while ($row = $result->fetch_assoc()) {
            ?>
            <div class="epic-li">
                <div style="overflow: hidden; margin-bottom: 30px;">
                    <label class="epic-sanssb" style="float: left; margin: 10px;">Order:</label>
                    <form style="float: left;" action="processes/updateabout-process.php" method="post">
                        <button name="down" class="epic-btnr" style="padding: 10px 20px;" <?php if ($row["order_num"] === "1") echo "disabled"; ?>><i class="fa fa-minus"></i></button>
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                    </form>
                    <label class="epic-sansb" style="float: left; margin: 10px;"><?= $row["order_num"] ?></label>
                    <form style="float: left;" action="processes/updateabout-process.php" method="post">
                        <button name="up" class="epic-btnr" style="padding: 10px 20px;" <?php if ($row["order_num"] === $count) echo "disabled"; ?>><i class="fa fa-plus"></i></button>
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                    </form>
                    <form style="float: right;" action="processes/updateabout-process.php" method="post">
                        <button name="delete" class="epic-btnrred" style="padding: 10px 20px;">Delete</button>
                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                    </form>
                </div>
                <div style="overflow: hidden;">
                    <div class="col-md-3" style="overflow: hidden; margin-bottom: 10px;">
                        <img src="../img-uploads/<?= $row["image"] ?>" style="width: 100%; height: 200px; object-fit: cover; float: left;" alt="image"/>
                        
                    </div>
                    <div class="col-md-9" style="overflow: hidden;">
                        <div style="margin: 10px 0; float: left;">
                            <h3><?= $row["title"] ?></h3>
                            <label class="epic-sanss epic-txt16"><?= $row["text"] ?></label>
                        </div>
                    </div>
                </div>
                
            </div>
            <?php
            } if (mysqli_num_rows($result) === 0) echo "<p class='epic-sansr' style='text-align: center; color: #777'>( Empty )</p>";
            ?>
        </div>
    </div>
</section>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include '../global/uf/js.html';
include '../global/uf/adminfooter.php';
?>

<script type="text/javascript">

var tempString = "";
const editBtns = document.querySelectorAll("#btnEdit");
editBtns.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        const siblings = e.target.parentElement.parentElement.children;
        e.target.hidden = true;
        siblings[1].disabled = false;
        siblings[2].hidden = false;

        for (let i = 0; i < editBtns.length; i++) editBtns[i].disabled = true;
        document.getElementById("btnEditQR").disabled = true;
        tempString = siblings[1].value;
    })
})
const editCancelBtns = document.querySelectorAll("#btnCancelEdit");
editCancelBtns.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        const siblings = e.target.parentElement.parentElement.children;
        siblings[0].children[1].hidden = false;
        siblings[1].disabled = true;
        siblings[2].hidden = true;

        for (let i = 0; i < editBtns.length; i++) editBtns[i].disabled = false;
        document.getElementById("btnEditQR").disabled = false;
        siblings[1].value = tempString;
    })
})
const txtVal = document.querySelectorAll("#txtVal");
txtVal.forEach(txt=>{
    txt.addEventListener('input', (e) => {
        if (e.target.name === "contact")
        {
            var contact = e.target.value;
            var c = contact[contact.length - 1]
            if (!(c >= '0' && c <= '9')) e.target.value = contact.substring(0, contact.length - 1);
        }

        var btn = e.target.parentElement.children[2];
        if (/\S/.test(e.target.value)) btn.disabled = false;
        else btn.disabled = true;
    })
})
</script>

</body>
</html>
