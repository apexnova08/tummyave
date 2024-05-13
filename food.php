<?php
$mysqli = require __DIR__ . "/database.php";
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Tummy Avenue</title>

<!--CSS-->
<?php 
include 'global/customercss.html';
?>
</head>

<body>
<?php 
include 'global/loader.html';
include 'global/customerheader.php';
?>
<!--Page header & Title-->
<section id="page_header">
    <div class="page_title">
        <div class="container">
            <div class="col-md-12">
                <h2 class="title">Our &nbsp; Food</h2>
                <p>Check out our menu and some of our special, featured best sellers!</p>
            </div>
        </div>
    </div>  
</section>

<!-- ## CONTENT HERE ## -->
<section id="news" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Featured &nbsp; Food</h2>
            <hr class="heading_space">
        </div>
            <div>
                <div class="col-md-12">
                    <div class="cheffs_wrap_slider">
                        <div id="news-slider" class="owl-carousel">
                            <div class="item">
                                <div class="news_content">
                                <img src="images/NA.jpg" alt="Docotor">
                                <div class="date_comment">
                                    <span>22<small>apr</small></span>
                                    <a href="#."><i class="icon-comment"></i> 5</a>
                                </div>
                                <div class="comment_text">
                                    <h3><a href="#.">Food Name</a></h3>
                                    <p>Description</p>
                                </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="news_content">
                                <img src="images/NA.jpg" alt="Docotor">
                                <div class="date_comment">
                                    <span>22<small>apr</small></span>
                                    <a href="#."><i class="icon-comment"></i> 5</a>
                                </div>
                                <div class="comment_text">
                                    <h3><a href="#.">Food Name</a></h3>
                                    <p>Description</p>
                                </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="news_content">
                                <img src="images/NA.jpg" alt="Docotor">
                                <div class="date_comment">
                                    <span>22<small>apr</small></span>
                                    <a href="#."><i class="icon-comment"></i> 5</a>
                                </div>
                                <div class="comment_text">
                                    <h3><a href="#.">Food Name</a></h3>
                                    <p>Description</p>
                                </div>
                                </div>
                            </div>
                            
                            <div class="item">
                                <div class="news_content">
                                <img src="images/NA.jpg" alt="Docotor">
                                <div class="date_comment">
                                    <span>22<small>apr</small></span>
                                    <a href="#."><i class="icon-comment"></i> 5</a>
                                </div>
                                <div class="comment_text">
                                    <h3><a href="#.">Food Name</a></h3>
                                    <p>Description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="food" class="padding bg_grey">
    <div class="container">
        <div>
            <h2 class="heading">Our &nbsp; Menu</h2>
            <hr class="heading_space">
        </div>
        <div>
            <div class="grid_layout">
                <div class="zerogrid">
                    <div class="wrap-container">
                        <div>

                        <?php
                        $result = $mysqli->query("SELECT * FROM foods");
                        while ($rowfoods = $result->fetch_assoc()) {
                        ?>

                        <div class="col-1-3">
                            <div class="wrap-col first">
                                <div class="item-container">
                                    <img src="<?= 'img-uploads/' . $rowfoods['image'] ?>" style="width: center; height: 255px; object-fit: cover;" alt="<?= $rowfoods['name']; ?>"/>
                                    <div class="overlay food-item" style="cursor: pointer;">
                                        <p class="overlay-inner"><?= $rowfoods['name']; ?></p>
                                        <input type="hidden" value="<?= $rowfoods['id']; ?>"/>
                                        <input type="hidden" value="<?= $rowfoods['cost']; ?>"/>
                                        <input type="hidden" value="<?= $rowfoods['image']; ?>"/>
                                        <input type="hidden" value="<?= $rowfoods['description']; ?>"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        }
                        ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="section_name" class="padding bg_grey">
    <div class="container">
        <div>
            <h2 id="test" class="heading">Title &nbsp; Grey &nbsp; Section</h2>
            <hr class="heading_space">
        </div>
    </div>
</section>

<!--Page Footer-->
<?php 
include 'global/customerfooter.html';
?>
<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!-- The Modal -->
<div id="epicModal" class="epic-modal">
    <div class="epic-modal-content">
        <div class="epic-modal-header">
            <span class="epic-modal-close">&times;</span>
            <h2>Add &nbsp; to &nbsp; Cart</h2>
        </div>
        <div class="epic-modal-body row">
            <img id="modalFoodImage" class="col-md-4" src="img-uploads/placeholder.png" style="width: 255px; height: 255px; object-fit: cover;" alt="food image"/>
            <div class="col-md-8 container">
                <h2 id="modalFoodName">Food Name</h2>
                <p id="modalFoodDesc" style="margin: 20px 0; height: 150px; overflow: auto;">Description</p>
                <form action="usercustomer/processes/addtocart-process.php" method="post">
                    <input id="modalFoodId" type="hidden" name="foodId" value="0"/>
                    <button class="epic-btn-radius" onclick="amountSubtract()" type="button"><i class="fa fa-minus"></i></button>
                    <input id="modalFoodAmount" class="epic-txtbox" style="width: 100px; text-align: center;" type="number" name="amount" value="1">
                    <button class="epic-btn-radius" onclick="amountAdd()" type="button"><i class="fa fa-plus"></i></button>
                    <input class="epic-btn" style="margin-left: 20px;" type="submit">
                    <label id="modalFoodCost" class="epic-sansr" style="font-size:20px; margin-left: 20px;">PHP 0.00</label>
                </form>
            </div>
        </div>
        <div class="epic-modal-footer"><i>tummy-avenue.com</i></div>
    </div>
</div>

<!--JS-->
<?php 
include 'global/customerjs.html';
?>
<script>
const daysArr = document.querySelectorAll(".food-item");
var txtAmount = document.getElementById("modalFoodAmount");
var selectedFoodCost = 0;

daysArr.forEach(bt=>{
    bt.addEventListener('click', (e) => {
        document.getElementById("modalFoodImage").src = "img-uploads/" + e.target.children[3].value;
        document.getElementById("modalFoodName").innerHTML = e.target.children[0].innerHTML;
        document.getElementById("modalFoodDesc").innerHTML =  e.target.children[4].value;
        document.getElementById("modalFoodId").value =  e.target.children[1].value;

        selectedFoodCost = parseInt(e.target.children[2].value);
        document.getElementById("modalFoodCost").innerHTML = "PHP " + e.target.children[2].value + ".00";
        txtAmount.value = "1";

        epicOpenModal();
    })
})

function amountAdd()
{
    var amount = parseInt(txtAmount.value) + 1
    setNewAmount(amount);
}
function amountSubtract()
{
    var amount = parseInt(txtAmount.value) - 1
    setNewAmount(amount);
}
txtAmount.addEventListener('input', (e) => {
    if (txtAmount.value.length === 0) txtAmount.value = "1";
    setNewAmount(parseInt(txtAmount.value))
});
function setNewAmount(amount)
{
    var newAmount = amount;
    if (amount > 99) newAmount = 99;
    else if (amount < 1) newAmount = 1;

    txtAmount.value = newAmount.toString();
    document.getElementById("modalFoodCost").innerHTML = "PHP " + (selectedFoodCost * newAmount).toString() + ".00";
}
</script>
 
</body>
</html>