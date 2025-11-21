<?php
    include("../../includes.php");
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);
    try {
        $conf = json_decode(file_get_contents("../../conf.json"));
        $conf->Unifi->Authentication = $data["authentication"];

        $i = 1;

        while ($i <= $data["voucher_amount"]) {
            $code = Data::generate(6,"numeric");
            $voucher = new Voucher;
            if(DB::validate($voucher,"upv",$code)){
                $voucher->name = $data["voucher_name"];
                $voucher->code = $code;
                $voucher->expiration = $data["voucher_expiration"] * $data["voucher_expiration_type"];
                $voucher->exp_type = $data["voucher_expiration_type"] == "1" ? "Minute" : ($data["voucher_expiration_type"] == "60" ? "Hour" : "Day");
                $voucher->upv = $data["upv"];
                DB::save($voucher);
                $i++;
            }
        }
        file_put_contents("../../conf.json",json_encode($conf, JSON_PRETTY_PRINT));
        echo json_encode("Vouchers has been added.");
    } catch (\Throwable $th) {
        echo json_encode("Error: ".$th);
    }
    

?>