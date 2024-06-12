<?php
require __DIR__ . "/../../vendor/autoload.php";

// Dom PDF init
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options;
$options->setChroot(__DIR__ . "/../..");
$options->setIsRemoteEnabled(true);

$dompdf = new Dompdf($options);
$dompdf->setPaper("A4", "portrait");

require __DIR__ . "/../../global/funcs.php";
$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

$id = $_POST["id"];
$name = "superman";
$quantity = "69";

// GET FOODS
$foodarray = array();
$foodresult = $mysqli->query("SELECT * FROM foods");
while ($foodrow = $foodresult->fetch_assoc())
{
    $foodarray[$foodrow["id"]] = $foodrow;
}

// GET ORDER
$id = $_POST["id"];
$result = $mysqli->query("SELECT * FROM orders WHERE id = '$id'");
$order = $result->fetch_assoc();

// GET USER AND CASHIER INFO
$result = $mysqli->query(sprintf("SELECT * FROM users WHERE id = '%s'", $mysqli->real_escape_string($order["user_id"])));
$customer = $result->fetch_assoc();

$tablehtml = "";
$result = $mysqli->query("SELECT * FROM order_items WHERE order_id = '$id'");
while ($row = $result->fetch_assoc())
{
    $tablehtml .= "<tr>
        <td>" . $foodarray[$row["food_id"]]["name"] . "</td>
        <td>P" . getPriceFormat($row["food_cost"]) . "</td>
        <td>" . $row["amount"] . "</td>
        <td>P" . getPriceFormat($row["subtotal"]) . "</td>
        </tr>";
}

$html = file_get_contents("template.html");

$html = str_replace(
    ["{{ id }}", "{{ date }}", "{{ status }}", "{{ name }}", "{{ contact }}", "{{ email }}", "{{ total }}", "{{ items }}", "{{ table }}", "{{ titems }}", "{{ ttotal }}"],
    [$id, $order["date"], $order["status"], $customer["name"], $customer["contact"], $customer["email"], getPriceFormat($order["total_cost"]), $order["total_items"], $tablehtml, $order["total_items"], getPriceFormat($order["total_cost"])],
    $html);

$dompdf->loadHtml($html);
$dompdf->render();

$dompdf->addInfo("Title", "An Example PDF"); // "add_info" in earlier versions of Dompdf
$dompdf->stream("invoice.pdf", ["Attachment" => 0]);

$output = $dompdf->output();
file_put_contents("file.pdf", $output);
?>