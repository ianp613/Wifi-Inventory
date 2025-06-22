<?php
    # SOLE PHP FRAMEWORK VERSION 6.0
    # Copyright © PID 2021
    
    session_start();
    $SOLE_BASEDIR = dirname(__FILE__).DIRECTORY_SEPARATOR;
    $ENV = json_decode(file_get_contents($SOLE_BASEDIR."../.env.json"));

    define('log',$ENV->SETTINGS->app_log);
    define('log_show',$ENV->SETTINGS->app_log_show);
    define("basedir",$SOLE_BASEDIR);
    define("unite",$SOLE_BASEDIR."sole.php");
    define("framework_name",$ENV->FRAMEWORK->name);
    define("framework_version",$ENV->FRAMEWORK->version);
    define("framework_developer",$ENV->FRAMEWORK->developer);
    define("db_host",$ENV->DATABASE->db_host);
    define("db_database",$ENV->DATABASE->db_database);
    define("db_username",$ENV->DATABASE->db_username);
    define("db_password",$ENV->DATABASE->db_password);

    define("migrations",$SOLE_BASEDIR."../app/migrations/Migrations.php");
    define("models",$SOLE_BASEDIR."../app/models/Models.php");
    define("seeders",$SOLE_BASEDIR."../app/seeders/Seeders.php");

    define("controllers",$SOLE_BASEDIR."../app/controllers/");
    define("views",$SOLE_BASEDIR."../resources/views");
    define("errors",$SOLE_BASEDIR."../resources/temp/error");

    include models;

    include $SOLE_BASEDIR."controller/make_controller.php";
    include $SOLE_BASEDIR."data/data.php";
    include $SOLE_BASEDIR."database/db.php";
    include $SOLE_BASEDIR."database/export.php";
    include $SOLE_BASEDIR."database/migrate.php";
    include $SOLE_BASEDIR."database/seed.php";
    include $SOLE_BASEDIR."database/make_database.php";
    include $SOLE_BASEDIR."database/make_migration.php";
    include $SOLE_BASEDIR."database/make_model.php";
    include $SOLE_BASEDIR."database/make_seeder.php";
    include $SOLE_BASEDIR."extensions/extensions.php";
    include $SOLE_BASEDIR."file handler/file.php";
    include $SOLE_BASEDIR."session/session.php";
    include $SOLE_BASEDIR."chain/chain.php";
    include $SOLE_BASEDIR."chain/disc.php";
    include $SOLE_BASEDIR."self destruct/self destruct.php";

    if(!array_key_exists("argv",$_SERVER)){
        include $SOLE_BASEDIR."auto/auto.php";
        include $SOLE_BASEDIR."exception/exception.php";
        include $SOLE_BASEDIR."router/router.php";
        include $SOLE_BASEDIR."data/log.php";
    }else{
        include $SOLE_BASEDIR."cli/cli.php";
    }