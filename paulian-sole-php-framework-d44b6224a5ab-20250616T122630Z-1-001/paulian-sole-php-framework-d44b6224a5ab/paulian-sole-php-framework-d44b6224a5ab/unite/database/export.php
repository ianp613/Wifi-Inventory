<?php
    class ExportDB{
        public static function index(){
            try{
                $DateTime = new DateTime;
                $date = date("M d, Y",strtotime((string) $DateTime->format('Y-m-d h:i:s'))).' at '.date("h:i A",strtotime((string) $DateTime->format('Y-m-d h:i:s')));
                $sqlScript = "-- ".framework_name." SQL Dump\n";
                $sqlScript .= "-- Framework Version: ".framework_version."\n";
                $sqlScript .= "--\n";
                $sqlScript .= "-- Host: ".db_host."\n";
                $sqlScript .= "-- Generation Time: $date\n";
                $sqlScript .= "-- PHP Version: ".phpversion()."\n";
                $sqlScript .= "\n";
                $sqlScript .= 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";'."\n";
                $sqlScript .= 'START TRANSACTION;'."\n";
                $sqlScript .= 'SET time_zone = "+00:00";'."\n";
                $sqlScript .= "\n";
                $sqlScript .= "--\n";
                $sqlScript .= "-- Database `".db_database."`\n";
                $sqlScript .= "--\n";
                $sqlScript .= "\n";
                $sqlScript .= "-- --------------------------------------------------------\n";
                $sqlScript .= "\n";
                
                $CONN = mysqli_connect(db_host,db_username,db_password,db_database);
                $CONN->set_charset("utf8");
                # get all table names from database
                $tables = array();
                $sql = "SHOW TABLES";
                $result = mysqli_query($CONN,$sql);

                while($row = mysqli_fetch_row($result)){
                    $tables[] = $row[0];
                }
                foreach($tables as $table){
                    #prepare sqlscript for creating table structure
                    $query = "SHOW CREATE TABLE $table";
                    $result = mysqli_query($CONN,$query);
                    $row = mysqli_fetch_row($result);
                    $sqlScript .= "--\n";
                    $sqlScript .= "-- Table structure for table `$table`\n";
                    $sqlScript .= "--\n";
                    $sqlScript .= "\n".$row[1].";\n\n";
                    #prepare sqlscript for dumping data for each table
                    $query = "SELECT * FROM $table";
                    $result = mysqli_query($CONN,$query);
                    $columnCount = mysqli_num_fields($result);
                    $sqlScript .= "--\n";
                    $sqlScript .= "-- Dumping data for table `$table`\n";
                    $sqlScript .= "--\n";
                    $sqlScript .= "\n";
                    for ($i=0; $i < $columnCount; $i++) { 
                        while ($row = mysqli_fetch_row($result)) {
                            $sqlScript .= "INSERT INTO $table VALUES(";
                            for($j=0; $j < $columnCount; $j++){
                                $row[$j] = $row[$j];
                                if(isset($row[$j])){
                                    $sqlScript .= '"'. $row[$j] . '"';
                                }else{
                                    $sqlScript .= '""';
                                }
                                if($j < ($columnCount - 1)){
                                    $sqlScript .= ',';
                                }
                            }
                            $sqlScript .= ");\n";
                        }
                    }
                    $sqlScript .= "\n";
                    $sqlScript .= "-- --------------------------------------------------------\n";
                }
                if(file_exists("resources/temp/sql/")){
                    file_put_contents("resources/temp/sql/".db_database.".sql",$sqlScript);
                    echo("\e[1;32;40mDatabase Exported To\e[0m: \e[1;33;40mresources/temp/sql/".db_database.".sql\e[0m");
                }else{
                    mkdir("resources/temp/sql/");
                    ExportDB::index();
                }
            }catch(Throwable $e){
                echo("\e[1;33;41mExport Database Error:\e[0m \e[1;33;40m".$e->getMessage()."\e[0m");
            }
        }
    }
?>