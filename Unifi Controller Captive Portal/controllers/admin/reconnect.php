<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

// Configuration
$controllerUrl = 'https://192.168.15.220:8443';
$conf = json_decode(file_get_contents("../../conf.json"));
$siteId = $conf->Unifi->Site_ID;
$username = $conf->Unifi->Username;
$password = $conf->Unifi->Password;
$mac = strtolower(trim($data['mac'] ?? ''));

// Validate MAC
if (!preg_match('/^([0-9a-f]{2}:){5}[0-9a-f]{2}$/', $mac)) {
    echo json_encode(['error' => 'Invalid MAC address']);
    exit;
}

// Step 1: Login
$loginData = json_encode([
    'username' => $username,
    'password' => $password
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $loginData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'unifi_cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, 'unifi_cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$loginResponse = curl_exec($ch);
curl_close($ch);

if (!$loginResponse || strpos($loginResponse, '"rc":"ok"') === false) {
    echo json_encode(['error' => 'Login failed', 'response' => $loginResponse]);
    exit;
}

// Step 2: Kick the client (disconnect only)
$kickData = json_encode([
    'cmd' => 'kick-sta',
    'mac' => $mac
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/s/$siteId/cmd/stamgr");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $kickData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_COOKIEFILE, 'unifi_cookie.txt');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$kickResponse = curl_exec($ch);
curl_close($ch);

// Output
echo json_encode([
    'disconnected' => $kickResponse
]);
?>