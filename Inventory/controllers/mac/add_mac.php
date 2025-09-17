<?php
    session_start();
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data) {
        $mac = new MAC_Address;
        $bol = true;

        $mac_temp = DB::where($mac,"wid","=",$data["wid"]);
        foreach ($mac_temp as $mt) {
            if($mt["mac"] == $data["mac"]){
                $bol = false;
            }
        }

        if($bol){
            $mac->gid = $_SESSION["g_id"] ? $_SESSION["g_id"] : "_*";
            $mac->uid = $data["uid"];
            $mac->wid = $data["wid"];
            $mac->mac = $data["mac"];
            $mac->name = $data["name"] ? $data["name"] : "-";
            $mac->device = $data["device"] ? $data["device"] : "-";
            $mac->project = $data["project"] ? $data["project"] : "-";
            $mac->location = $data["location"] ? $data["location"] : "-";
            $mac->remarks = $data["remarks"] ? $data["remarks"] : "-";

            DB::save($mac);

            $wifi = new Wifi;
            $wifi_temp = DB::find($wifi,$data["wid"]);

            $log = new Logs;
            $log->gid = $_SESSION["g_id"] ? $_SESSION["g_id"] : "_*";
            $log->uid = $_SESSION["userid"];
            $log->log = $_SESSION["name"]." has add a MAC address \"".$data["mac"]."\" to wifi \"".$wifi_temp[0]["name"]."\".";
            if($_SESSION["log"] != $log->log){
                $_SESSION["log"] = $log->log;
                DB::save($log);
            }

            $response = [
                "status" => true,
                "type" => "success",
                "size" => null,
                "message" => "MAC address has been saved.",
            ];
        }else{
            $response = [
                "status" => false,
                "type" => "warning",
                "size" => null,
                "message" => "MAC address \"".$data["mac"]."\" already exist in ",
            ];
        }
        
    }else{
        $response = [
            "status" => false,
            "type" => "error",
            "size" => null,
            "message" => "Something went wrong."
        ];
    }
    echo json_encode($response);
?>