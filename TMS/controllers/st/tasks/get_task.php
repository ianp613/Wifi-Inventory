<?php
    header('Content-Type: application/json');
    session_start();
    include("../../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);
    
    $task = new Task;
    $task = DB::find($task,$data["id"]);
    
    echo json_encode($task);
?>
