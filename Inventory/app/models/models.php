<?php

    class User
    {
        public $table = "user";
        public $fillable = [
            "name",
            "email",
            "privileges",
            "username",
            "password"
        ];
    }

    class Equipment
    {
        public $table = "equipment";
        public $fillable = [
            "uid",
            "name"
        ];
    }

    class Equipment_Entry
    {
        public $table = "equipment_entry";
        public $fillable = [
            "uid",
            "eid",
            "description",
            "model_no",
            "barcode",
            "specifications",
            "status",
            "remarks"
        ];
    }

    class IP_Network
    {
        public $table = "ip_network";
        public $fillable = [
            "uid",
            "rid",
            "name",
            "from",
            "to",
            "subnet"
        ];
    }

    class IP_Address
    {
        public $table = "ip_address";
        public $fillable = [
            "nid",
            "ip",
            "subnet",
            "hostname",
            "site",
            "server",
            "state",
            "status",
            "remarks",
            "webmgmtpt",
            "username",
            "password"
        ];
    }

    class Routers{
        public $table = "routers";
        public $fillable = [
            "uid",
            "name",
            "ip",
            "subnet",
            "wan1",
            "wan2",
            "active"
        ];
    }

    class ISP{
        public $table = "isp";
        public $fillable = [
            "uid",
            "isp_name",
            "name",
            "wan_ip",
            "subnet",
            "gateway",
            "dns1",
            "dns2",
            "webmgmtpt"
        ];
    }

    class Settings{
        public $table = "settings";
        public $fillable = [
            "uid",
            "sound",
            "theme",
        ];
    }

    class Logs{
        public $table = "logs";
        public $fillable = [
            "uid",
            "log",
        ];
    }

    class CCTV_Location{
        public $table = "cctv_location";
        public $fillable = [
            "uid",
            "map_location",
            "floorplan",
            "remarks",
            "camera_size",
        ];
    }

    class CCTV_Camera{
        public $table = "cctv_camera";
        public $fillable = [
            "uid",
            "lid",
            "camera_id",
            "camera_type",
            "camera_subtype",
            "camera_ip_address",
            "camera_port_no",
            "camera_username",
            "camera_password",
            "camera_angle",
            "camera_location",
            "camera_brand",
            "camera_model_no",
            "camera_barcode",
            "camera_status",
            "camera_remarks",
            "cx",
            "cy"
        ];
    }
?>