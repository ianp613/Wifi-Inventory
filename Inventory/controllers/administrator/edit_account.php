<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data) {
        $user = new User;

        $user1 = DB::where($user,"username","=",$data["username"]);
        $user2 = DB::prepare($user,$data["id"]);

        if(count($user1)){
            if($user1[0]["id"] == $user2->id){
                $user2->name = $data["name"];
                $user2->email = $data["email"] ? $data["email"] : "-";
                $user2->username = $data["username"];
                $user2->password = $data["password"] ? $data["password"] : "12345";
                $user2->privileges = $data["privilege"];
                DB::update($user2);
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
                    "message" => "User ID already exist.",
                    "entry" => DB::all($user)
                ];
            }
        }else{
            $user2->name = $data["name"];
            $user2->email = $data["email"] ? $data["email"] : "-";
            $user2->username = $data["username"];
            $user2->password = $data["password"] ? $data["password"] : "12345";
            $user2->privileges = $data["privilege"];
            DB::update($user2);
                $response = [
                "status" => true,
                "type" => "success",
                "size" => null,
                "message" => "User account has been updated.",
                "entry" => DB::all($user)
            ];  
        }

        
        
        
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