<?php
    include_once(seeders);
    class Seed{
        public static function index(){
            for ($i=0; $i < count(Seed::$seeders); $i++) {
                echo "\e[1;33;40mSeeding: " . Seed::$seeders[$i] ."\e[0m\n";
                Seed::$seeders[$i]::index();
                if(!Seed::$err){
                    echo "\e[1;32;40mDone\e[0m\n";
                }
            }
        }
        public static function table($t){
            Seed::$table = $t;
        }
        public static function insert($d){
            try{
                $DB_CONN = new PDO( 'mysql:host='.db_host.';dbname='.db_database,db_username,db_password);
                $DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo "\e[1;33;41mDatabase Connection Failed:\e[0m \e[1;33;40m". $e->getMessage()."\e[0m\n";
            }
            for ($i=0; $i < count(array_keys($d)); $i++) {
                if($i==count(array_keys($d))-1){
                    Seed::$attributes .= "`".array_keys($d)[$i]."`";
                    Seed::$values .= "'".$d[array_keys($d)[$i]]."'";
                }else{
                    Seed::$attributes .= "`".array_keys($d)[$i]."`,";
                    Seed::$values .= "'".$d[array_keys($d)[$i]]."',";
                }
            }
            try{
                $SQL = "INSERT INTO `".Seed::$table."` (".Seed::$attributes.") VALUES (".Seed::$values.")";
                $DB_CONN->exec($SQL);
                Seed::$attributes = "";
                Seed::$values = "";
                Seed::$err = false;
            }catch(PDOException $e){
                echo "\e[1;33;41mSeeding Failed: " . $e->getMessage()."\e[0m\n";
                Seed::$err = true;
            }
        }
        public static $seeders = [];
        public static $table = "";
        public static $attributes = "";
        public static $values = "";
        public static $err = false;
    }
?>