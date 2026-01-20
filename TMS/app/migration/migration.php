<?php
    Migrate::$migration = [
        "UserMigration",
        "DailyUserInfoMigration",
        "TaskMigration",
        "RemakrMigration",
        "NotificationMigration",
        "TMSLocationMigration"
    ];

    class UserMigration
    {
        public static function index(){
            Migrate::attrib_table("user");
            Migrate::attrib_string(1000);
            Migrate::string("name");
            Migrate::string("privileges");
            Migrate::string("daily_task");
            Migrate::string("username");
            Migrate::string("password");
        }
    }

    class DailyUserInfoMigration
    {
        public static function index(){
            Migrate::attrib_table("dailyuserinfo");
            Migrate::attrib_string(1000);
            Migrate::string("uid");
            Migrate::string("daily_task");
            Migrate::string("daily_task_status");
            Migrate::string("tms_time_in_datetime");
            Migrate::string("tms_time_out_datetime");
            Migrate::string("tms_time_in_location");
            Migrate::string("tms_time_in_img");
        }
    }

    class TaskMigration
    {
        public static function index(){
            Migrate::attrib_table("task");
            Migrate::attrib_string(1000);
            Migrate::string("uid");
            Migrate::string("description");
            Migrate::string("note");
            Migrate::string("status");
            Migrate::string("deadline");
            Migrate::string("buddies");
        }
    }

    class RemakrMigration
    {
        public static function index(){
            Migrate::attrib_table("remark");
            Migrate::attrib_string(1000);
            Migrate::string("uid");
            Migrate::string("tid");
            Migrate::string("type");
            Migrate::string("content");
        }
    }

    class NotificationMigration
    {
        public static function index(){
            Migrate::attrib_table("notification");
            Migrate::attrib_string(1000);
            Migrate::string("uid");
            Migrate::string("description");
            Migrate::string("read");
        }
    }

    class TMSLocationMigration
    {
        public static function index(){
            Migrate::attrib_table("tms_location");
            Migrate::attrib_string(1000);
            Migrate::string("description");
            Migrate::string("latitude");
            Migrate::string("longitude");
            Migrate::string("radius");
        }
    }
?>