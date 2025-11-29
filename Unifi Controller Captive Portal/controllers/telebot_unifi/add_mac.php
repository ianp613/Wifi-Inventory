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

// --- 3. Prepare the updated data payload with the new MAC address ---

$newMacAddressToAdd = "5c:40:71:b1:9e:70"; // <-- Specify the MAC address here
$wlanId = $targetWlanConf->_id;

if (!isset($targetWlanConf->mac_filter_list) || !is_array($targetWlanConf->mac_filter_list)) {
    $targetWlanConf->mac_filter_list = [];
}

// Add the new MAC if it doesn't already exist in the list
if (!in_array($newMacAddressToAdd, $targetWlanConf->mac_filter_list)) {
    $targetWlanConf->mac_filter_list[] = $newMacAddressToAdd;
}

// Ensure the filter is enabled and set to 'allow' policy
$targetWlanConf->mac_filter_enabled = true;
$targetWlanConf->mac_filter_policy = "allow";

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
        "message" => "Successfully added $newMacAddressToAdd to $targetSsidName allow list.",
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
