<?php
    include("includes.php");
    session_start();

    // $user = new User;
    // $user->name = "Administrator";
    // $user->daily_task = "N/A";
    // $user->privileges = "user";
    // $user->username = "administrator";
    // $user->password = "CmoS23826867";
    // DB::save($user);

    // $tms_location = new TMSLocation;
    // $tms_location->description = "DDC Main Building";
    // $tms_location->latitude = "11.178118504120517";
    // $tms_location->longitude = "125.00095206864282";
    // $tms_location->radius = "40";
    // DB::save($tms_location);

    // $tms_location = new TMSLocation;
    // $tms_location->description = "DDC Annex Building";
    // $tms_location->latitude = "11.178555370945066";
    // $tms_location->longitude = "125.00021813862105";
    // $tms_location->radius = "30";
    // DB::save($tms_location);

    header("location: views/login.php");
?>