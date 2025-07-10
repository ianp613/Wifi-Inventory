<?php
    header('Content-Type: application/json');
    include("../../includes.php");

    $type = $_POST['type'];
    $text = $_POST['text'];
    $ssid = $_POST['ssid'];
    $key = $_POST['key'];
    $overlay = $_POST['overlay'];

    if(isset($_FILES['logo'])){
        $logo = $_FILES['logo'];
    }


