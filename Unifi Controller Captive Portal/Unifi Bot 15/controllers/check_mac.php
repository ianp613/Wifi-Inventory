<?php
class check_mac {
  public static function index($ssidName, $macToCheck) {

    $conf = json_decode(file_get_contents("../bot/config.json"));
    $controllerUrl = 'https://'.$conf->unifi_host.':'.$conf->unifi_port;
    $siteId = $conf->site[0][1];
    $username = $conf->username;
    $password = $conf->password;

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
    curl_exec($ch);
    curl_close($ch);

    // Step 2: Get WLAN configs
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$controllerUrl/api/s/$siteId/rest/wlanconf");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'unifi_cookie.txt');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $clientsResponse = curl_exec($ch);
    curl_close($ch);

    $meta = json_decode($clientsResponse);

    if ($meta->meta->rc != "ok") {
      return [
        "status" => false,
        "message" => "⚠ Failed to retrieve WLAN configs."
      ];
    }

    // Step 3: Find SSID by name (case-insensitive)
    $target = null;
    foreach ($meta->data as $wlan) {
      if (isset($wlan->name) && strtolower($wlan->name) === strtolower($ssidName)) {
          $target = $wlan;
          break;
      }
    }

    if (!$target) {
      return [
        "status" => false,
        "message" => "⚠ SSID '$ssidName' not found."
      ];
    }

    // Step 4: Check MAC filtering enabled
    $macFilterEnabled = $target->mac_filter_enabled ?? false;
    $macFilterPolicy  = $target->mac_filter_policy ?? "none";
    $macList          = $target->mac_filter_list ?? [];

    if (!$macFilterEnabled) {
      return [
        "status" => false,
        "ssid"   => $ssidName,
        "message" => "⚠ MAC filtering is not enabled on SSID '$ssidName'.",
        "policy"  => $macFilterPolicy
      ];
    }

    // Step 5: Check if MAC exists in filter list
    $exists = false;
    foreach ($macList as $mac) {
      if (strtolower($mac) === strtolower($macToCheck)) {
        $exists = true;
        break;
      }
    }

    if ($exists) {
      return [
        "status" => true,
        "ssid"   => $ssidName,
        "message" => "✅ MAC $macToCheck exists in SSID '$ssidName' filter list.",
        "policy"  => $macFilterPolicy,
        "filter_enabled" => $macFilterEnabled
      ];
    } else {
      return [
        "status" => false,
        "ssid"   => $ssidName,
        "message" => "⚠ MAC $macToCheck does NOT exist in SSID '$ssidName' filter list.",
        "policy"  => $macFilterPolicy,
        "filter_enabled" => $macFilterEnabled
      ];
    }
  }
}
