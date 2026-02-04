<?php
    header('Content-Type: application/json');
    session_start();
    include("../../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $remark = new Remark;
    $remark = DB::where($remark,"tid","=",$data["tid"]);

    echo json_encode($remark);
?>