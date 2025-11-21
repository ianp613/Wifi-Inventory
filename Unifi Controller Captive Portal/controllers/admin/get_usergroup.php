<?php
include("../../includes.php");
header('Content-Type: application/json');

// Load configuration
$conf = json_decode(file_get_contents("../../conf.json"));
$controllerUrl = 'https://192.168.15.220:8443';
$siteId = $conf->Unifi->Site_ID;
$username = $conf->Unifi->Username;
$password = $conf->Unifi->Password;

// Cookie file
$cookieFile = __DIR__ . "/unifi_cookie.txt";

// Step 1: Login
$loginData = json_encode([
    "username" => $username,
    "password" => $password
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $loginData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$loginResponse = curl_exec($ch);
curl_close($ch);

if (!$loginResponse || strpos($loginResponse, '"rc":"ok"') === false) {
    echo json_encode(['status' => false, 'error' => 'Login failed', 'response' => $loginResponse]);
    exit;
}

// Step 2: Get user groups
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/s/$siteId/list/usergroup");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$userGroupsResponse = curl_exec($ch);
curl_close($ch);

$userGroups = json_decode($userGroupsResponse, true);

// Final output
echo json_encode([
    'status' => true,
    'user_groups' => $userGroups
]);
