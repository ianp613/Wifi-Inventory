<?php

    class User
    {
        public $table = "pl_user";
        public $fillable = [
            "fname",
            "lname",
            "privileges",
            "status",
            "dept_id",
            "username",
            "password"
        ];

        public string $fname;
        public string $lname;
        public string $privileges;
        public string $status;
        public string $dept_id;
        public string $username;
        public string $password;
    }

    class Department
    {
        public $table = "pl_department";
        public $fillable = [
            "dept_name",
            "dept_color"
        ];

        public string $dept_name;
    }

    class Project
    {
        public $table = "pl_project";
        public $fillable = [
            "project_name",
            "color",
            "dept_id"
        ];

        public string $project_name;
        public string $color;
        public string $dept_id;
    }

    class Task
    {
        public $table = "pl_task";
        public $fillable = [
            "title",
            "description",
            "priority",
            "status",
            "rectify",
            "start_date",
            "due_date",
            "project_id",
            "user_id"
        ];

        public string $title;
        public string $description;
        public string $priority;
        public string $status;
        public string $rectify;
        public string $start_date;
        public string $due_date;
        public string $project_id;
        public string $user_id;
    }

    class ChecklistItem
    {
        public $table = "pl_checklist_item";
        public $fillable = [
            "task_id",
            "text",
            "is_done",
            "position"
        ];

        public string $task_id;
        public string $text;
        public string $is_done;
        public string $position;
    }

    class Attachment
    {
        public $table = "pl_attachment";
        public $fillable = [
            "task_id",
            "file_name",
            "file_path",
            "file_size",
            "mime_type",
        ];

        public string $task_id;
        public string $file_name;
        public string $file_path;
        public string $file_size;
        public string $mime_type;
    }

    class Comment
    {
        public $table = "pl_comment";
        public $fillable = [
            "task_id",
            "user_id",
            "comment_text"
        ];

        public string $task_id;
        public string $user_id;
        public string $comment_text;
    }

?>