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
    
}
?>