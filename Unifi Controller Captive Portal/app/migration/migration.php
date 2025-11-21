<?php
    Migrate::$migration = [
        "UserMigration",
        "ClientMigration",
        "VoucherMigration",
        "Authentication",
        "UPV"
    ];

    class UserMigration
    {
        public static function index(){
            Migrate::attrib_table("user");
            Migrate::attrib_string(1000);
            Migrate::string("name");
            Migrate::string("username");
            Migrate::string("password");
        }
    }

    class ClientMigration
    {
        public static function index(){
            Migrate::attrib_table("client");
            Migrate::attrib_string(1000);
            Migrate::string("name");
            Migrate::string("mac");
            Migrate::string("time");
        }
    }

    class VoucherMigration
    {
        public static function index(){
            Migrate::attrib_table("voucher");
            Migrate::attrib_string(1000);
            Migrate::string("name");
            Migrate::string("code");
            Migrate::string("expiration");
            Migrate::string("exp_type");
            Migrate::string("upv");
            Migrate::string("download_limit");
            Migrate::string("upload_limit");
            Migrate::string("data_limit");
        }
    }

    class Authentication
    {
        public static function index(){
            Migrate::attrib_table("authentication");
            Migrate::attrib_string(1000);
            Migrate::string("cid");
            Migrate::string("target");
            Migrate::string("type");
            Migrate::string("vid");
        }
    }

    class UPV   
    {
        public static function index(){
            Migrate::attrib_table("upv");
            Migrate::attrib_string(1000);
            Migrate::string("cid");
            Migrate::string("vid");
            Migrate::string("count");
        }
    }

    
?>