<?php
    /**
     * Copyright © PID 2021
     * DB PHP script is for database management
     * This is a script from Sole PHP Framework v4.0
     */
    class DB{
        public static $DB_HOST = "localhost";
        public static $DB_DATABASE = "wifi_inventory";
        public static $DB_USERNAME = "root";
        public static $DB_PASSWORD = "";
        /**
         * --------------------------------------------------------------------------------
         * Read Table Data
         * --------------------------------------------------------------------------------
         */
        public static function all($data,$on=null,$or=null){
            try{
                try{
                    $DB_CONN = new PDO( 'mysql:host='.DB::$DB_HOST.';dbname='.DB::$DB_DATABASE, DB::$DB_USERNAME, DB::$DB_PASSWORD);
                    $DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    echo "<b>Database Connection Failed: </b>" . $e->getMessage()."<br>";
                }
                $table = $data->table;
                $fillable = [];
                if($on && $or){
                    $SQL = $DB_CONN->prepare("SELECT * FROM `$table` ORDER BY `$table`.`$on` ".strtoupper($or));
                }else{
                    $SQL = $DB_CONN->prepare("SELECT * FROM `$table`");    
                }
                $SQL->execute();
                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
                return $fillable;    
            }catch(Exception $e){
                echo "<b>Fetch all error: </b>".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
        }
        public static function where($data,$col,$op,$val,$on=null,$or=null){
            try{
                try{
                    $DB_CONN = new PDO( 'mysql:host='.DB::$DB_HOST.';dbname='.DB::$DB_DATABASE, DB::$DB_USERNAME, DB::$DB_PASSWORD);
                    $DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    echo "<b>Database Connection Failed: </b>" . $e->getMessage()."<br>";
                }
                $table = $data->table;
                $fillable = [];
                if(strtoupper($op) == "LIKE"){
                    if($on && $or){
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op '%$val%' ORDER BY `$table`.`$on` ".strtoupper($or));     
                    }else{
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op '%$val%'");
                    }   
                }else{
                    if($on && $or){
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op '$val' ORDER BY `$table`.`$on` ".strtoupper($or));
                    }else{
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op '$val'");
                    } 
                }
                $SQL->execute();
                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
                return $fillable;    
            }catch(Exception $e){
                echo "<b>Fetch where error: </b>".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
        }
        public static function find($data,$row){
            try{
                try{
                    $DB_CONN = new PDO( 'mysql:host='.DB::$DB_HOST.';dbname='.DB::$DB_DATABASE, DB::$DB_USERNAME, DB::$DB_PASSWORD);
                    $DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    echo "<b>Database Connection Failed: </b>" . $e->getMessage()."<br>";
                }
                $table = $data->table;
                
                $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `id` = '$row'");
                $SQL->execute();
                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
                return $fillable; 
            }catch(Exception $e){
                echo "<b>Fetch find error: </b>".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }

        }
        /**
         * --------------------------------------------------------------------------------
         * Create Table Data
         * --------------------------------------------------------------------------------
         */
        public static function save($data){
            $saveerror = false;
            $savemessage = "";
            try{
                try{
                    $DB_CONN = new PDO( 'mysql:host='.DB::$DB_HOST.';dbname='.DB::$DB_DATABASE, DB::$DB_USERNAME, DB::$DB_PASSWORD);
                    $DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    echo "<b>Database Connection Failed: </b>" . $e->getMessage()."<br>";
                }
                $fillable = [];
                $table = $data->table;
                $columns = "";
                $values = "";
                $temp = "";
                
                for ($i=0; $i <= count($data->fillable)-1; $i++) { 
                    if($i == count($data->fillable)-1){
                        $columns .= "`".$data->fillable[$i]."`";
                        $temp = $data->fillable[$i];
                        $values .= "'".$data->$temp."'";
                        if($data->$temp == ""){
                            $saveerror = true;
                            $savemessage .= "Column ".$data->fillable[$i]." doesn't have a default value".DB::$br; 
                        }
                    }else{
                        $columns .= "`".$data->fillable[$i]."`,";
                        $temp = $data->fillable[$i];
                        $values .= "'".$data->$temp."',";
                        if($data->$temp == ""){
                            $saveerror = true;
                            $savemessage .= "Column ".$data->fillable[$i]." doesn't have a default value, ".DB::$br; 
                        }
                    }
                }
                if(!$saveerror){
                    $SQL = "INSERT INTO `$table` ($columns) VALUES ($values)";
                    $DB_CONN->exec($SQL);
                }else{
                    echo $savemessage;
                } 
            }catch(Exception $e){
                echo "<b>Save error: </b>".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
        }
        /**
         * --------------------------------------------------------------------------------
         * Prepare Table Data
         * --------------------------------------------------------------------------------
         */
        public static function prepare($data, $row){
            try{
                try{
                    $DB_CONN = new PDO( 'mysql:host='.DB::$DB_HOST.';dbname='.DB::$DB_DATABASE, DB::$DB_USERNAME, DB::$DB_PASSWORD);
                    $DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    echo "<b>Database Connection Failed: </b>" . $e->getMessage()."<br>";
                }
                $get = DB::find($data, $row);
                if($get != ""){
                    if(count($get) > 0){
                        for ($i=0; $i <= count($data->fillable)-1; $i++) { 
                            $temp = $data->fillable[$i];
                            $data->$temp = $get[0][$temp];
                        }
                        $data->status = TRUE;
                    }
                    else{
                        $data->status = FALSE;
                    }
                    $data->id = $row;
                    return $data;
                }else{
                    for ($i=0; $i <= count($data->fillable)-1; $i++) { 
                        $temp = $data->fillable[$i];
                        $data->$temp = "";
                    }
                    $data->id = $row;
                    return $data;  
                }
            }catch(Exception $e){
                echo "<b>Prepare error: </b>".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
        }
        /**
         * --------------------------------------------------------------------------------
         * Update Table Data
         * --------------------------------------------------------------------------------
         */
        public static function update($data){
            $saveerror = false;
            $savemessage = "";
            try{
                try{
                    $DB_CONN = new PDO( 'mysql:host='.DB::$DB_HOST.';dbname='.DB::$DB_DATABASE, DB::$DB_USERNAME, DB::$DB_PASSWORD);
                    $DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    echo "<b>Database Connection Failed: </b>" . $e->getMessage()."<br>";
                }
                $table = $data->table;
                $id = $data->id;
                $set = "";
                if($data->status){
                    for ($i=0; $i <= count($data->fillable)-1; $i++) { 
                        if($i == count($data->fillable)-1){
                            $temp = $data->fillable[$i];
                            $set .= "`".$data->fillable[$i]."`"." = "."'".$data->$temp."'";
                            if($data->$temp == ""){
                                $saveerror = true;
                                $savemessage .= "Column ".$data->fillable[$i]." doesn't have a default value".DB::$br; 
                            }
                        }else{
                            $temp = $data->fillable[$i];
                            $set .= "`".$data->fillable[$i]."`"." = "."'".$data->$temp."',"; 
                            if($data->$temp == ""){
                                $saveerror = true;
                                $savemessage .= "Column ".$data->fillable[$i]." doesn't have a default value, ".DB::$br; 
                            }
                        }
                    }
                    if(!$saveerror){
                        $SQL = "UPDATE `$table` SET $set WHERE `id` = '$id'";
                        $DB_CONN->exec($SQL);
                    }else{
                        echo $savemessage;
                    }     
                }
                else{
                    if($id == ""){
                        $id = "NULL";
                    }
                    echo "<b>Update error: </b> Could not find a match id.".DB::$br;
                    echo "<b>Note: </b>ID <i><b>'".$id."'</b></i> doesn't match any row data in column ID inside table <i><b>'".$table."'</i></b>".DB::$br;
                } 
            }catch(Exception $e){
                echo "<b>Update error: </b>".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
        }
        /**
         * --------------------------------------------------------------------------------
         * Remove Table Data
         * --------------------------------------------------------------------------------
         */
        public static function delete($data, $row){
            try{
                try{
                    $DB_CONN = new PDO( 'mysql:host='.DB::$DB_HOST.';dbname='.DB::$DB_DATABASE, DB::$DB_USERNAME, DB::$DB_PASSWORD);
                    $DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    echo "<b>Database Connection Failed: </b>" . $e->getMessage()."<br>";
                }
                $table = $data->table;
                $id = $row;
                $SQL = $DB_CONN->prepare("DELETE from `$table` WHERE `$table`.`id`='$id'");
		        $SQL->execute();
            }catch(Exception $e){
                echo "<b>Delete error: </b>".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
        }
        /**
         * --------------------------------------------------------------------------------
         * Truncate Table Data
         * --------------------------------------------------------------------------------
         */
        public static function wipe($data){
            try{
                try{
                    $DB_CONN = new PDO( 'mysql:host='.DB::$DB_HOST.';dbname='.DB::$DB_DATABASE, DB::$DB_USERNAME, DB::$DB_PASSWORD);
                    $DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    echo "<b>Database Connection Failed: </b>" . $e->getMessage()."<br>";
                }
                $table = $data->table;
                $SQL = $DB_CONN->prepare("TRUNCATE `$table`");
		        $SQL->execute();
            }catch(Exception $e){
                echo "<b>Wipe error: </b>".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
        }
        /**
         * --------------------------------------------------------------------------------
         * Authenticate Username and Password
         * --------------------------------------------------------------------------------
         */
        public static function auth($data,$a,$b){
            try{
                try{
                    $DB_CONN = new PDO( 'mysql:host='.DB::$DB_HOST.';dbname='.DB::$DB_DATABASE, DB::$DB_USERNAME, DB::$DB_PASSWORD);
                    $DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    echo "<b>Database Connection Failed: </b>" . $e->getMessage()."<br>";
                }
                $table = $data->table;
                $fillable = [];
                $bool = false;
                $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `username` = '$a' AND `password` = '$b'");
                $SQL->execute();
                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
                if($fillable){
                    $bool = true;
                }else{
                    $bool = false;
                }
                return $bool;
            }catch(Exception $e){
                echo "<b>Authenticate error: </b>".$e->getMessage().DB::$br;
                echo "<b>Note: </b>table should have a default <i>username</i> and <i>password</i> column.".DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
        }
        /**
         * --------------------------------------------------------------------------------
         * Validate Table Row Data
         * --------------------------------------------------------------------------------
         */
        public static function validate($data,$col,$val){
            try{
                try{
                    $DB_CONN = new PDO( 'mysql:host='.DB::$DB_HOST.';dbname='.DB::$DB_DATABASE, DB::$DB_USERNAME, DB::$DB_PASSWORD);
                    $DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    echo "<b>Database Connection Failed: </b>" . $e->getMessage()."<br>";
                }
                $table = $data->table;
                $fillable = [];
                $bool = false;
                $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` = '$val'");
                $SQL->execute();
                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
                if($fillable){
                    $bool = false;
                }else{
                    $bool = true;
                }
                return $bool;
            }catch(Exception $e){
                echo "<b>Validate error: </b>".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
        }
        public static $br = "</br>";
    }
?>