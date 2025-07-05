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
        public $label = [
            "uid:" => "UID:",
            "name:" => "Name:"
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
        public $label = [
            "uid:" => "UID:",
            "eid:" => "EID:",
            "description:" => "Description:",
            "model_no:" => "Model No.:",
            "barcode:" => "Barcode:",
            "specifications:" => "Specifications:",
            "status:" => "Status:",
            "remarks:" => "Remarks:"
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
        public $label = [
            "uid:" => "UID:",
            "rid:" => "RID:",
            "name:" => "Name:",
            "from:" => "IP from:",
            "to:" => "IP to:",
            "subnet:" => "Subnet:"
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
        public $label = [
            "nid:" => "NID:",
            "ip:" => "IP:",
            "subnet:" => "Subnet:",
            "hostname:" => "Hostname:",
            "site:" => "Site:",
            "server:" => "Server:",
            "state:" => "State:",
            "status:" => "Status:",
            "remarks:" => "Remarks:",
            "webmgmtpt:" => "Web Mgmt Port:",
            "username:" => "Username:",
            "password:" => "Password:"
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
        public $label = [
            "uid:" => "UID:",
            "name:" => "Name:",
            "ip:" => "IP:",
            "subnet:" => "Subnet:",
            "wan1:" => "WAN 1:",
            "wan2:" => "WAN 2:",
            "active:" => "Active WAN:",
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
        public $label = [
            "uid:" => "UID:",
            "isp_name:" => "ISP Name:",
            "name:" => "Name:",
            "wan_ip:" => "WAN IP:",
            "subnet:" => "Subnet:",
            "gateway:" => "Gateway:",
            "dns1:" => "DNS 1:",
            "dns2:" => "DNS 2:",
            "webmgmtpt:" => "Web Mgmt Port:",
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
        public $label = [
            "uid:" => "UID:",
            "map_location:" => "Location:",
            "floorplan:" => "Floorplan:",
            "remarks:" => "Remarks:",
            "camera_size:" => "Camera Size(px):",
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
        public $label = [
            "uid:" => "UID:",
            "lid:" => "LID:",
            "camera_id:" => "Name:",
            "camera_type:" => "Type:",
            "camera_subtype:" => "Subtype:",
            "camera_ip_address:" => "IP:",
            "camera_port_no:" => "Port No:",
            "camera_username:" => "Username:",
            "camera_password:" => "Password:",
            "camera_angle:" => "Angle(°deg):",
            "camera_location:" => "Location:",
            "camera_brand:" => "Brand:",
            "camera_model_no:" => "Model No.:",
            "camera_barcode:" => "Barcode:",
            "camera_status:" => "Status:",
            "camera_remarks:" => "Remarks:",
            "cx:" => "CX:",
            "cy:" => "CY:",
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