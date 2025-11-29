<?php
header('Content-Type: application/json');

// --- Configuration ---
$controllerUrl = 'https://192.168.15.220:8443';
$conf = json_decode(file_get_contents("../../conf.json")); 
$siteId = $conf->Unifi->Site_ID;
$username = $conf->Unifi->Username;
$password = $conf->Unifi->Password;
$cookieFile = 'unifi_cookie.txt';

$macToCheck = "1c:d1:07:e0:d5:ad"; // The MAC you want to check

// --- 1. Login ---
$loginData = json_encode(['username' => $username, 'password' => $password]);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $loginData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_exec($ch);
curl_close($ch);

// --- 2. Get WLAN Configs ---
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/s/$siteId/rest/wlanconf");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$wlanConfigResponse = curl_exec($ch);
curl_close($ch);

$wlanData = json_decode($wlanConfigResponse);

if ($wlanData->meta->rc != "ok") {
    die(json_encode(["status" => false, "message" => "Failed to retrieve WLAN configs."]));
}

// --- 3. Find Target SSID ---
$targetSsidName = "Text Captive"; 
$targetWlanConf = null;

foreach ($wlanData->data as $wlan) {
    if ($wlan->name === $targetSsidName) {
        $targetWlanConf = $wlan;
        break;
    }
}

if (!$targetWlanConf) {
    die(json_encode(["status" => false, "message" => "Target SSID not found."]));
}

// --- 4. Check MAC Filtering Enabled ---
$macFilterEnabled = $targetWlanConf->mac_filter_enabled ?? false;
$macFilterPolicy  = $targetWlanConf->mac_filter_policy ?? "none";
$macList          = $targetWlanConf->mac_filter_list ?? [];

if (!$macFilterEnabled) {
    echo json_encode([
        "status" => false,
        "message" => "MAC filtering is not enabled on SSID '$targetSsidName'.",
        "policy"  => $macFilterPolicy
    ]);
    exit;
}

// --- 5. Check if MAC Exists ---
$exists = false;
foreach ($macList as $mac) {
    if (strtolower($mac) === strtolower($macToCheck)) {
        $exists = true;
        break;
    }
}

if ($exists) {
    echo json_encode([
        "status" => true,
        "message" => "MAC $macToCheck exists in SSID '$targetSsidName' filter list.",
        "policy"  => $macFilterPolicy,
        "filter_enabled" => $macFilterEnabled
    ]);
} else {
    echo json_encode([
        "status" => false,
        "message" => "MAC $macToCheck does NOT exist in SSID '$targetSsidName' filter list.",
        "policy"  => $macFilterPolicy,
        "filter_enabled" => $macFilterEnabled
    ]);
}
?>
