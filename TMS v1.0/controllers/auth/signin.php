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
            $_SESSION["fname"] = $user[0]["fname"];
            $_SESSION["lname"] = $user[0]["lname"];
            $_SESSION["privileges"] = $user[0]["privileges"];

            if($user[0]["status"] == "inactive"){
                $response = [
                    "status" => false,
                    "type" => "warning",
                    "message" => "This user profile is inactive. Please contact support to turn it back on."
                ];
                echo json_encode($response);
                exit;
            }
            
            $response = [
                "status" => true,
                "type" => "success",
                "message" => "Welcome ".$user[0]["fname"],
                "privileges" => $user[0]["privileges"],
                "fname" => $user[0]["fname"],
                "lname" => $user[0]["lname"],
                "avatar" => $user[0]["fname"][0].$user[0]["lname"][0]
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
