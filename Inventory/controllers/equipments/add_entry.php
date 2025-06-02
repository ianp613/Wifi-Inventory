<?php
    header('Content-Type: application/json');
    include("../../includes.php");
    $data = json_decode(file_get_contents('php://input'), true);

    if($data) {
        $entry = new Equipment_Entry;
        
        $entry->eid = $data["eid"];
        $entry->description = $data["description"];
        $entry->model_no = $data["model_no"] ? strtoupper($data["model_no"]) : "-";
        $entry->barcode = $data["barcode"] ? strtoupper($data["barcode"]) : "-";
        $entry->specifications = $data["specifications"] ? $data["specifications"] : "-";
        $entry->status = $data["status"] ? $data["status"] : "N/A";
        $entry->remarks = $data["remarks"] ? $data["remarks"] : "-";

        DB::save($entry);

        $response = [
            "status" => true,
            "type" => "success",
            "size" => null,
            "message" => "Entry has been saved.",
            "entry" => DB::all($entry)
        ];
    }else{
        $response = [
            "status" => false,
            "type" => "warning",
            "size" => null,
            "message" => "Something went wrong."
        ];
    }
    echo json_encode($response);
?>