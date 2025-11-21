<?php
$id = $_GET['id'] ?? '';
if (!$id) {
    echo "Missing token.";
    exit;
}

// Replace with your UniFi controller IP and site name
$controller_ip = '192.168.15.220';
$site = 'default';

// Redirect to UniFi authorization endpoint
$redirect_url = "http://$controller_ip:8443/guest/s/$site/authorize?token=$id";
header("Location: $redirect_url");
exit;
?>