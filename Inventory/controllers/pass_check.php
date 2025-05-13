<?php
    header('Content-Type: application/json');
    session_start();
    include("../includes.php");
    // Get the POST data
    $data = json_decode(file_get_contents('php://input'), true);

    if($data) {
        $userid = $data['userid'];
        $password = $data['password'];
        $user = new User;
        $auth = DB::auth($user,$userid,$password);

        if($auth){
            $response = [
                "status" => true,
                "type" => "success",
                "size" => null,
                "message" => "Export database in progress ...",
            ]; 
        }else{
            $response = [
                "status" => false,
                "type" => "error",
                "size" => null,
                "message" => "INCORRECT PASSWORD"
            ];    
        }
    }
    echo json_encode($response);
?>
