<?php

function getCurrentDateTime()
{
    date_default_timezone_set("Asia/Manila");
    return date("Y/m/d H:i:s");
}

function generateID(string $datestring)
{
    $arr = explode(" ", $datestring);
    $datearr = explode("/", $arr[0]);
    $timearr = explode(":", $arr[1]);
    
    return $datearr[0] . $datearr[1] . $datearr[2] . $timearr[0] . $timearr[1] . $timearr[2];
}

function uploadImage(string $filename)
{
    // Reject uploaded file larger than 1MB
    if ($_FILES["image"]["size"] > 10485760) {
        exit('File too large (max 1MB)');
    }

    // Use fileinfo to get the mime type
    $mime_types = ["image/gif", "image/png", "image/jpeg"];
    if ( ! in_array($_FILES["image"]["type"], $mime_types)) {
        exit("Invalid file type");
        return;
    }

    // Upload
    $pathinfo = pathinfo($_FILES["image"]["name"]);
    $filename = $filename . "." . $pathinfo["extension"];
    $destination = __DIR__ . "/../img-uploads/" . $filename;

    if ( ! move_uploaded_file($_FILES["image"]["tmp_name"], $destination)) {
        exit("Can't move uploaded file");
        return;
    }
}
?>