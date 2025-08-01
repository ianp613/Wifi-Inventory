<?php
    session_start();
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data) {
        $isp = new ISP;
        $isp->uid = $data["uid"];
        $isp->name = $data["name"] ? $data["name"] : "-";
        $isp->isp_name = $data["isp_name"] ? $data["isp_name"] : "-";
        $isp->wan_ip = $data["wan_ip"] ? $data["wan_ip"] : "-";
        $isp->subnet = $data["subnet"] ? $data["subnet"] : "-";
        $isp->gateway = $data["gateway"] ? $data["gateway"] : "-";
        $isp->dns1 = $data["dns1"] ? $data["dns1"] : "-";
        $isp->dns2 = $data["dns2"] ? $data["dns2"] : "-";
        $isp->webmgmtpt = $data["webmgmtpt"] ? $data["webmgmtpt"] : "-";

        DB::save($isp);

        $log = new Logs;
        $log->uid = $_SESSION["userid"];
        $log->log = $_SESSION["name"]." has added an ISP \"".$data["name"]."\".";
        if($_SESSION["log"] != $log->log){
            $_SESSION["log"] = $log->log;
            DB::save($log);
        }

        $response = [
            "status" => true,
            "type" => "success",
            "size" => null,
            "message" => "ISP has been saved.",
            "isp" => DB::all($isp)
        ];
    }else{
        $response = [
            "status" => false,
            "type" => "warning",
            "size" => null,
            "message" => "Something went wrong."
        ];
    }
    echo json_encode($response);
?>