<?php
    include("includes.php");
    session_start();
    !array_key_exists("userid",$_SESSION) ?  $_SESSION["userid"] = null : null; 
    if($_SESSION["userid"]){
        if(array_key_exists("inactivity",$_GET)){
            if($_GET["inactivity"] == "true"){
                $log = new Logs;
                $log->uid = $_SESSION["userid"];
                $log->log = $_SESSION["name"]." has been logged out from the system due to inactivity.";
                DB::save($log);
            }
        }else{
            $log = new Logs;
            $log->uid = $_SESSION["userid"];
            $log->log = $_SESSION["name"]." has logged out from the system.";
            DB::save($log);
        }    
    }
        
    $_SESSION["auth"] = false;
    $_SESSION["name"] = null;
    $_SESSION["privileges"] = null;
    $_SESSION["code"] = null;
    $_SESSION["log"] = null;
    $_SESSION["log1"] = null;
    $_SESSION["log2"] = null;
    $_SESSION["log3"] = null;
    $_SESSION["log4"] = null;
    $_SESSION["mail_username"] = 'paulian.dumdum@gmail.com';
    $_SESSION["mail_password"] = 'ytrr qwdo kqox vdre';

    header("location: views/login.php");
?>