<?php
    session_start();
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data) {
        $router = new Routers;
        $router->uid = $data["uid"];
        $router->name = $data["router_name"];
        $router->ip = $data["router_ip"];
        $router->subnet = $data["router_subnet"];
        $router->active = "-";
        $router->wan1 = $data["router_wan1"];
        $router->wan2 = $data["router_wan2"];
        
        DB::save($router);

        $log = new Logs;
        $log->uid = $_SESSION["userid"];
        $log->log = $_SESSION["name"]." has added a router \"".$data["router_name"]."\".";
        if($_SESSION["log1"] != $log->log){
            $_SESSION["log1"] = $log->log;
            DB::save($log);
        }

        if($router->wan1 != "-"){
            $isp = new ISP;
            $isp_temp = DB::find($isp,$router->wan1);

            $log = new Logs;
            $log->uid = $_SESSION["userid"];
            $log->log = $_SESSION["name"]." has set ISP \"".$isp_temp[0]["name"]."\" as WAN 1 of router \"".$data["router_name"]."\".";
            if($_SESSION["log2"] != $log->log){
                $_SESSION["log2"] = $log->log;
                DB::save($log);
            }
        }

        if($router->wan2 != "-"){
            $isp = new ISP;
            $isp_temp = DB::find($isp,$router->wan2);

            $log = new Logs;
            $log->uid = $_SESSION["userid"];
            $log->log = $_SESSION["name"]." has set ISP \"".$isp_temp[0]["name"]."\" as WAN 2 of router \"".$data["router_name"]."\".";
            if($_SESSION["log3"] != $log->log){
                $_SESSION["log3"] = $log->log;
                DB::save($log);
            }
        }

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