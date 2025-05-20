<?php

    class User
    {
        public $table = "user";
        public $fillable = [
            "name",
            "username",
            "password"
        ];
    }

    class Equipment
    {
        public $table = "equipment";
        public $fillable = [
            "name"
        ];
    }

    class Equipment_Entry
    {
        public $table = "equipment_entry";
        public $fillable = [
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
            "name",
            "ip",
            "subnet",
            "wan1",
            "wan2"
        ];
    }

    class ISP{
        public $table = "isp";
        public $fillable = [
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

?>