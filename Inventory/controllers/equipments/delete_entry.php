<?php
    session_start();
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data["id"]){
        $entry = new Equipment_Entry;
        $entry_temp = DB::find($entry,$data["id"]);

        $equipment = new Equipment;
        $equipment_temp = DB::find($equipment,$data["eid"]);
        
        $log = new Logs;
        $log->gid = $_SESSION["g_id"] ? $_SESSION["g_id"] : "_*";
        $log->uid = $_SESSION["userid"];
        $log->log = $_SESSION["name"]." has deleted an entry \"".$data["description"]."\" from equipment \"".$equipment_temp[0]["name"]."\".";
        if($_SESSION["log"] != $log->log){
            $_SESSION["log"] = $log->log;
            DB::save($log);
        }

        DB::delete($entry,$data["id"]);
        $response = [
            "status" => true,
            "type" => "info",
            "size" => null,
            "message" => "Entry has been deleted."
        ];
    }else{
        $response = [
            "status" => false,
            "type" => "error",
            "size" => null,
            "message" => "Entry not found."
        ];
    }
        
    echo json_encode($response);
?>