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
            $user = DB::where($user,"username","=",$userid);
            $_SESSION["auth"] = true;
            $_SESSION["userid"] = $user[0]["id"];
            $_SESSION["name"] = $user[0]["name"];
            $_SESSION["privileges"] = $user[0]["privileges"];
            
            $log = new Logs;
            $log->uid = $user[0]["id"];
            $log->log = $user[0]["name"]." has logged into the system.";
            DB::save($log);
            $response = [
                "status" => true,
                "type" => "success",
                "size" => null,
                "message" => "Welcome",
                "user" => $user
            ]; 
        }else{
            $response = [
                "status" => false,
                "type" => "error",
                "size" => null,
                "message" => "Invalid User ID and Password"
            ];    
        }
    }
    echo json_encode($response);
?>
