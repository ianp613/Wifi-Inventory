<?php
    session_start();
    $_SESSION["auth"] = false;
    $_SESSION["userid"] = null;
    header("location: views/login.php");
?>