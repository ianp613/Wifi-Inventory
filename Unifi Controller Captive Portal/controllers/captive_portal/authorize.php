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

// Determine time and limits
$response = [
    "status" => true,
    "type" => "open",
    "target" => $conf->Unifi->Open->Time * $conf->Unifi->Open->Type
];

if (!$conf->Unifi->Authentication) {
    $minutes = $response["target"];
    $downLimit = $conf->Unifi->Open->Download_Limit * 1024;
    $upLimit   = $conf->Unifi->Open->Upload_Limit * 1024;
    $dataLimit = $conf->Unifi->Open->Data_Limit * 1048576;
} else {
    $voucher = new Voucher;
    $vouchers = DB::where($voucher, "code", "=", $data["code"]);
    if (count($vouchers)) {
        $response["type"] = "voucher";
        $response["target"] = $vouchers[0]["expiration"];
        $minutes = $response["target"];
        $downLimit = (int)$vouchers[0]["download_limit"] * 1024;
        $upLimit   = (int)$vouchers[0]["upload_limit"] * 1024;
        $dataLimit = (int)$vouchers[0]["data_limit"] * 1048576;
    } else {
        echo json_encode(['status' => false, 'error' => 'Invalid voucher']);
        exit;
    }
}

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

// Step 2: Authorize guest with user group
$authData = json_encode([
    "cmd" => "authorize-guest",
    "mac" => $mac,
    "minutes" => $minutes,
    // "usergroup_id" => "691ab5155a7acf2bd2d04679" // apply user group here
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/s/$siteId/cmd/stamgr");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $authData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$authResponse = curl_exec($ch);
curl_close($ch);

// Final output
echo json_encode([
    'status' => true,
    'authorized' => $authResponse,
    'type' => $response["type"],
    'target' => $response["target"],
]);
