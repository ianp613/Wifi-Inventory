<?php
class get_ssid {
  public static function index($ssidName) {

    $conf = json_decode(file_get_contents("../bot/config.json"));
    $controllerUrl = 'https://'.$conf->unifi_host.':'.$conf->unifi_port;
    $siteId = $conf->site[0][1];
    $username = $conf->username;
    $password = $conf->password;

    // Step 1: Login to UniFi Controller
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

    // Step 3: Find the SSID by name
    $target = null;
    foreach ($meta->data as $wlan) {
      if (isset($wlan->name) && strtolower($wlan->name) === strtolower($ssidName)) {
          $target = $wlan;
          break;
      }
    }

    if ($target) {
      return [
        "status" => true,
        "ssid"   => $ssidName,
        "data"   => $target
      ];
    } else {
      return [
        "status" => false,
        "message" => "⚠ SSID '$ssidName' not found."
      ];
    }
  }
}
