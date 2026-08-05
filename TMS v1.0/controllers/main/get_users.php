<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");

    $user = new User;
    $user = DB::all($user);

    echo json_encode($user);