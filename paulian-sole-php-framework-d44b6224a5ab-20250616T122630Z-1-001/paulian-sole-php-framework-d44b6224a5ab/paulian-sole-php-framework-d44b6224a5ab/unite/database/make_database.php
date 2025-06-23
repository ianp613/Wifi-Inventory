<?php
    class MakeDB{
        public static function index($database){
            if(strtolower($database) != "sole_db"){
                try{ 
                    $DB_CONN = new PDO( 'mysql:host='.db_host.';',db_username,db_password);
                    $DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $SEARCH = false;
                    $SQL = $DB_CONN->prepare("SHOW DATABASES");
                    $SQL->execute();
                    $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
                    foreach($fillable as $a){
                        if($database == $a["Database"]){
                            $SEARCH = TRUE;
                        }
                    }
                    if(!$SEARCH){
                        $DB_CONN = new PDO( 'mysql:host='.db_host.';',db_username,db_password);
                        $DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $SQL = $DB_CONN->prepare("CREATE DATABASE `$database`");
                        $SQL->execute();
                        echo("\e[1;32;40mDatabase ".$database." created successfully.\e[0m");
                    }else{
                        echo("\e[1;33;40mDatabase ".$database." already exist.\e[0m");
                    }
                }catch(PDOException $e){
                    echo("\e[1;33;41mDatabase Connection Failed:\e[0m \e[1;33;40m".$e->getMessage()."\e[0m");
                }    
            }else{
                echo("\e[1;33;41mYou can't use $database as database name.\e[0m\n");
            }
        }
    }
?>