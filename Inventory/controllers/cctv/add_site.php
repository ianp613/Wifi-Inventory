<?php
    session_start();
    header('Content-Type: application/json');
    include("../../includes.php");

    try {
        $file = $_FILES["file"];
        $fileName = basename($file["name"]);
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $filePath = "../../assets/img/maps/" . uniqid() . "." . $extension;
        
        if(move_uploaded_file($file["tmp_name"], $filePath)) {
            $cctv_location = new CCTV_Location;
            $cctv_location->uid = $_POST["uid"];
            $cctv_location->map_location = $_POST["map_location"];
            $cctv_location->floorplan = $filePath;
            $cctv_location->remarks = $_POST["map_remarks"] ? $_POST["map_remarks"] : "-";
            $cctv_location->camera_size = "25";
            DB::save($cctv_location);

            $response = [
                "status" => true,
                "type" => "success",
                "size" => null,
                "cctvs" => DB::all($cctv_location),
                "message" => "Map has been added."
            ];

        } else {
            $response = [
                "status" => false,
                "type" => "error",
                "size" => null,
                "cctvs" => DB::all($cctv_location),
                "message" => "Something went wrong, please try again."
            ];
        }
        echo json_encode($response);
    } catch (\Throwable $th) {
        $response = [
            "status" => false,
            "type" => "error",
            "size" => null,
            "message" => "Add map error."
        ];     
    }