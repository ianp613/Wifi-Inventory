<?php
    header('Content-Type: application/json');
    session_start();
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);


    function task_map($task_budy_list) {
        $count = count($task_budy_list);
        if ($count === 0) {
            return "none";
        }
        $res = "";
        for ($i = 0; $i < $count; $i++) {
            $res .= '<span class="task_log" data-show-assignee="' .
                    $task_budy_list[$i]["id"] . '">' .
                    $task_budy_list[$i]["fname"] .
                    '</span>';
            if ($count > 1) {
                if ($i < $count - 2) {
                    $res .= ", ";
                }
                elseif ($i == $count - 2) {
                    $res .= " and ";
                }
            }
        }
        return $res;
    }


    $task = new Task;
    $task = DB::prepare($task,$data["id"]);

    $task_title_temp = $task->title;
    $task_description_temp = $task->description;
    $task_project_id_temp = $task->project_id;
    $task_user_id_temp = $task->user_id;
    $task_task_budy_temp = $task->task_budy;
    $task_priority_temp = $task->priority;
    $task_start_date_temp = $task->start_date;
    $task_due_date_temp = $task->due_date;

    $task->title = $data["title"];
    $task->description = $data["description"];
    $task->task_budy = $data["task_budy"] ? $data["task_budy"] : "-";
    $task->project_id = $data["project_id"];
    $task->user_id = $data["user_id"];
    $task->priority = $data["priority"];
    $task->start_date = $data["start_date"];
    $task->due_date = $data["due_date"];
    $task->trigger_update = $task->trigger_update == "ping" ? "pong" : "ping";
    DB::update($task);

    error_log($data["jo_code"]);


    $log = new Log;
    $log->user_id = $_SESSION["userid"];
    $log->search_code = $data["jo_code"];
    $log->show_to = $_SESSION["privileges"] == "Administrator" ? "*_" : "*";

    if($task_title_temp != $data["title"]){
        $log->log = $_SESSION["fname"] . " updated a task title from ".$task_title_temp." to <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $data["title"] . "</span>.";
        DB::save($log);
    }
    if($task_description_temp != $data["description"]){
        $log->log = $_SESSION["fname"] . " updated the description of task <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $data["title"] . "</span>.";
        DB::save($log);
    }
    if($task_project_id_temp != $data["project_id"]){
        if($data["project_name_old"] && $data["project_name_new"]){
            $log->log = $_SESSION["fname"] . " set the project of task <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $data["title"] . "</span> from ".$data["project_name_old"]." to ".$data["project_name_new"].".";
            DB::save($log);
        }
        if($data["project_name_old"] && !$data["project_name_new"]){
            $log->log = $_SESSION["fname"] . " remove the project of task <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $data["title"] . "</span>.";
            DB::save($log);
        }
        if(!$data["project_name_old"] && $data["project_name_new"]){
            $log->log = $_SESSION["fname"] . " set the project of task <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $data["title"] . "</span> to ".$data["project_name_new"].".";
            DB::save($log);
        }
    }

    if($task_user_id_temp != $data["user_id"]){
        if($data["assignee_old"] && $data["assignee_new"]){
            $log->log = $_SESSION["fname"] . " reassign the task <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $data["title"] . "</span> from <span class=\"task_log\" data-show-assignee=\"".$task_user_id_temp."\">" . $data["assignee_old"] . "</span> to <span class=\"task_log\" data-show-assignee=\"".$data["user_id"]."\">" . $data["assignee_new"] . "</span>.";
            DB::save($log);
        }
        if($data["assignee_old"] && !$data["assignee_new"]){
            $log->log = $_SESSION["fname"] . " remove the assignee of task <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $data["title"] . "</span>.";
            DB::save($log);
        }
        if(!$data["assignee_old"] && $data["assignee_new"]){
            $log->log = $_SESSION["fname"] . " assign the task <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $data["title"] . "</span> to <span class=\"task_log\" data-show-assignee=\"".$data["user_id"]."\">" . $data["assignee_new"] . "</span>.";
            DB::save($log);
        }
    }

    if($task_task_budy_temp != $data["task_budy"]){
        if($task_task_budy_temp != "-" && !$data["task_budy"]){
            $log->log = $_SESSION["fname"] . " remove the task buddies of task <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $data["title"] . "</span>.";
            DB::save($log);
        }else{
            if(count($data["task_budy_list"])){
                $log->log = $_SESSION["fname"] . " set ".task_map($data["task_budy_list"])." as task buddies of task <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $data["title"] . "</span>.";
                DB::save($log);    
            }
        }
    }
    if($task_start_date_temp != $data["start_date"]){
        $log->log = $_SESSION["fname"] . " updated the start date of task <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $data["title"] . "</span> from ".$task_start_date_temp." to ".$data["start_date"].".";
        DB::save($log);
    }
    if($task_due_date_temp != $data["due_date"]){
        $log->log = $_SESSION["fname"] . " updated the due date of task <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $data["title"] . "</span> from ".$task_due_date_temp." to ".$data["due_date"].".";
        DB::save($log);
    }
    if($task_priority_temp != $data["priority"]){
        $log->log = $_SESSION["fname"] . " set the priority level of task <span class=\"task_log\" data-show-task=\"".$data["id"]."\">" . $data["title"] . "</span> from <span class=\"stamp_log ".$task_priority_temp."\">".$task_priority_temp."</span> to <span class=\"stamp_log ".$data["priority"]."\">".$data["priority"]."</span>.";
        DB::save($log);
    }

    $response = [
        "status" => true,
        "type" => "success",
        "message" => "Task has been updated."
    ];

    echo json_encode($response);