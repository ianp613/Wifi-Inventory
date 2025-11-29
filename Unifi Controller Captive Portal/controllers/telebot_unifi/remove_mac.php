<?php
header('Content-Type: application/json');

// --- Configuration ---
$controllerUrl = 'https://192.168.15.220:8443';
// Make sure your conf.json is accessible and correctly structured
$conf = json_decode(file_get_contents("../../conf.json")); 
$siteId = $conf->Unifi->Site_ID;
$username = $conf->Unifi->Username;
$password = $conf->Unifi->Password;
$cookieFile = 'unifi_cookie.txt'; // Must match the file used in the login step

// --- 1. Login to UniFi Controller (Re-run if session might be expired) ---
$loginData = json_encode(['username' => $username, 'password' => $password]);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/login");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $loginData);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile); // Save cookies
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_exec($ch);
curl_close($ch);


// --- 2. Retrieve the *Current* WLAN Config to find the target SSID ID ---
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/s/$siteId/rest/wlanconf");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Use existing cookies
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$wlanConfigResponse = curl_exec($ch);
curl_close($ch);

$wlanData = json_decode($wlanConfigResponse);

if ($wlanData->meta->rc != "ok") {
    die(json_encode(["status" => false, "message" => "Failed to retrieve WLAN configs."]));
}

// Identify the SSID you want to modify (e.g., "DDC Device Wifi")
$targetSsidName = "DDC Device Wifi"; 
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

// Inside Step 3, replace the existing 'if' blocks for adding the MAC:

$macToRemove = "5c:40:71:b1:9e:70"; // The MAC address you want to remove
$wlanId = $targetWlanConf->_id;

// Check if the mac_filter_list exists and is an array, otherwise initialize it
if (!isset($targetWlanConf->mac_filter_list) || !is_array($targetWlanConf->mac_filter_list)) {
    $currentList = [];
} else {
    $currentList = $targetWlanConf->mac_filter_list;
}

// Use array_filter to create a new array excluding the target MAC
// We map to lowercase for a case-insensitive comparison
$updatedList = array_filter($currentList, function($mac) use ($macToRemove) {
    return strtolower($mac) !== strtolower($macToRemove);
});

// IMPORTANT: Re-index the array values starting from 0 for valid JSON formatting
$targetWlanConf->mac_filter_list = array_values($updatedList);

// Ensure the filter remains enabled if that is your desired state
$targetWlanConf->mac_filter_enabled = true;
$targetWlanConf->mac_filter_policy = "allow"; // or "deny"

$updatePayload = json_encode($targetWlanConf);


// --- 4. Send a PUT request to update the specific WLAN config ---

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/s/$siteId/rest/wlanconf/$wlanId");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $updatePayload);

// *** DEBUGGING LINES ADDED HERE ***
error_log("Sending Payload: " . $updatePayload);
// *********************************

curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$updateResponse = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$updateResult = json_decode($updateResponse);

if ($updateResult && $updateResult->meta->rc === "ok" && $httpCode === 200) {
    echo json_encode([
        "status" => true,
        "message" => "Successfully removed $macToRemove to $targetSsidName allow list.",
        "response_meta" => $updateResult->meta
    ]);
} else {
    // *** DEBUGGING LINES MODIFIED HERE ***
    echo json_encode([
        "status" => false,
        "message" => "Failed to update MAC filter list. HTTP Status: $httpCode",
        "raw_payload_sent" => json_decode($updatePayload), // Shows exactly what was sent
        "raw_response_from_unifi" => json_decode($updateResponse) // Shows Unifi's error message
    ]);
}
?>
