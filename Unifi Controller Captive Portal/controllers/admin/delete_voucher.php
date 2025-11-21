<?php
    include("../../includes.php");
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    try {
        $voucher = new Voucher;
        // Unauthorized all client connected using this voucher
        // Get first the ClientVoucher table data, match the voucher code and get all the list of client
        DB::delete($voucher,$data["id"]);
        echo json_encode("Voucher has been deleted.");
    } catch (\Throwable $th) {
        echo json_encode("Error: ".$th);
    }
    
?>