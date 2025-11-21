<?php
    include("../../includes.php");
    header('Content-Type: application/json');

    // Load input data
    $data = json_decode(file_get_contents('php://input'), true);

    $conf = json_decode(file_get_contents("../../conf.json"));
    $conf->Unifi->Authentication = $data["authentication"];
    $conf->Unifi->Open->Time = $data["expiration"];
    $conf->Unifi->Open->Type = $data["expiration_type"];

    // Check first if there is voucher
    $voucher = new Voucher;
    $vouchers = DB::all($voucher);
    if(count($vouchers)){
        // Unauthorize all client that are connected through vouchers
    }

    // Delete all vouchers
    DB::wipe($voucher);

    file_put_contents("../../conf.json",json_encode($conf, JSON_PRETTY_PRINT));
    echo json_encode($conf);

?>