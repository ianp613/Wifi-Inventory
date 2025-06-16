<?php
    session_start();
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data["name"]) {
        $equipment = new Equipment;
        $bol = DB::validate($equipment,"name",$data["name"]);

        if($bol){
            $equipment = DB::prepare($equipment,$data["id"]);
            $equipment_name_temp = $equipment->name;
            $equipment->name = $data["name"];
            DB::update($equipment);

            if($equipment_name_temp != $data["name"]){
                $log = new Logs;
                $log->uid = $_SESSION["userid"];
                $log->log = $_SESSION["name"]." has updated an equipment name from \"".$equipment_name_temp."\" to \"".$data["name"].".\"";
                if($_SESSION["log"] != $log->log){
                    $_SESSION["log"] = $log->log;
                    DB::save($log);
                }    
            }

            $response = [
                "status" => true,
                "type" => "success",
                "size" => null,
                "message" => "Equipment has been updated."
            ];
            
        }else{
            $response = [
                "status" => false,
                "type" => "info",
                "size" => null,
                "message" => "Equipment already exist."
            ];    
        }
    }else{
        $response = [
            "status" => false,
            "type" => "warning",
            "size" => null,
            "message" => "Please provide equipment name."
        ];
    }
    echo json_encode($response);
?>