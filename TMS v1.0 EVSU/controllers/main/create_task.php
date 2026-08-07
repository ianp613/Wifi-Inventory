<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");

    // Regular fields come from $_POST, not php://input
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $project_id  = $_POST['project_id'];
    $user_id     = $_POST['user_id'];
    $created_by  = $_SESSION['userid'];
    $priority    = $_POST['priority'];
    $status      = $_POST['status'];
    $task_budy   = $_POST["task_budy"] ? $_POST["task_budy"] : "-";
    $rectify     = "0";
    $start_date  = $_POST['start_date'];
    $due_date    = $_POST['due_date'];
    $checklist   = json_decode($_POST['checklist'] ?? '[]', true);

    if(trim($title) === ''){
        echo json_encode([
            "status" => false,
            "type" => "error",
            "message" => "Task title is required."
        ]);
        exit;
    }

    $task = new Task;
    $task->title = $title;
    $task->description = $description;
    $task->project_id = $project_id;
    $task->user_id = $user_id;
    $task->created_by = $created_by;
    $task->priority = $priority;
    $task->status = $status;
    $task->task_budy = $task_budy;
    $task->rectify = $rectify;
    $task->start_date = $start_date;
    $task->due_date = $due_date;
    $task_id = DB::save($task);

    // ASSUMPTION: DB::save() populates an ->id property on the object after inserting.
    // Adjust this line if your framework returns the new id a different way.
    // $task_id = $task->id;

    // ---- Checklist items ----
    foreach($checklist as $item){
        $ci = new ChecklistItem;
        $ci->task_id = $task_id;
        $ci->text = $item;
        $ci->is_done = "0";
        $ci->position = "0";
        DB::save($ci);
    }

    // ---- Attachments ----
    // $_FILES['attachments'] is arrays-of-arrays here because the input name was attachments[]
    if(isset($_FILES['attachments'])){
        $upload_dir = "../../attachments/";
        if(!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

        $count = count($_FILES['attachments']['name']);
        for($i = 0; $i < $count; $i++){
            if($_FILES['attachments']['error'][$i] !== UPLOAD_ERR_OK) continue;

            $original_name = $_FILES['attachments']['name'][$i];
            $tmp_path      = $_FILES['attachments']['tmp_name'][$i];
            $size          = $_FILES['attachments']['size'][$i];
            $mime          = $_FILES['attachments']['type'][$i];

            $safe_name = uniqid() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $original_name);
            $dest_path = $upload_dir . $safe_name;

            if(move_uploaded_file($tmp_path, $dest_path)){
                $att = new Attachment;
                $att->task_id = $task_id;
                $att->file_name = $original_name;
                $att->file_path = $dest_path;
                $att->file_size = $size;
                $att->mime_type = $mime;
                DB::save($att);
            }
        }
    }

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "Task has been created."
    ];

    echo json_encode($response);
?>