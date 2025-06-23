<?php
    Seed::$seeders = ["UserSeeder"];

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
?>