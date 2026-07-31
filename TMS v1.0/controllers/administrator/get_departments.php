<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");

    $dept = new Department;
    $dept = DB::all($dept);

    echo json_encode($dept);