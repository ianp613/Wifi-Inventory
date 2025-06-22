<?php
    include_once(migrations);
    class Migrate{
        public static $stat = false;
        public static function index(){
            for ($i=0; $i < count(Migrate::$migration); $i++) { 
                Migrate::$migration[$i]::index();
                Migrate::id();
                Migrate::timestamp();
                Migrate::commit();
            }
            if(Migrate::$stat){
                echo "\e[1;32;40mNothing to migrate.\e[0m\n\e[1;33;41mNote:\e[0m \e[1;33;40mto migrate to remaining tables, please remove the model's class name that has already been migrated from the migration array.\e[0m";
            }
        }
        public static function commit(){
            try{
                try{
                    $DB_CONN = new PDO( 'mysql:host='.db_host.';dbname='.db_database,db_username,db_password);
                    $DB_CONN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }catch(PDOException $e){
                    echo "\e[1;33;41mDatabase Connection Failed:\e[0m \e[1;33;40m". $e->getMessage()."\e[0m\n";
                }
                $SEARCH = false;
                $SQL = $DB_CONN->prepare("SHOW TABLES");
                $SQL->execute();
                $fillable = $SQL->fetchAll(PDO::FETCH_ASSOC);
                foreach($fillable as $a){
                    if($a["Tables_in_".db_database] == "migrations"){
                        $SEARCH = true;
                    }
                }
                if(!$SEARCH){
                    try{
                        $MIGRATION_TABLE = "migrations";
                        $MIGRATION_BLUEPRINT = "`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT, `migration` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL";
                        $SQL = "CREATE TABLE `".db_database."`.`$MIGRATION_TABLE` ($MIGRATION_BLUEPRINT , PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                        $DB_CONN->exec($SQL);
                    }catch(PDOException $e){
                        echo "\e[1;33;41mMigration Failed: " . $e->getMessage()."\e[0m\n";
                    }
                }
                $TABLE = Migrate::$table;
                $BLUEPRINT = Migrate::$attribute;
                $SQL = "CREATE TABLE `".db_database."`.`$TABLE` ($BLUEPRINT) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
                $DB_CONN->exec($SQL);
                $DATE = new DateTime();
                $VALUES = $DATE->format('Y')."_".$DATE->format('d')."_".$DATE->format('m')."_".$DATE->format('u')."_".Migrate::$table;
                $SQL = "INSERT INTO `migrations` (`migration`) VALUES ('$VALUES')";
                $DB_CONN->exec($SQL);
                Migrate::$attribute = "";
                Migrate::$table = "";
                
                echo("\e[1;32;40mMigrated\e[0m: \e[1;33;40m".$TABLE."\e[0m\n");
            }catch(PDOException $e){
                Migrate::$stat = true;
            }
        }
        public static function attrib_table($name){
            Migrate::$table = $name;
        }
        public static function attrib_string($num){
            Migrate::$string = $num;
        }
        public static function id(){
            Migrate::$attribute = "`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT ".Migrate::$attribute;
        }
        public static function timestamp(){
            Migrate::$attribute .= " , `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)";
        }
        public static function string($name){
            Migrate::$attribute .= " , `".$name."` VARCHAR(".Migrate::$string.") COLLATE utf8mb4_unicode_ci NOT NULL ";
        }
        public static function date($name){
            Migrate::$attribute .= " , `".$name."` DATETIME NOT NULL";
        }
        public static $migration = [];
        public static $attribute = "";
        public static $table = "";
        public static $string = 255;
    }
?>