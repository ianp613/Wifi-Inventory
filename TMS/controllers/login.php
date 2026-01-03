<?php
    header('Content-Type: application/json');
    session_start();
    include("../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data) {
        $response = [
            "status" => false,
            "auth" => false,
            "message" => "Login Failed."
        ];

        $user = new User;
        $res = DB::auth($user,$data["userid"],$data["password"]);

        if($res){
            $response["status"] = true;
            $response["auth"] = true;
            $response["message"] = "Login Success.";
        }
    }
    echo json_encode($response);
?>
