<?php
    header('Content-Type: application/json');
    session_start();
    include("../../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data) {
        $remark = new Remark;
        $remarks = DB::where($remark,"tid","=",$data["id"]);
        
        foreach ($remarks as $rem) {
            DB::delete($remark,$rem["id"]);
        }

        $task = new Task;

        $task_ = DB::find($task,$data["id"]);

        $files = explode("+++",$task_[0]["attachment"] != "-" ? $task_[0]["attachment"] : "");
        array_shift($files);

        $dir = "../../../assets/uploads/task_file_attachments/";

        foreach ($files as $file) {
            $file_ = explode("==",$file);
            if(file_exists($dir.$file_[1])){
                unlink($dir.$file_[1]);
            }
        }

        DB::delete($task,$data["id"]);

        $response = [
            "status" => false,
            "type" => "success",
            "message" => "Task has been deleted.",
            "data" => $data
        ];
    }
    echo json_encode($response);
?>
