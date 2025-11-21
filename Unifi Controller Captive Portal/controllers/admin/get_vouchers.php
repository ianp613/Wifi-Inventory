<?php
    include("../../includes.php");
    header('Content-Type: application/json');

    $voucher = new Voucher;
    echo json_encode(DB::all($voucher));

?>