<?php
    class SoleException extends Exception{}
    function exception_handler($errNo, $errMessage, $errFile, $errLine){
        $_SESSION["soleexceptionerror"] = [$errNo,$errMessage,$errFile,$errLine];
        $_SESSION["soleexceptionserver"] = $_SERVER;
        $_SESSION["soleexceptionstatus"] = true;
        $self = explode("/",$_SERVER["PHP_SELF"]);
        if(end($self) == "index.php"){
            $ENV = json_decode(file_get_contents(".env.json"));
            if($ENV->SETTINGS->deploy){
                Route::error($ENV->SETTINGS->error_view);
            }else{
                header("location: unite/exception/error");
            }
        }else{
            $ENV = json_decode(file_get_contents("../../.env.json"));
            if($ENV->SETTINGS->deploy){
                Route::error($ENV->SETTINGS->error_view);
            }else{
                header("location: ../../unite/exception/error");
            }
        }
    }
    set_error_handler('exception_handler');
?>