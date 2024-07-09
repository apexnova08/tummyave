<?php
$mysqli = require __DIR__ . "/../../database.php";

// GET VARS
$vars = array();
$resultvars = $mysqli->query("SELECT * FROM vars");
while ($row = $resultvars->fetch_assoc())
{
    $vars[$row["name"]] = $row["value"];
}

if ($vars["store_closed"]) {
?>
<div class="epic-sanss" style="position: fixed; left: 0; width: 100%; bottom: 0; background-color: red; color: white; text-align: center; padding: 5px;">
    Store currently closed.
</div>
<?php
}
?>