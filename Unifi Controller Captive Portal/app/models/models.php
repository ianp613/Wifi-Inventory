<?php

    class Client
    {
        public $table = "client";
        public $fillable = [
            "name",
            "mac",
            "time",
        ];
    }

    class Voucher
    {
        public $table = "voucher";
        public $fillable = [
            "name",
            "code",
            "expiration",
            "exp_type",
            "upv"
        ];
    }

    class Authentication
    {
        public $table = "authentication";
        public $fillable = [
            "cid",
            "target",
            "type",
            "vid"
        ];
    }

    class UPV
    {
        public $table = "upv";
        public $fillable = [
            "cid",
            "vid",
            "count"
        ];
    }

    class Lockout
    {
        public $table = "lockout";
        public $fillable = [
            "mac",
            "attempt",
            "time"
        ];
    }
?>