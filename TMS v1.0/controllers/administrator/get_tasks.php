<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");

    $task = new Task;
    $task = DB::all($task);

    $checklist = new ChecklistItem;
    $checklist = DB::all($checklist);

    $comment = new Comment;
    $comment = DB::all($comment);

    $attachment = new Attachment;
    $attachment = DB::all($attachment);

    $task_ = [];

    foreach($task as $t){
        $done = 0;
        $total = 0;
        foreach($checklist as $cl){
            if($t["id"] == $cl["task_id"]){
                if($cl["is_done"] = "true") $done++;
                $total++;
            }
        }

        $t["checklist"] = [$done,$total];

        $cm_count = 0;
        foreach($comment as $cm){
            if($t["id"] == $cm["task_id"]){
                $cm_count++;
            }
        }

        $t["comments"] = $cm_count;

        $at_count = 0;
        foreach($attachment as $at){
            if($t["id"] == $at["task_id"]){
                $at_count++;
            }
        }

        $t["files"] = $at_count;

        array_push($task_,$t);
    }

    echo json_encode($task_);