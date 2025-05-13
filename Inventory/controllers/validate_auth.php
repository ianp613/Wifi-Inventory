<?php
    header('Content-Type: application/json');
    session_start();
    include("../includes.php");
    
    $response = [
        "status" => false,
        "type" => "error",
        "size" => null,
        "message" => "Invalid authentication!"
    ]; 
    if(array_key_exists("auth",$_SESSION)){
        if($_SESSION["auth"]){
            $user = new User;
            $user = DB::find($user, $_SESSION["userid"]);
            $response = [
                "status" => true,
                "type" => "success",
                "size" => null,
                "message" => "Welcome",
                "user" => $user
            ]; 
        }    
    }
    echo json_encode($response);
?>
