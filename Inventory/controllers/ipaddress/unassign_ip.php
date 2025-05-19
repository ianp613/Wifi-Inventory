<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);
    $response = [
        "status" => false,
        "type" => "error",
        "size" => null,
        "message" => "IP not found."
    ];

    if($data["id"]) {
        $ip = new IP_Address;
        DB::prepare($ip,$data["id"]);
        $ip->hostname = "-";
        $ip->site = "-";
        $ip->server = "-";
        $ip->status = "UNASSIGNED";
        $ip->remarks = "-";
        $ip->webmgmtpt = "-";
        $ip->username = "-";
        $ip->password = "-";
        DB::update($ip);

        $response = [
            "status" => true,
            "type" => "info",
            "size" => null,
            "message" => "IP address has been unassigned."
        ];
    }
    echo json_encode($response);
?>