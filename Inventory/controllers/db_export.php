<?php
    header('Content-Type: application/json');
    session_start();
    include("../includes.php");

    $response = DB::export("../assets/temp/");

    echo json_encode($response);
?>