<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $isp = new ISP;
    $isp = DB::all($isp);
    $response = [
        "status" => true,
        "isp" => $isp
    ];    
    echo json_encode($response);
?>