<?php

    class User
    {
        public $table = "user";
        public $fillable = [
            "name",
            "email",
            "privileges",
            "c_authority",
            "passkey",
            "username",
            "password"
        ];

        public string $name;
        public string $email;
        public string $privileges;
        public string $passkey;
        public string $username;
        public string $password;
    }
    
?>