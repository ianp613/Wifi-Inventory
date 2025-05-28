<?php
    session_start();
    $_SESSION["auth"] = false;
    $_SESSION["userid"] = null;
    $_SESSION["code"] = null;
    header("location: views/login.php");
?>