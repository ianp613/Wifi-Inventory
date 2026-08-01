<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $user = new User;
    if(DB::validate($user,"username",$data["username"])){
        $user->fname = $data["fname"];
        $user->lname = $data["lname"];
        $user->privileges = $data["privileges"];
        $user->status = $data["status"];
        $user->dept_id = $data["dept_id"];
        $user->username = $data["username"];
        $user->password = Data::encrypt($data["password"]);
        DB::save($user);

        $response = [
            "status" => true,
            "type" => "success",
            "message" => "User account has been created."
        ];
    }else{
        $response = [
            "status" => false,
            "type" => "warning",
            "message" => "Username already exist."
        ];
    }
    echo json_encode($response);