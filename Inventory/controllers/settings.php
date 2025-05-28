<?php
    header('Content-Type: application/json');
    session_start();
    include("../includes.php");
    $setting = new Settings;
    echo json_encode(DB::all($setting)[0]);
?>
