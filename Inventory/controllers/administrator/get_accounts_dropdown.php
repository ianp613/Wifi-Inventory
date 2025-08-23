<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $user = new User;
    $supervisor = [];
    $users = [];

    $supervisor_temp = DB::where($user,"privileges","=","Supervisor");
    $users_temp = DB::where($user,"privileges","=","User");

    $usergroup = new User_Group;

    foreach ($supervisor_temp as $st) {
        if(!DB::where($usergroup,"supervisors","like",$st["username"])){
            array_push($supervisor,$st);
        }
    }
    foreach ($users_temp as $ut) {
        if(!DB::where($usergroup,"users","like",$ut["username"])){
            array_push($users,$ut);
        }
    }
    
    $response = [
        "status" => true,
        "supervisor" => $supervisor,
        "user" => $users,
    ];

    echo json_encode($response);
?>