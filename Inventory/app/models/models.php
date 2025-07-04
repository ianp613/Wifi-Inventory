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
        public $ignore = [
            "id",
            "uid"
        ];
        public $main = "name";
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
        public $ignore = [
            "uid",
            "eid",
            "at",
            "tio",
            "ti",
            "io",
            "on",
            "ion"
        ];
        public $main = "description";
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
        public $ignore = [
            "id",
            "uid",
            "rid",
            "ne",
            "net",
            "et",
            "me"
        ];
        public $main = "name";
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
        public $ignore = [
            "id",
            "nid",
            "er",
            "se",
            "ser",
            "name",
            "na",
            "am",
            "me",
            "nam",
            "ame",
            "te",
        ];
        public $main = "hostname";
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
        public $ignore = [
            "id",
            "uid",
            "wan",
            "wa",
            "an",
            "me"
        ];
        public $main = "name";
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
        public $ignore = [
            "id",
            "uid",
            "name",
            "na",
            "am",
            "me",
            "nam",
            "ame",
            "dns",
            "dn",
            "ns",
            "isp",
            "is",
            "sp"
        ];
        public $main = "name";
    }

    class Settings{
        public $table = "settings";
        public $fillable = [
            "uid",
            "sound",
            "theme",
        ];
        public $ignore = [
            "id",
            "uid"
        ];
    }

    class Logs{
        public $table = "logs";
        public $fillable = [
            "uid",
            "log"
        ];
        public $ignore = [
            "id",
            "uid"
        ];
        public $main = "log";
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
        public $ignore = [
            "id",
            "uid",
            "lo",
            "ma",
            "map",
            "ma",
            "ap",
            "me"
        ];
        public $main = "map_location";
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
        public $ignore = [
            "id",
            "uid",
            "lid",
            "camera",
            "ca",
            "am",
            "me",
            "er",
            "ra",
            "cam",
            "ame",
            "mer",
            "era",
            "pe",
            "ty",
            "yp",
            "ar"
        ];
        public $main = "camera_id";
    }
?>