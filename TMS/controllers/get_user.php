<?php
    header('Content-Type: application/json');
    session_start();
    include("../includes.php");

    $user = new User;
    echo json_encode(DB::find($user,$_SESSION["user_id"]));
?>