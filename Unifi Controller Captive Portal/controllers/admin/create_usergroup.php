<?php
include("../../includes.php");
header('Content-Type: application/json');

// Load input data
$data = json_decode(file_get_contents('php://input'), true);

$name = "captive_" . $data["ugname"];
$download_limit = (int)$data["ugdownload_limit"] * 1024; // kbps
$upload_limit   = (int)$data["ugupload_limit"] * 1024;   // kbps

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

// Step 2: Add new user group (name only)
$newGroup = json_encode([
    "name" => $name
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/s/$siteId/add/usergroup");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $newGroup);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$addResponse = curl_exec($ch);
curl_close($ch);

$addData = json_decode($addResponse, true);
if (!isset($addData['data'][0]['_id'])) {
    echo json_encode(['status' => false, 'error' => 'Failed to create user group', 'response' => $addResponse]);
    exit;
}

$groupId = $addData['data'][0]['_id'];

// Step 3: Update user group with limits
$updateGroup = json_encode([
    "name" => $name,
    "qos_rate_max_down" => $download_limit,
    "qos_rate_max_up"   => $upload_limit
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/s/$siteId/upd/usergroup/$groupId");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $updateGroup);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$updateResponse = curl_exec($ch);
curl_close($ch);

echo json_encode([
    'status' => true,
    'created_group' => $addData['data'][0],
    'updated_group' => json_decode($updateResponse, true)
]);
