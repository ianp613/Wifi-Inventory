<?php
    Migrate::$migration = [
        "UserMigration"
    ];

    class UserMigration
    {
        public static function index(){
            Migrate::attrib_table("user");
            Migrate::attrib_string(1000);
            Migrate::string("name");
            Migrate::string("email");
            Migrate::string("privileges");
            Migrate::string("c_authority");
            Migrate::string("passkey");
            Migrate::string("username");
            Migrate::string("password");
        }
    }

?>