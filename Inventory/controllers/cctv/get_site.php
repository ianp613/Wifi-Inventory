<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $cctv = new CCTV_Location;
    $cctv = DB::all($cctv);
    $response = [
        "status" => true,
        "cctvs" => $cctv
    ];    
    echo json_encode($response);
?>