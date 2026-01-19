<?php
    header('Content-Type: application/json');
    session_start();
    include("../../../includes.php");
    
    $users = new User;
    $users = DB::all($users);

    $user_temp = [];
    
    foreach ($users as $user) {
        $user["privileges"] != "Administrator" ? array_push($user_temp,$user) : null; 
    }

    echo json_encode($user_temp);
?>
