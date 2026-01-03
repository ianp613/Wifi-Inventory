<?php
    header('Content-Type: application/json');
    session_start();
    include("../includes.php");
    $tms_locations = new TMSLocation;
    $response = DB::all($tms_locations);
    echo json_encode($response);
?>
