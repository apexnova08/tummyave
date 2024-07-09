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
    <title>Owner Panel | Dashboard</title>
    
    <!--CSS AND NAV-->
    <?php 
    include '../global/uf/css.html';
    include 'nav.php';
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
</head>

<body>

<!--#####-->
<section id="section_name" class="padding bg_white">
    <div class="container">
        <div>
            <h2 class="heading">Sales &nbsp; Dashboard</h2>
            <hr class="heading_space">
        </div>
        <div>
            <div style="overflow: hidden;">
                <div class="col-md-4" style="color: #E25111;">
                    <div class="epic-otab" style="border-color: #E25111;" onclick="sales()">
                        <label class="epic-sanssb epic-txt16">Total Sales</label>
                        </br>
                        <label class="epic-sanss epic-txt30" id="salesText">₱0.00</label>
                    </div>
                </div>
                <div class="col-md-4" style="color: #00ADB0;">
                    <div class="epic-otab" style="border-color: #00ADB0;" onclick="orders()">
                        <label class="epic-sanssb epic-txt16">Total Orders</label>
                        </br>
                        <label class="epic-sanss epic-txt30" id="ordersText">0</label>
                    </div>
                </div>
                <div class="col-md-4" style="color: red;">
                    <div class="epic-otab" style="border-color: red;" onclick="cancels()">
                        <label class="epic-sanssb epic-txt16">Canceled Orders</label>
                        </br>
                        <label class="epic-sanss epic-txt30" id="cancelsText">0</label>
                    </div>
                </div>
            </div>
            <canvas id="salesChart" style="width:100%; margin-top: 100px;"></canvas>
            <canvas id="ordersChart" style="width:100%; margin-top: 100px; display: none;"></canvas>
            <canvas id="cancelsChart" style="width:100%; margin-top: 100px; display: none;"></canvas>
        </div>
    </div>
</section>




<!-- ## CHART DATA ## -->
<?php
echo ('<script>const daysArr = [];</script>');
echo ('<script>const salesArr = [];</script>');
echo ('<script>const ordersArr = [];</script>');
echo ('<script>const cancelsArr = [];</script>');

$datesarr = array();
for ($i = 6; $i >= 0; $i--) array_push($datesarr, subtractDaysFromDate(getCurrentDate(), $i));
foreach ($datesarr as $date)
{
    $s = explode(", ", getLongDateFormat($date))[0];
    echo ("<script>daysArr.push('$s');</script>");

    $record = ($mysqli->query("SELECT SUM(total_cost) AS sales FROM orders WHERE `status` = 'Picked up' AND `date` LIKE '$date%'"))->fetch_assoc();
    if (!$record["sales"]) $record["sales"] = 0;
    echo ("<script>salesArr.push('" . $record["sales"] . "');</script>");

    $record = ($mysqli->query("SELECT COUNT(*) AS orders FROM orders WHERE `date` LIKE '$date%'"))->fetch_assoc();
    echo ("<script>ordersArr.push('" . $record["orders"] . "');</script>");

    $record = ($mysqli->query("SELECT COUNT(*) AS cancels FROM orders WHERE `status` = 'Closed' AND `date` LIKE '$date%'"))->fetch_assoc();
    echo ("<script>cancelsArr.push('" . $record["cancels"] . "');</script>");
}
?>

<a href="#" id="back-top"><i class="fa fa-angle-up fa-2x"></i></a>

<!--JS-->
<?php 
include '../global/uf/js.html';
include '../global/uf/adminfooter.php';
?>

<script>

txtSales = document.getElementById("salesText");
txtOrders = document.getElementById("ordersText");
txtCancels = document.getElementById("cancelsText");
const barColors = ["red", "green","blue","orange","brown","black","yellow","aqua"];

// CHARTS
cSales = document.getElementById("salesChart");
chartSales = new Chart(cSales.getContext('2d'), {
    type: "bar",
    data: {
        labels: daysArr,
        datasets: [{
        backgroundColor: "#E25111",
        data: salesArr
        }]
    },
    options: {
        legend: {display: false},
        title: {
        display: true,
        text: "Daily Sales Past 7 Days"
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    userCallback: function(label, index, labels) {
                        // when the floored value is the same as the value we have a whole number
                        if (Math.floor(label) === label) {
                            return label;
                        }

                    },
                }
            }],
        }
    }
});
cOrders = document.getElementById("ordersChart");
chartOrders = new Chart(cOrders.getContext('2d'), {
    type: "bar",
    data: {
        labels: daysArr,
        datasets: [{
        backgroundColor: "#00ADB0",
        data: ordersArr
        }]
    },
    options: {
        legend: {display: false},
        title: {
        display: true,
        text: "Daily Amount of Orders Past 7 Days"
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    userCallback: function(label, index, labels) {
                        // when the floored value is the same as the value we have a whole number
                        if (Math.floor(label) === label) {
                            return label;
                        }

                    },
                }
            }],
        }
    }
});
cCancels = document.getElementById("cancelsChart");
chartCancels = new Chart(cCancels.getContext('2d'), {
    type: "bar",
    data: {
        labels: daysArr,
        datasets: [{
        backgroundColor: "red",
        data: cancelsArr
        }]
    },
    options: {
        legend: {display: false},
        title: {
        display: true,
        text: "Daily Amount of Canceled Orders Past 7 Days"
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    userCallback: function(label, index, labels) {
                        // when the floored value is the same as the value we have a whole number
                        if (Math.floor(label) === label) {
                            return label;
                        }

                    },
                }
            }],
        }
    }
});

// CLICK EVENTS
cSales.onclick = (evt) => {
    const res = chartSales.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
    if (res.length === 0) return;
    
    //alert('You clicked on ' + res[0]["_index"] + " epic " + chart.data.labels[res[0]["_index"]]);
    txtSales.innerHTML = "₱" + salesArr[res[0]["_index"]] + ".00";
    txtOrders.innerHTML = ordersArr[res[0]["_index"]];
    txtCancels.innerHTML = cancelsArr[res[0]["_index"]];
};
cOrders.onclick = (evt) => {
    const res = chartOrders.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
    if (res.length === 0) return;

    txtSales.innerHTML = "₱" + salesArr[res[0]["_index"]] + ".00";
    txtOrders.innerHTML = ordersArr[res[0]["_index"]];
    txtCancels.innerHTML = cancelsArr[res[0]["_index"]];
};
cCancels.onclick = (evt) => {
    const res = chartCancels.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
    if (res.length === 0) return;

    txtSales.innerHTML = "₱" + salesArr[res[0]["_index"]] + ".00";
    txtOrders.innerHTML = ordersArr[res[0]["_index"]];
    txtCancels.innerHTML = cancelsArr[res[0]["_index"]];
};
// DEFAULTS
txtSales.innerHTML = "₱" + salesArr[6] + ".00";
txtOrders.innerHTML = ordersArr[6];
txtCancels.innerHTML = cancelsArr[6];

// CHART SELECTOR
function sales()
{
    cSales.style.display = "block";
    cOrders.style.display = "none";
    cCancels.style.display = "none";
}
function orders()
{
    cSales.style.display = "none";
    cOrders.style.display = "block";
    cCancels.style.display = "none";
}
function cancels()
{
    cSales.style.display = "none";
    cOrders.style.display = "none";
    cCancels.style.display = "block";
}
</script>


</body>
</html>
