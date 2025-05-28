<?php
    header('Content-Type: application/json');
    session_start();
    include("../includes.php");
    
    // Get the POST data
    $data = json_decode(file_get_contents('php://input'), true);

    $response = [
        "status" => false,
        "type" => "warning",
        "size" => null,
        "message" => "User not found."
    ]; 

    if($data) {
        $userid = $data['userid'];
        $user = new User;
        $temp = [];

        if(count(explode("@",$userid)) == 1){
            $temp = DB::where($user,"username","=",$userid);
            if(count($temp)){
                $_SESSION["code"] = Data::generate(6,"numeric");
                $response = [
                    "status" => true,
                    "type" => "info",
                    "size" => null,
                    "message" => "We sent your code to: ". $temp[0]["email"],
                    "user" => $temp,
                    "code" => $_SESSION["code"]
                ]; 
            }
            
        }
        if(count(explode("@",$userid)) == 2){
            $temp = DB::where($user,"email","=",$userid);
            if(count($temp)){
                $_SESSION["code"] = Data::generate(6,"numeric");
                $response = [
                    "status" => true,
                    "type" => "info",
                    "size" => null,
                    "message" => "We sent your code to: ". $temp[0]["email"],
                    "user" => $temp,
                    "code" => $_SESSION["code"]
                ]; 
            }
        }
        
    }
    echo json_encode($response);
?>
