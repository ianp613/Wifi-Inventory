<?php
    $response = [
        "status" => true,
        "message" => "File has been uploaded",
        "name" => "",
        "storage_name" => ""
    ];

    $MAX_SIZE = 6 * 1024 * 1024; // 5MB
    $UPLOAD_DIR = "../../../assets/uploads/task_file_attachments/";

    if (!isset($_FILES['file'])) {
        $response["status"] = false;
        $response["message"] = "No file uploaded";
        echo json_encode($response);
        exit;
    }

    $file = $_FILES['file'];
    $response["name"] = $file["name"];

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

    // Optional: allowed extensions
    $allowed = ['jpg','png','pdf','zip'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // if (!in_array($ext, $allowed)) {
    //     exit("File type not allowed");
    // }

    // Secure file name
    $newName = uniqid("file_") . "." . $ext;

    // Ensure folder exists
    if (!is_dir($UPLOAD_DIR)) {
        mkdir($UPLOAD_DIR, 0755, true);
    }

    move_uploaded_file($file['tmp_name'], $UPLOAD_DIR . $newName);

    $response["storage_name"] = $newName;

    echo json_encode($response);
