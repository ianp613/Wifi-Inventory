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
