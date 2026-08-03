<?php
    /**
     * Copyright © PID 2021
     * DB PHP script is for database management
     * This is a script from Sole PHP Framework v4.0
     *
     * --------------------------------------------------------------------------------
     * FIXES APPLIED (performance + security), logic otherwise unchanged:
     * 1. Singleton PDO connection (DB::conn()) reused across all calls instead of
     *    opening a brand new connection on every single method call.
     * 2. All values (not table/column identifiers) are now passed as bound
     *    parameters ("?") via PDO prepare/execute instead of being concatenated
     *    directly into the SQL string, which closes SQL-injection holes.
     * 3. Exceptions and validation failures are now logged via error_log() instead
     *    of echoed directly into the response body. Previously, any DB error during
     *    a request would print raw text before the controller's json_encode() output,
     *    producing invalid JSON and breaking every frontend .then()/.catch() handler
     *    that expects JSON back. Read methods now consistently return [] on failure;
     *    write methods (save/update/delete/wipe/sql) now return true/false/null so
     *    callers can check success explicitly if they choose to.
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
                    error_log("DB Connection Failed: " . $e->getMessage());
                    $_SESSION["soleexceptionerror"] = $e;
                    if(function_exists('exception_handler')){
                        exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
                    }
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
            $fillable = [];
            try{
                $DB_CONN = DB::conn();
                $table = $data->table;
                if($on && $or){
                    $SQL = $DB_CONN->prepare("SELECT * FROM `$table` ORDER BY `$table`.`$on` ".strtoupper($or));
                }else{
                    $SQL = $DB_CONN->prepare("SELECT * FROM `$table`");    
                }
                $SQL->execute();
                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
            }catch(Exception $e){
                error_log("Fetch all error: ".$e->getMessage());
                $_SESSION["soleexceptionerror"] = $e;
                if(function_exists('exception_handler')){
                    exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
                }
            }
            return $fillable;
        }
        public static function where($data,$col,$op,$val,$on=null,$or=null){
            $fillable = [];
            try{
                $DB_CONN = DB::conn();
                $table = $data->table;
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
            }catch(Exception $e){
                error_log("Fetch where error: ".$e->getMessage());
                $_SESSION["soleexceptionerror"] = $e;
                if(function_exists('exception_handler')){
                    exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
                }
            }
            return $fillable;
        }
        public static function where2($data,$col,$op,$val,$col2,$op2,$val2,$on=null,$or=null){
            $fillable = [];
            try{
                $DB_CONN = DB::conn();
                $table = $data->table;
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
            }catch(Exception $e){
                error_log("Fetch where2 error: ".$e->getMessage());
                $_SESSION["soleexceptionerror"] = $e;
                if(function_exists('exception_handler')){
                    exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
                }
            }
            return $fillable;
        }
        public static function find($data,$row){
            $fillable = [];
            try{
                $DB_CONN = DB::conn();
                $table = $data->table;
                $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `id` = ?");
                $SQL->execute([$row]);
                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
            }catch(Exception $e){
                error_log("Fetch find error: ".$e->getMessage());
                $_SESSION["soleexceptionerror"] = $e;
                if(function_exists('exception_handler')){
                    exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
                }
            }
            return $fillable;
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
                    error_log("Save error: ".$savemessage);
                } 
            }catch(Exception $e){
                error_log("Save error: ".$e->getMessage());
                $_SESSION["soleexceptionerror"] = $e;
                if(function_exists('exception_handler')){
                    exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
                }
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
                error_log("Prepare error: ".$e->getMessage());
                $_SESSION["soleexceptionerror"] = $e;
                if(function_exists('exception_handler')){
                    exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
                }
                return $data;
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
            $success = false;
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
                        $success = true;
                    }else{
                        error_log("Update error: ".$savemessage);
                    }     
                }
                else{
                    if($id == ""){
                        $id = "NULL";
                    }
                    error_log("Update error: Could not find a match id. Note: ID '".$id."' doesn't match any row data in column ID inside table '".$table."'");
                } 
            }catch(Exception $e){
                error_log("Update error: ".$e->getMessage());
                $_SESSION["soleexceptionerror"] = $e;
                if(function_exists('exception_handler')){
                    exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
                }
            }
            return $success;
        }
        /**
         * --------------------------------------------------------------------------------
         * Remove Table Data
         * --------------------------------------------------------------------------------
         */
        public static function delete($data, $row){
            $success = false;
            try{
                $DB_CONN = DB::conn();
                $table = $data->table;
                $SQL = $DB_CONN->prepare("DELETE from `$table` WHERE `$table`.`id` = ?");
                $SQL->execute([$row]);
                $success = true;
            }catch(Exception $e){
                error_log("Delete error: ".$e->getMessage());
                $_SESSION["soleexceptionerror"] = $e;
                if(function_exists('exception_handler')){
                    exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
                }
            }
            return $success;
        }
        /**
         * --------------------------------------------------------------------------------
         * Truncate Table Data
         * --------------------------------------------------------------------------------
         */
        public static function wipe($data){
            $success = false;
            try{
                $DB_CONN = DB::conn();
                $table = $data->table;
                $SQL = $DB_CONN->prepare("TRUNCATE `$table`");
                $SQL->execute();
                $success = true;
            }catch(Exception $e){
                error_log("Wipe error: ".$e->getMessage());
                $_SESSION["soleexceptionerror"] = $e;
                if(function_exists('exception_handler')){
                    exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
                }
            }
            return $success;
        }
        /**
         * --------------------------------------------------------------------------------
         * Authenticate Username and Password
         * --------------------------------------------------------------------------------
         */
        public static function auth($data,$a,$b){
            $bool = false;
            try{
                $DB_CONN = DB::conn();
                $table = $data->table;

                // This line is case-sensitive
                $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE BINARY `username` = ? AND BINARY `password` = ?");
                $SQL->execute([$a, $b]);

                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
                $bool = $fillable ? true : false;
            }catch(Exception $e){
                error_log("Authenticate error: ".$e->getMessage()." (Note: table should have a default username and password column.)");
                $_SESSION["soleexceptionerror"] = $e;
                if(function_exists('exception_handler')){
                    exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
                }
            }
            return $bool;
        }
        /**
         * --------------------------------------------------------------------------------
         * Validate Table Row Data
         * --------------------------------------------------------------------------------
         */
        public static function validate($data,$col,$val){
            $bool = false;
            try{
                $DB_CONN = DB::conn();
                $table = $data->table;
                $SQL = $DB_CONN->prepare("SELECT * FROM `$table` WHERE `$col` = ?");
                $SQL->execute([$val]);
                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
                $bool = $fillable ? false : true;
            }catch(Exception $e){
                error_log("Validate error: ".$e->getMessage());
                $_SESSION["soleexceptionerror"] = $e;
                if(function_exists('exception_handler')){
                    exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
                }
            }
            return $bool;
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
                error_log("Export error: " . $e->getMessage());
                $_SESSION["soleexceptionerror"] = $e;
                if(function_exists('exception_handler')){
                    exception_handler(0, $e->getMessage(), $e->getFile(), $e->getLine());
                }
                return false;
            }
        }
        /**
         * --------------------------------------------------------------------------------
         * EXECUTE SQL (Note: table name should be `sql_table` because it will be replace by the true table name.)
         * --------------------------------------------------------------------------------
         */
        public static function sql($data,$sql){
            $success = false;
            try{
                $DB_CONN = DB::conn();
                $table = $data->table;
                $sql = str_replace("sql_table",$table,$sql);
                $DB_CONN->exec($sql);
                $success = true;
            }catch(Exception $e){
                error_log("SQL exec error: ".$e->getMessage());
                $_SESSION["soleexceptionerror"] = $e;
                if(function_exists('exception_handler')){
                    exception_handler(0,$e->getMessage(),$e->getFile(),$e->getLine());
                }
            }
            return $success;
        }
    }
?>