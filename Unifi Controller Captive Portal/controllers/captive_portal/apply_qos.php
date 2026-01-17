<?php
include("../../includes.php");
header('Content-Type: application/json');

// Load input data
$data = json_decode(file_get_contents('php://input'), true);

// Load configuration
$conf = json_decode(file_get_contents("../../conf.json"));
$controllerUrl = 'https://'.$conf->Unifi->Server.':'.$conf->Unifi->Port.'';
$siteId = $conf->Unifi->Site_ID;
$username = $conf->Unifi->Username;
$password = $conf->Unifi->Password;
$mac = strtolower(trim($data['mac'] ?? ''));

// Validate MAC address
if (!preg_match('/^([0-9a-f]{2}:){5}[0-9a-f]{2}$/', $mac)) {
    echo json_encode(['error' => 'Invalid MAC address']);
    exit;
}

$downLimit = $conf->Unifi->Open->Download_Limit * 1024;
$upLimit   = $conf->Unifi->Open->Upload_Limit * 1024;
$dataLimit = $conf->Unifi->Open->Data_Limit * 1048576;

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
    echo json_encode(['error' => 'Login failed', 'response' => $loginResponse]);
    exit;
}

// Step 2: Apply QoS limits
$qosData = json_encode([
    "cmd" => "set-client-qos",
    "mac" => $mac,
    "up" => $upLimit,
    "down" => $downLimit,
    "bytes" => $dataLimit
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/s/$siteId/cmd/stamgr");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $qosData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$qosResponse = curl_exec($ch);
curl_close($ch);

// Step 3: Get list of connected clients
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/s/$siteId/stat/sta");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$staResponse = curl_exec($ch);
curl_close($ch);

$clients = json_decode($staResponse, true)['data'] ?? [];
$clientOnline = false;
foreach ($clients as $client) {
    if (strtolower($client['mac']) === $mac) {
        $clientOnline = true;
        break;
    }
}

// Final output
echo json_encode([
    'statuss' => true,
    'qos_applied' => json_decode($qosResponse, true),
    'client_connected' => $clientOnline,
    'clients' => $clients
]);
