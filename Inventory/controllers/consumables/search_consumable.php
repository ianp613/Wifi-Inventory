<?php
    session_start();
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $consumables = new Consumables;
    $codes = DB::where($consumables,"code","like",$data["search"]);
    if($_SESSION["g_id"]){
        $temp1 = [];
        foreach ($codes as $code) {
            if($code["gid"] == $_SESSION["g_id"]){
                array_push($temp1,$code);
            }
        }
        $codes = $temp1;
    }

    $descriptions = DB::where($consumables,"description","like",$data["search"]);
    if($_SESSION["g_id"]){
        $temp2 = [];
        foreach ($descriptions as $description) {
            if($description["gid"] == $_SESSION["g_id"]){
                array_push($temp2,$description);
            }
        }
        $descriptions = $temp2;
    }
    echo json_encode(array_merge($codes, $descriptions));
?>