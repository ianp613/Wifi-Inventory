<?php

    class Interprepter{
        public static $count = 0;
        public static $table = [
            
        ];
        public static function solve($message = null){
            if($message){
                $message = explode(" ",$message);
                $this->$count = count($message);
                return $message;
            }else{
                return false;
            }
        }
    }

?>