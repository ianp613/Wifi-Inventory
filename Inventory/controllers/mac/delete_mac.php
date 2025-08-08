<?php
    session_start();
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data["id"]){
        $mac = new MAC_Address;
        $mac_temp = DB::find($mac,$data["id"]);

        $wifi = new Wifi;
        $wifi_temp = DB::find($wifi,$data["wid"]);
        
        $log = new Logs;
        $log->uid = $_SESSION["userid"];
        $log->log = $_SESSION["name"]." has deleted a MAC Address \"".$mac_temp[0]["mac"]."\" from wifi \"".$wifi_temp[0]["name"]."\".";
        if($_SESSION["log"] != $log->log){
            $_SESSION["log"] = $log->log;
            DB::save($log);
        }

        DB::delete($mac,$data["id"]);
        $response = [
            "status" => true,
            "type" => "info",
            "size" => null,
            "message" => "MAC address has been deleted."
        ];
    }else{
        $response = [
            "status" => false,
            "type" => "error",
            "size" => null,
            "message" => "MAC address not found."
        ];
    }
        
    echo json_encode($response);
?>