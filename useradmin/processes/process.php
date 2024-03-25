<?php

require __DIR__ . "/../../global/funcs.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

uploadImage(generateID(getCurrentDateTime()));

echo "File uploaded successfully.";