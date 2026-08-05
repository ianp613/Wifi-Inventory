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
        $t["checklist_list"] = [];
        foreach($checklist as $cl){
            if($t["id"] == $cl["task_id"]){
                if($cl["is_done"] == "1") $done++;
                $total++;
                array_push($t["checklist_list"],$cl);
            }
        }

        $t["checklist"] = [$done,$total];

        $cm_count = 0;
        $t["comments_list"] = [];
        foreach($comment as $cm){
            if($t["id"] == $cm["task_id"]){
                $cm_count++;
                array_push($t["comments_list"],$cm);
            }
        }

        $t["comments"] = $cm_count;

        $at_count = 0;
        $t["attachment_list"] = [];
        foreach($attachment as $at){
            if($t["id"] == $at["task_id"]){
                $at_count++;
                array_push($t["attachment_list"],$at);
            }
        }

        $t["files"] = $at_count;

        array_push($task_,$t);
    }

    echo json_encode($task_);