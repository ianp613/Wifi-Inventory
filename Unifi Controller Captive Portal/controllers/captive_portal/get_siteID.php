<?php
    $conf = json_decode(file_get_contents("../../conf.json"));
    $siteId = $conf->Unifi->Site_ID;
    echo json_encode($siteId);
?>