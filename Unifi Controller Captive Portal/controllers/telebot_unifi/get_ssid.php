<?php
class get_ssid{
  public static function index(){

    $controllerUrl = 'https://192.168.15.220:8443';
    $conf = json_decode(file_get_contents("../../conf.json"));
    $siteId = $conf->Unifi->Site_ID;
    $username = $conf->Unifi->Username;
    $password = $conf->Unifi->Password;

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

    $result = [
      "status" => $meta->meta->rc != "ok" ? false : true ,
      "data" => $clientsResponse 
    ];

    return $result;
  }
}