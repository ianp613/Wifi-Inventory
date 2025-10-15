<?php
    session_start();
    header('Content-Type: application/json');
    include("../../includes.php");

    if($_SESSION["g_member"]){
        #check if link exist
        $link = ["g_id" => $_SESSION["g_id"], "g_name" => $_SESSION["g_name"]];
        // file_put_contents()
        echo json_encode();
    }

?>