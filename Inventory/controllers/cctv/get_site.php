<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $cctv = new CCTV_Location;
    $cctv = DB::all($cctv);

    // Remove files in mpas that are not in database
    $imgs_db = [];
    foreach ($cctv as $location) {
        $imgs_db[] = $location["floorplan"];
    }
    $imgs = glob("../../assets/img/maps/*");
    $img_remove_maps = array_diff($imgs,$imgs_db);

    foreach ($img_remove_maps as $remove) {
        if(file_exists($remove)){
            unlink($remove);
        }
    }

    // Remove files in mpas output that are not in database
    $imgs_db = [];
    foreach ($cctv as $location) {
        $imgs_db[] = str_replace("maps","maps_output",$location["floorplan"]);
    }

    $imgs = glob("../../assets/img/maps_output/*");
    $img_remove_maps = array_diff($imgs,$imgs_db);

    foreach ($img_remove_maps as $remove) {
        if(file_exists($remove)){
            unlink($remove);
        }
    }
    
    $response = [
        "status" => true,
        "cctvs" => $cctv
    ];    
    echo json_encode($response);
?>