<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data) {
        $router = new Routers;
        $router->name = $data["router_name"];
        $router->ip = $data["router_ip"];
        $router->subnet = $data["router_subnet"];
        $router->active = "-";
        $router->wan1 = $data["router_wan1"];
        $router->wan2 = $data["router_wan2"];
        DB::save($router);

        $response = [
            "status" => true,
            "type" => "success",
            "size" => null,
            "message" => "Router has been saved.",
            "router" => DB::all($router)
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