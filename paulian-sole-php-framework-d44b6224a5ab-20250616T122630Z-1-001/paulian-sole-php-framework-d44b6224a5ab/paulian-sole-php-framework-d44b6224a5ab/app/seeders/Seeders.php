<?php
    Seed::$seeders = ["WifiInventoryUserSeeder"];

    class UserSeeder
    {
        public static function index(){
            for ($i=0; $i < 10; $i++) { 
                $faker = new Faker;
                Seed::table("user");
                Seed::insert([
                    "name" => $faker->name(),
                    "address" => $faker->address(),
                    "email" => $faker->email(),
                    "no" => $faker->no(),
                ]);
            }
        }
    }

    class WifiInventoryUserSeeder
    {
        public static function index(){
            Seed::table("user");
            Seed::insert([
                "name" => "Paul Ian Dumdum",
                "email" => "paulian.dumdum@gmail.com",
                "privileges" => "Administrator",
                "username" => "703F",
                "password" => "12345"
            ]);
        }
    }
?>