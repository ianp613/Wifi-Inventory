<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");

    $project = new Project;
    $project = DB::all($project);
    
    echo json_encode($project);