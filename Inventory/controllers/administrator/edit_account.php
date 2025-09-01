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

                $group = new User_Group;
                $group_data = DB::all($group);
                
                // If privileges update to Administrator, Check if account id exist in USER or SUPERVISOR column
                if($data["privilege"] == "Administrator"){
                    if($user2->privileges == "Supervisor"){
                        foreach ($group_data as $gd) {
                            $id_temp = explode("|",$gd["supervisors"]);
                            $id_temp2 = [];
                            if(in_array($data["id"],$id_temp)){
                                foreach ($id_temp as $idt) {
                                    $idt != $data["id"] ? array_push($id_temp2,$idt) : null;
                                }
                                $gd_prep = DB::prepare($group,$gd["id"]);
                                $gd_prep->supervisors = implode("|",$id_temp2) ? implode("|",$id_temp2) : "|";
                                DB::update($gd_prep);
                            }
                        }
                    }
                    if($user2->privileges == "User"){
                        foreach ($group_data as $gd) {
                            $id_temp = explode("|",$gd["users"]);
                            $id_temp2 = [];
                            if(in_array($data["id"],$id_temp)){
                                foreach ($id_temp as $idt) {
                                    $idt != $data["id"] ? array_push($id_temp2,$idt) : null;
                                }
                                $gd_prep = DB::prepare($group,$gd["id"]);
                                $gd_prep->users = implode("|",$id_temp2) ? implode("|",$id_temp2) : "|";
                                DB::update($gd_prep);
                            }
                        }
                    }
                }
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