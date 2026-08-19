<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");

    $log = new Log;
    $log = DB::all($log);
    $log = array_reverse($log);

    echo json_encode($log);