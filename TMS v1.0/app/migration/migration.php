<?php
    Migrate::$migration = [
        "UserMigration",
        "DepartmentMigration",
        "ProjectMigration",
        "TaskMigration",
        "ChecklistItemMigration",
        "AttachmentMigration",
        "CommentMigration",
        "ActivityLogMigration",
        "NotificationMigration"
    ];

    class UserMigration
    {
        public static function index(){
            Migrate::attrib_table("pl_user");
            Migrate::attrib_string(1000);
            Migrate::string("fname");
            Migrate::string("lname");
            Migrate::string("privileges");
            Migrate::string("status");
            Migrate::string("dept_id");
            Migrate::string("username");
            Migrate::string("password");
        }
    }

    class DepartmentMigration
    {
        public static function index(){
            Migrate::attrib_table("pl_department");
            Migrate::attrib_string(1000);
            Migrate::string("dept_name");
            Migrate::string("dept_color");
        }
    }

    class ProjectMigration
    {
        public static function index(){
            Migrate::attrib_table("pl_project");
            Migrate::attrib_string(1000);
            Migrate::string("project_name");
            Migrate::string("color");
            Migrate::string("dept_id");
        }
    }

    class TaskMigration
    {
        public static function index(){
            Migrate::attrib_table("pl_task");
            Migrate::attrib_string(1000);
            Migrate::string("title");
            Migrate::string("description");
            Migrate::string("priority");
            Migrate::string("status");
            Migrate::string("task_budy");
            Migrate::string("rectify");
            Migrate::string("start_date");
            Migrate::string("due_date");
            Migrate::string("completed_at");
            Migrate::string("project_id");
            Migrate::string("user_id"); //Team Member
            Migrate::string("created_by");
        }
    }

    class ChecklistItemMigration
    {
        public static function index(){
            Migrate::attrib_table("pl_checklist_item");
            Migrate::attrib_string(1000);
            Migrate::string("task_id");
            Migrate::string("text");
            Migrate::string("is_done");
            Migrate::string("position");
        }
    }

    class AttachmentMigration
    {
        public static function index(){
            Migrate::attrib_table("pl_attachment");
            Migrate::attrib_string(1000);
            Migrate::string("task_id");
            Migrate::string("file_name");
            Migrate::string("file_path");
            Migrate::string("file_size");
            Migrate::string("mime_type");
            Migrate::string("uploaded_by");
        }
    }

    class CommentMigration
    {
        public static function index(){
            Migrate::attrib_table("pl_comment");
            Migrate::attrib_string(1000);
            Migrate::string("task_id");
            Migrate::string("user_id");
            Migrate::string("comment_text");
        }
    }

    // class ActivityLogMigration
    // {
    //     public static function index(){
    //         Migrate::attrib_table("pl_activity_log");
    //         Migrate::attrib_string(1000);
    //         Migrate::string("task_id");
    //         Migrate::string("user_id");
    //         Migrate::string("action");
    //         Migrate::string("field_name");
    //         Migrate::string("old_value");
    //         Migrate::string("new_value");
    //         Migrate::string("created_at");
    //     }
    // }

    // class NotificationMigration
    // {
    //     public static function index(){
    //         Migrate::attrib_table("pl_notification");
    //         Migrate::attrib_string(1000);
    //         Migrate::string("user_id");
    //         Migrate::string("task_id");
    //         Migrate::string("type");
    //         Migrate::string("message");
    //         Migrate::string("is_read");
    //         Migrate::string("created_at");
    //     }
    // }

?>