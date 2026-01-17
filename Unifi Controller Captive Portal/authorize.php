<?php
$id = $_GET['id'] ?? '';
if (!$id) {
    echo "Missing token.";
    exit;
}

// Replace with your UniFi controller IP and site name
$conf = json_decode(file_get_contents("../conf.json"));
$controllerUrl = 'https://'.$conf->Unifi->Server.':'.$conf->Unifi->Port.'';
$site = $conf->Unifi->Site_ID;

// Redirect to UniFi authorization endpoint
$redirect_url = "http://".$conf->Unifi->Server.":".$conf->Unifi->Port."/guest/s/$site/authorize?token=$id";
header("Location: $redirect_url");
exit;
?>