<?php
    header('Content-Type: application/json');
    session_start();
    include("../../../includes.php");
    $MAX_SIZE = 6 * 1024 * 1024; // 5MB
    $UPLOAD_DIR = "../../../assets/uploads/remark_file_attachments/";

    $response = [
        "status" => true,
        "message" => "Remark has been saved",
        "type" => $_POST["type"]
    ];

    if (!is_dir($UPLOAD_DIR)) {
        mkdir($UPLOAD_DIR, 0755, true);
    }
    
    $remark = new Remark;
    $remark->uid = $_SESSION["user_id"];
    $remark->tid = $_POST["tid"];
    $remark->type = $_POST["type"];

    if($_POST["type"] == "remark_only"){
        $remark->content = $_POST["remark"];
        DB::save($remark);
    }
    if($_POST["type"] == "file_only" || $_POST["type"] == "file_with_remark"){
        $content = "";
        if (!isset($_FILES['file'])) {
            $response["status"] = false;
            $response["message"] = "No file uploaded";
            echo json_encode($response);
            exit;
        }

        $file = $_FILES['file'];

        // PHP upload errors
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $response["status"] = false;
            $response["message"] = "Upload error";
            echo json_encode($response);
            exit;
        }

        // Size check (never trust JS)
        if ($file['size'] > $MAX_SIZE) {
            $response["status"] = false;
            $response["message"] = "File exceeds 5MB limit";
            echo json_encode($response);
            exit;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Secure file name
        $newName = uniqid("file_") . "." . $ext;

        // Ensure folder exists
        if (!is_dir($UPLOAD_DIR)) {
            mkdir($UPLOAD_DIR, 0755, true);
        }

        move_uploaded_file($file['tmp_name'], $UPLOAD_DIR . $newName);

        if($_POST["type"] == "file_only"){
            $content .= $file["name"] . "+++";
            $content .= $newName . "+++";
            $content .= $_POST["size"];
        }
        if($_POST["type"] == "file_with_remark"){
            $content .= $file["name"] . "+++";
            $content .= $newName . "+++";
            $content .= $_POST["size"] . "***";
            $content .= $_POST["remark"];
        }

        $remark->content = $content;
        DB::save($remark);
    }

    echo json_encode($response);

?>