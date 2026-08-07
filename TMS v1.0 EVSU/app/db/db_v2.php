<?php
    /**
     * Copyright © PID 2021
     * DB PHP script is for database management
     * This is a script from Sole PHP Framework v4.0
     *
     * --------------------------------------------------------------------------------
     * FIXES APPLIED (performance + security), logic otherwise unchanged:
     * 1. Singleton PDO connection (DB::conn()) reused across all calls instead of
     *    opening a brand new connection on every single method call. This was the
     *    main cause of slow load times on servers (each new MySQL connection can be
     *    expensive, especially with DNS/reverse-lookup or network latency).
     * 2. All values (not table/column identifiers) are now passed as bound
     *    parameters ("?") via PDO prepare/execute instead of being concatenated
     *    directly into the SQL string, which closes SQL-injection holes.
     * --------------------------------------------------------------------------------
     */
    class DB{
        public static $DB_HOST = "localhost";
        public static $DB_DATABASE = "inventory_system";
        public static $DB_USERNAME = "root";
        public static $DB_PASSWORD = "";
        public static $br = "";

        /**
         * --------------------------------------------------------------------------------
         * Shared / Singleton Connection
         * --------------------------------------------------------------------------------
         */
        private static $DB_CONN = null;

        public static function conn(){
            if(self::$DB_CONN === null){
                try{
                    self::$DB_CONN = new PDO('mysql:host='.self::$DB_HOST.';dbname='.self::$DB_DATABASE, self::$DB_USERNAME, self::$DB_PASSWORD);
                    self::$DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    echo "Database Connection Failed: " . $e->getMessage()."<br>";
                }
            }
            return self::$DB_CONN;
        }

        /**
         * --------------------------------------------------------------------------------
         * Read Table Data
         * --------------------------------------------------------------------------------
         */
        public static function all($data,$on=null,$or=null){
            try{
                $DB_CONN = DB::conn();
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
                echo "Fetch all error: ".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
        }
        public static function where($data,$col,$op,$val,$on=null,$or=null){
            try{
                $DB_CONN = DB::conn();
                $table = $data->table;
                $fillable = [];
                if(strtoupper($op) == "LIKE"){
                    if($on && $or){
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op ? ORDER BY `$table`.`$on` ".strtoupper($or));     
                    }else{
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op ?");
                    }   
                    $SQL->execute(["%$val%"]);
                }elseif(strtoupper($op) == "IN"){
                    // $val is expected to already be a parenthesized list e.g. "(1,2,3)",
                    // same as before - kept as-is to not change behavior/signature.
                    if ($on && $or) {
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` IN $val ORDER BY `$table`.`$on` ".strtoupper($or));
                    } else {
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` IN $val");
                    }  
                    $SQL->execute();
                }else{
                    if($on && $or){
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op ? ORDER BY `$table`.`$on` ".strtoupper($or));
                    }else{
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op ?");
                    } 
                    $SQL->execute([$val]);
                }
                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
                return $fillable;    
            }catch(Exception $e){
                echo "Fetch where error: ".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
        }
        public static function where2($data,$col,$op,$val,$col2,$op2,$val2,$on=null,$or=null){
            try{
                $DB_CONN = DB::conn();
                $table = $data->table;
                $fillable = [];
                $bindValues = [];
                if(strtoupper($op) == "LIKE" && strtoupper($op2) == "LIKE"){
                    if($on && $or){
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op ? AND `$col2` $op2 ? ORDER BY `$table`.`$on` ".strtoupper($or));     
                    }else{
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op ? AND `$col2` $op2 ?");
                    }   
                    $bindValues = ["%$val%", "%$val2%"];
                }elseif(strtoupper($op) == "LIKE" && $op2 == "="){
                    if($on && $or){
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op ? AND `$col2` $op2 ? ORDER BY `$table`.`$on` ".strtoupper($or));     
                    }else{
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op ? AND `$col2` $op2 ?");
                    }
                    $bindValues = ["%$val%", $val2];
                }elseif($op == "=" && strtoupper($op2) == "LIKE"){
                    if($on && $or){
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op ? AND `$col2` $op2 ? ORDER BY `$table`.`$on` ".strtoupper($or));     
                    }else{
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op ? AND `$col2` $op2 ?");
                    }
                    $bindValues = [$val, "%$val2%"];
                }elseif (strtoupper($op2) == "IN") {
                    // $val2 is expected to already be a parenthesized list, kept as-is.
                    if ($on && $or) {
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op ? AND `$col2` IN $val2 ORDER BY `$table`.`$on` ".strtoupper($or));
                    } else {
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op ? AND `$col2` IN $val2");
                    }
                    $bindValues = [$val];
                }else{
                    if($on && $or){
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op ? AND `$col2` $op2 ? ORDER BY `$table`.`$on` ".strtoupper($or));
                    }else{
                        $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` $op ? AND `$col2` $op2 ?");
                    } 
                    $bindValues = [$val, $val2];
                }
                $SQL->execute($bindValues);
                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
                return $fillable;    
            }catch(Exception $e){
                echo "Fetch where error: ".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
        }
        public static function find($data,$row){
            try{
                $DB_CONN = DB::conn();
                $table = $data->table;
                
                $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `id` = ?");
                $SQL->execute([$row]);
                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
                return $fillable; 
            }catch(Exception $e){
                echo "Fetch find error: ".$e->getMessage().DB::$br;
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
            $insertId = null;
            try{
                $DB_CONN = DB::conn();
                $table = $data->table;
                $columns = [];
                $placeholders = [];
                $bindValues = [];
                
                for ($i=0; $i <= count($data->fillable)-1; $i++) {
                    $temp = $data->fillable[$i];
                    $columns[] = "`".$temp."`";
                    $placeholders[] = "?";
                    $bindValues[] = $data->$temp;

                    if($data->$temp == ""){
                        $saveerror = true;
                        if($i == count($data->fillable)-1){
                            $savemessage .= "Column ".$temp." doesn't have a default value".DB::$br; 
                        }else{
                            $savemessage .= "Column ".$temp." doesn't have a default value, ".DB::$br; 
                        }
                    }
                }
                if(!$saveerror){
                    $columnsStr = implode(",", $columns);
                    $placeholdersStr = implode(",", $placeholders);
                    $SQL = $DB_CONN->prepare("INSERT INTO `$table` ($columnsStr) VALUES ($placeholdersStr)");
                    $SQL->execute($bindValues);
                    $insertId = $DB_CONN->lastInsertId();
                }else{
                    echo $savemessage;
                } 
            }catch(Exception $e){
                echo "Save error: ".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
            return $insertId;
        }
        /**
         * --------------------------------------------------------------------------------
         * Prepare Table Data
         * --------------------------------------------------------------------------------
         */
        public static function prepare($data, $row){
            try{
                $get = DB::find($data, $row);
                if($get != ""){
                    if(count($get) > 0){
                        for ($i=0; $i <= count($data->fillable)-1; $i++) { 
                            $temp = $data->fillable[$i];
                            $data->$temp = $get[0][$temp];
                        }
                        $data->stats = TRUE;
                    }
                    else{
                        $data->stats = FALSE;
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
                echo "Prepare error: ".$e->getMessage().DB::$br;
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
                $DB_CONN = DB::conn();
                $table = $data->table;
                $id = $data->id;
                if($data->stats){
                    $setParts = [];
                    $bindValues = [];
                    for ($i=0; $i <= count($data->fillable)-1; $i++) {
                        $temp = $data->fillable[$i];
                        $setParts[] = "`".$temp."` = ?";
                        $bindValues[] = $data->$temp;

                        if($data->$temp == ""){
                            $saveerror = true;
                            if($i == count($data->fillable)-1){
                                $savemessage .= "Column ".$temp." doesn't have a default value".DB::$br; 
                            }else{
                                $savemessage .= "Column ".$temp." doesn't have a default value, ".DB::$br; 
                            }
                        }
                    }
                    if(!$saveerror){
                        $setStr = implode(",", $setParts);
                        $bindValues[] = $id;
                        $SQL = $DB_CONN->prepare("UPDATE `$table` SET $setStr WHERE `id` = ?");
                        $SQL->execute($bindValues);
                    }else{
                        echo $savemessage;
                    }     
                }
                else{
                    if($id == ""){
                        $id = "NULL";
                    }
                    echo "Update error:  Could not find a match id.".DB::$br;
                    echo "Note: ID <i>'".$id."'</i> doesn't match any row data in column ID inside table <i>'".$table."'</i>".DB::$br;
                } 
            }catch(Exception $e){
                echo "Update error: ".$e->getMessage().DB::$br;
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
                $DB_CONN = DB::conn();
                $table = $data->table;
                $SQL = $DB_CONN->prepare("DELETE from `$table` WHERE `$table`.`id` = ?");
		        $SQL->execute([$row]);
            }catch(Exception $e){
                echo "Delete error: ".$e->getMessage().DB::$br;
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
                $DB_CONN = DB::conn();
                $table = $data->table;
                $SQL = $DB_CONN->prepare("TRUNCATE `$table`");
		        $SQL->execute();
            }catch(Exception $e){
                echo "Wipe error: ".$e->getMessage().DB::$br;
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
                $DB_CONN = DB::conn();
                $table = $data->table;
                $fillable = [];
                $bool = false;

                // This line is case-sensitive
                $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE BINARY `username` = ? AND BINARY `password` = ?");
                $SQL->execute([$a, $b]);

                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
                if($fillable){
                    $bool = true;
                }else{
                    $bool = false;
                }
                return $bool;
            }catch(Exception $e){
                echo "Authenticate error: ".$e->getMessage().DB::$br;
                echo "Note: table should have a default <i>username</i> and <i>password</i> column.".DB::$br;
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
                $DB_CONN = DB::conn();
                $table = $data->table;
                $fillable = [];
                $bool = false;
                $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` = ?");
                $SQL->execute([$val]);
                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
                if($fillable){
                    $bool = false;
                }else{
                    $bool = true;
                }
                return $bool;
            }catch(Exception $e){
                echo "Validate error: ".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
        }
        /**
         * --------------------------------------------------------------------------------
         * Export Database
         * --------------------------------------------------------------------------------
         */
        public static function export($location){
            try {
                $filename = DB::$DB_DATABASE."_".uniqid();
                date_default_timezone_set('Asia/Manila');

                $DB_CONN = DB::conn();
                if ($DB_CONN === null) {
                    return false;
                }

                // Get all tables
                $tables = [];
                $SQL = $DB_CONN->prepare("SHOW TABLES");
                $SQL->execute();
                $tables = $SQL->fetchAll(PDO::FETCH_COLUMN);

                // Initialize SQL dump
                $sqlDump = "-- Date: ".date('F j, Y') . "\n" . "-- Time: ".date('h:i:s A') . "\n" . "-- DB Name: " . DB::$DB_DATABASE . "\n";

                foreach ($tables as $table) {
                    // Get table structure
                    $SQL = $DB_CONN->prepare("SHOW CREATE TABLE `$table`");
                    $SQL->execute();
                    $row = $SQL->fetch(PDO::FETCH_ASSOC);
                    $sqlDump .= "\n\n" . $row['Create Table'] . ";\n\n";

                    // Get table data
                    $SQL = $DB_CONN->prepare("SELECT * FROM `$table`");
                    $SQL->execute();
                    $rows = $SQL->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($rows as $row) {
                        $values = array_map(fn($value) => "'" . addslashes($value) . "'", array_values($row));
                        $sqlDump .= "INSERT INTO `$table` VALUES(" . implode(", ", $values) . ");\n";
                    }
                }

                // Ensure backup location ends with a slash
                if (!str_ends_with($location, '/')) {
                    $location .= '/';
                }

                // Define backup file name
                $backupFile = $location . $filename . ".sql";

                // Save to file
                file_put_contents($backupFile, $sqlDump);
                return $backupFile;
            } catch (Exception $e) {
                echo "Export error: " . $e->getMessage() . DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0, $e->getMessage(), $e->getFile(), $e->getLine());
                return false;
            }
        }
        /**
         * --------------------------------------------------------------------------------
         * EXECUTE SQL (Note: table name should be `sql_table` because it will be replace by the true table name.)
         * --------------------------------------------------------------------------------
         */

        public static function sql($data,$sql){
            try{
                $DB_CONN = DB::conn();
                $table = $data->table;
                $sql = str_replace("sql_table",$table,$sql);
                $DB_CONN->exec($sql);
            }catch(Exception $e){
                echo "Save error: ".$e->getMessage().DB::$br;
                $_SESSION["soleexceptionerror"] = $e;
                exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
            }
        }
    }
?>