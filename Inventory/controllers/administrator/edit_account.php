<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data) {
        $user = new User;

        $user = DB::prepare($user,$data["id"]);
        $user->name = $data["name"];
        $user->email = $data["email"] ? $data["email"] : "-";
        $user->username = $data["username"];
        $user->password = $data["password"] ? $data["password"] : "12345";
        $user->privileges = $data["privilege"];
        DB::update($user);
        
        $response = [
            "status" => true,
            "type" => "success",
            "size" => null,
            "message" => "User account has been updated.",
            "entry" => DB::all($user)
        ];
    }else{
        $response = [
            "status" => false,
            "type" => "warning",
            "size" => null,
            "message" => "Something went wrong."
        ];
    }
    echo json_encode($response);
?>