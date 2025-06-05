<?php
    session_start();
    $_SESSION["auth"] = false;
    $_SESSION["userid"] = null;
    $_SESSION["privileges"] = null;
    $_SESSION["code"] = null;
    $_SESSION["mail_username"] = 'paulian.dumdum@gmail.com';
    $_SESSION["mail_password"] = 'ytrr qwdo kqox vdre';
    header("location: views/login.php");
?>