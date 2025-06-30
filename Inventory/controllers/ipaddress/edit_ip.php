<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $ip = new IP_Address;
    $ip = DB::prepare($ip,$data["id"]);
    $ip->hostname = $data["hostname"] ? $data["hostname"] : "-";
    $ip->site = $data["site"] ? $data["site"] : "-";
    $ip->server = $data["server"] ? $data["server"] : "-";
    $ip->webmgmtpt = $data["webmgmtpt"] ? $data["webmgmtpt"] : "-";
    $ip->username = $data["username"] ? $data["username"] : "-";
    $ip->password = $data["password"] ? $data["password"] : "-";
    $ip->state = $data["state"];
    $ip->remarks = $data["remarks"] ? $data["remarks"] : "-";
    $ip->status = "ASSIGNED";
    DB::update($ip);

    $response = [
        "status" => true,
        "type" => "success",
        "size" => null,
        "message" => "IP has been updated.",
    ];

    echo json_encode($response);
?>