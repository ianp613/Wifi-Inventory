<?php
    $ip = $_SERVER['REMOTE_ADDR'];

    $mac = false;
    $arp = shell_exec("arp -a $ip");

    if (preg_match('/..-..-..-..-..-../', $arp, $matches)) {
        $mac = $matches[0];
    }

    if (preg_match('/..:..:..:..:..:../', $arp, $matches)) {
        $mac = $matches[0];
    }
    
    $mac = $mac ? str_replace("-",":",$mac) : false;

    echo json_encode($mac);

?>