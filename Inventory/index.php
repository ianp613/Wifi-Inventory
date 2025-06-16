<?php
    include("includes.php");
    session_start();
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
    $_SESSION["userid"] ? null : $_SESSION["userid"] = null;
    $_SESSION["name"] = null;
    $_SESSION["privileges"] = null;
    $_SESSION["code"] = null;
    $_SESSION["log"] = null;
    $_SESSION["mail_username"] = 'paulian.dumdum@gmail.com';
    $_SESSION["mail_password"] = 'ytrr qwdo kqox vdre';

    header("location: views/login.php");
?>