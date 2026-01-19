<?php

    class User
    {
        public $table = "user";
        public $fillable = [
            "name",
            "privileges",
            "daily_task",
            "username",
            "password",
        ];
    }

    class DailyUserInfo
    {
        public $table = "dailyuserinfo";
        public $fillable = [
            "uid",
            "daily_task",
            "daily_task_status",
            "tms_time_in_datetime",
            "tms_time_out_datetime",
            "tms_time_in_location",
            "tms_time_in_img",
        ];
    }

    class Task
    {
        public $table = "task";
        public $fillable = [
            "uid",
            "description",
            "status",
            "buddies",
        ];
    }

    class Remark{
        public $table = "remark";
        public $fillable = [
            "uid",
            "tid",
            "type",
            "content",
        ];
    }

    class Notification
    {
        public $table = "notification";
        public $fillable = [
            "uid",
            "description",
            "read",
        ];
    }

    class TMSLocation
    {
        public $table = "tms_location";
        public $fillable = [
            "description",
            "latitude",
            "longitude",
            "radius",
        ];
    }
?>