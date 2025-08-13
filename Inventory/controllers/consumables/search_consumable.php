<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $consumables = new Consumables;
    $codes = DB::where($consumables,"code","like",$data["search"]);
    $descriptions = DB::where($consumables,"description","like",$data["search"]);

    echo json_encode(array_merge($codes, $descriptions));
?>