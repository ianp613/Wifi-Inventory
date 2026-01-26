<?php
    header('Content-Type: application/json');
    session_start();
    include("../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data) {
        $response = [
            "status" => false,
            "auth" => false,
            "message" => "Login Failed.",
            "user" => []
        ];

        $user = new User;
        $res = DB::auth($user,$data["userid"],$data["password"]);

        if($res){
            $user = DB::where($user,"username","=",$data["userid"]);
            $response["status"] = true;
            $response["auth"] = true;
            $response["message"] = "Login Success.";
            $response["user"] = $user;
            $_SESSION["user_id"] = $user[0]["id"];
        }
    }
    echo json_encode($response);
?>
