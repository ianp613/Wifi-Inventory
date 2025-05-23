<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $isp = new ISP;
    $isp = DB::prepare($isp,$data["id"]);
    $isp->name = $data["name"] ? $data["name"] : "-";
    $isp->isp_name = $data["isp_name"] ? $data["isp_name"] : "-";
    $isp->wan_ip = $data["wan_ip"] ? $data["wan_ip"] : "-";
    $isp->subnet = $data["subnet"] ? $data["subnet"] : "-";
    $isp->gateway = $data["gateway"] ? $data["gateway"] : "-";
    $isp->dns1 = $data["dns1"] ? $data["dns1"] : "-";
    $isp->dns2 = $data["dns2"] ? $data["dns2"] : "-";
    $isp->webmgmtpt = $data["webmgmtpt"] ? $data["webmgmtpt"] : "-";
    DB::update($isp);

    $response = [
        "status" => true,
        "type" => "success",
        "size" => null,
        "message" => "ISP has been updated.",
    ];

    echo json_encode($response);
?>