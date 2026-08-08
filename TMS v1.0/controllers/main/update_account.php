<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $user = new User;
    $user = DB::prepare($user,$data["id"]);
    $user->fname = $data["fname"];
    $user->lname = $data["lname"];
    $user->dept_id = $data["dept_id"];
    $user->privileges = $data["privileges"];
    $user->password = array_key_exists("password",$data) ? Data::encrypt($data["password"]) : $user->password;
    DB::update($user);

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "You account has been updated."
    ];

    echo json_encode($response);