<?php
    foreach($ENV->EXTENSIONS as $E){
        if(is_file($SOLE_BASEDIR."../extensions/".$E."/".$E.".php")){
            include $SOLE_BASEDIR."../extensions/".$E."/".$E.".php";
        }
    }
?>