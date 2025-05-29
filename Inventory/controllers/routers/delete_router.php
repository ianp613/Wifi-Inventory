<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);
    $response = [
        "status" => false,
        "type" => "error",
        "size" => null,
        "message" => "Router not found."
    ];

    if($data["id"]) {
        $network = new IP_Network;
        $temp = DB::where($network,"rid","=",$data["id"]);
        if(count($temp)){
            foreach ($temp as $n) {
                $t = DB::prepare($network,$n["id"]);
                $t->rid = "-";
                DB::update($t);
            }
        }

        $router = new Routers;
        DB::delete($router,$data["id"]);

        $response = [
            "status" => true,
            "type" => "info",
            "size" => null,
            "message" => "Router has been deleted.",
        ];
    }
    echo json_encode($response);
?>