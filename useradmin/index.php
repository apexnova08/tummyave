<?php 
include 'processes/redirect.php';

require __DIR__ . "/../global/funcs.php";
print_r(generateID(getCurrentDateTime()));
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
<h1>Admin</h1>
<a href="createfood.php">log in</a>

</body>
</html>
