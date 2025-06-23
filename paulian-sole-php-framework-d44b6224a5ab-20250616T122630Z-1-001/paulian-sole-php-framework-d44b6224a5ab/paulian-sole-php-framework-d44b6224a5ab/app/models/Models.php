<?php
    $models = ["User"];

    class User
    {
        public $table = "user";
        public $fillable = [
            "name",
            "username",
            "password"
        ];
    }
?>