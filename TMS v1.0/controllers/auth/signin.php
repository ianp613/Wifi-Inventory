<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");

    $data = json_decode(file_get_contents('php://input'), true);

    if($data) {
        $userid = $data['userid'];
        $password = $data['password'];
        $user = new User;
        // $auth = DB::auth($user,$userid,$password);
        $auth = false;

        $users = DB::where($user,"username","=",$userid);

        if(count($users) == 1){
            $hash = $users[0]["password"];
            if(Data::decrypt($password,$hash)){
                $auth = true;
            }
        }

        if($auth){
            $user = DB::where($user,"username","=",$userid);
            $_SESSION["auth"] = true;
            $_SESSION["userid"] = $user[0]["id"];
            $_SESSION["name"] = $user[0]["name"];
            $_SESSION["privileges"] = $user[0]["privileges"];
            
            $response = [
                "status" => true,
                "type" => "success",
                "message" => "Welcome ".$user[0]["name"],
                "privileges" => $user[0]["privileges"]
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
