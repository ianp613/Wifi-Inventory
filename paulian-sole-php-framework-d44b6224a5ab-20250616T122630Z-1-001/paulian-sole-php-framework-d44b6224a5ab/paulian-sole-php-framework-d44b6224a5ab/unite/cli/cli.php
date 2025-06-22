<?php
    class CLI{
        public static $reserve = ["migrate","seed","auto","makecontroller","data","logs","db","exportdb","makedb","makemigration","makemodel","makeseeder","soleexception","route","routeextend","session","request","sole","unite"];
        public static function index(){
            if($_SERVER["argc"] >= 2){
                # FRAMEWORK
                $ENV = json_decode(file_get_contents(basedir."../.env.json"));
                if($_SERVER["argv"][1] == "framework"){
                    echo "\e[1;32;40mFramework Name:\e[0m  \e[1;33;40m".$ENV->FRAMEWORK->name."\e[0m\n";
                    echo "\e[1;32;40mFramework Version:\e[0m  \e[1;33;40m".$ENV->FRAMEWORK->version."\e[0m\n";
                    echo "\e[1;32;40mFramework Developer:\e[0m  \e[1;33;40m".$ENV->FRAMEWORK->developer."\e[0m\n";
                    echo "\e[1;32;40mRequired PHP Version:\e[0m  \e[1;33;40m".$ENV->FRAMEWORK->required_php_version."\e[0m\n";
                    echo "\e[1;32;40mCurrent PHP Version:\e[0m \e[1;33;40m".phpversion()."\e[0m";
                }
                # CHAIN
                elseif($_SERVER["argv"][1] == "chain"){
                    Chain::index();
                }
                # CONTROLLER
                elseif($_SERVER["argv"][1] == "make:controller"){
                    if($_SERVER["argc"] > 2){
                        if(!in_array(strtolower($_SERVER["argv"][2]),CLI::$reserve)){
                            MakeController::index($_SERVER["argv"][2]);
                        }else{
                            echo("\e[1;33;40mYou can't use ".$_SERVER["argv"][2]." as controller name."."\e[0m");
                        }
                    }else{
                        echo("\e[1;33;40mPlease state controller name."."\e[0m");
                    }
                }
                # MAKE DATABASE
                elseif($_SERVER["argv"][1] == "make:database"){
                    if($_SERVER["argc"] > 2){
                        if(!in_array(strtolower($_SERVER["argv"][2]),CLI::$reserve)){
                            MakeDB::index($_SERVER["argv"][2]);
                        }else{
                            echo("\e[1;33;40mYou can't use ".$_SERVER["argv"][2]." as database name."."\e[0m");
                        }
                    }else{
                        echo("\e[1;33;40mPlease state database name."."\e[0m");
                    }
                }
                # EXPORT DATABASE
                elseif($_SERVER["argv"][1] == "export:database"){
                    if(!in_array(db_database,CLI::$reserve)){
                        ExportDB::index();
                    }else{
                        echo "\e[1;33;40mPlease configure database name to your project database name.\e[0m";
                    } 
                }
                # MAKE MIGRATION
                elseif($_SERVER["argv"][1] == "make:migration"){
                    if($_SERVER["argc"] > 2){
                        if(!in_array(strtolower($_SERVER["argv"][2]),CLI::$reserve)){
                            MakeMigration::index($_SERVER["argv"][2]);
                        }else{
                            echo("\e[1;33;40mYou can't use ".$_SERVER["argv"][2]." as migration name."."\e[0m");
                        }
                    }else{
                        echo("\e[1;33;40mPlease state migration name."."\e[0m");
                    }
                }
                # MIGRATE DATABASE
                elseif($_SERVER["argv"][1] == "migrate:database"){
                    Migrate::index();
                }
                # MAKE MODEL
                elseif($_SERVER["argv"][1] == "make:model"){
                    if($_SERVER["argc"] > 2){
                        if(!in_array(strtolower($_SERVER["argv"][2]),CLI::$reserve)){
                            MakeModel::index($_SERVER["argv"][2]);
                        }else{
                            echo("\e[1;33;40mYou can't use ".$_SERVER["argv"][2]." as model name."."\e[0m");
                        }
                    }else{
                        echo("\e[1;33;40mPlease state model name."."\e[0m");
                    }
                }
                # MAKE SEEDER
                elseif($_SERVER["argv"][1] == "make:seeder"){
                    if($_SERVER["argc"] > 2){
                        if(!in_array(strtolower($_SERVER["argv"][2]),CLI::$reserve)){
                            MakeSeeder::index($_SERVER["argv"][2]);
                        }else{
                            echo("\e[1;33;40mYou can't use ".$_SERVER["argv"][2]." as seeder name."."\e[0m");
                        }
                    }else{
                        echo("\e[1;33;40mPlease state seeder name."."\e[0m");
                    }
                }
                # SEED DATABASE
                elseif($_SERVER["argv"][1] == "seed:database"){
                    Seed::index();
                }
                # SELF DESTRUCT
                elseif($_SERVER["argv"][1] == "self:destruct"){
                    echo "\e[1;33;41mWarning:\e[0m \e[1;33;40mThis will destroy the framework, and this will also delete your project.\e[0m\n";
                    echo "\e[1;33;41mWarning:\e[0m \e[1;33;40mThis can't be undone, if you wish to proceed type framework password...\e[0m\n";
                    echo "\e[1;33;41mPassword:\e[0m ";
                    $input = readline();
                    if(md5($input) == "beb7f7a395dc21ad97425bbc061afbaf"){
                        echo "\e[1;32;40mInformation:\e[0m \e[1;33;40mPassword match. Press any key to continue...\e[0m\n";
                        exec("pause");
                        SelfDestruct::index();
                    }
                    else{
                        echo "\e[1;32;40mInformation:\e[0m \e[1;33;40mPassword did not match, self destruct failed.\e[0m";
                    }
                }
                # UNRECOGNIZED COMMAND
                else{
                    echo "\e[1;31;40m'".$_SERVER["argv"][1]."' is not recognized as a valid command for sole php framework command line interface.\e[0m";
                }
            }else{
                echo "\e[1;33;40mYou can use the following cli command."."\e[0m\n";
                echo "\e[1;33;40m------------------------------------------------------------------------"."\e[0m\n";
                $cli = json_decode(file_get_contents(basedir."cli\cli.command.json"));
                foreach($cli->commands as $command){
                    echo "\e[1;32;40mCommand: $command"."\e[0m\n";
                    echo "\e[1;33;40mDescription: ".$cli->descriptions->$command."\e[0m\n";
                }
            }
        }
    }
    CLI::index();