<?php
    include("mac_fix.php");
    include("get_ssid.php");
    include("check_mac.php");
    include("add_mac.php");
    include("remove_mac.php");
    // include("block_mac.php");
    // include("unblock_mac.php");
    session_start();

    $data = json_decode(file_get_contents('php://input'), true);
    $conf = json_decode(file_get_contents("../bot/config.json"));
    $message = $data["message"];
    $command_list = ["show","add","remove","check","block","unblock"];
    $response = "⚠ Please specify your query.";
    $network = $conf->network;
    $command = null;

    if(strtolower($message) == "hello" || strtolower($message) == "hello ".$network || strtolower($message) == "hi" || strtolower($message) == "hi ".$network){
        echo "👋 Hello network ".$network." is active.";
        die;
    }
    $message_break = explode("\n",$message);

    if(count($message_break)){
        $first_line = explode(" ",$message_break[0]);
        if(count($first_line) > 1){
            $command = $first_line[1];
            if($first_line[0] != $network && strtolower($first_line[0]) != "all"){
                die;
            }
        }else{
            die;
        }
        if(count($message_break) > 1){
            $command = strtolower($command);
            if(in_array($command,$command_list)){
                if($command == "show" && count($message_break) == 2){
                    // get all ssid
                    $ssid = get_ssid::index($message_break[1]);
                    if($ssid["status"]){
                        echo "Name: ".$ssid["data"]->name."\nPassword: ".$ssid["data"]->x_passphrase."\nMAC Filter: ".($ssid["data"]->mac_filter_enabled ? "True" : "False");
                        die;
                    }else{
                        echo $ssid["message"];
                        die;
                    }
                }
                if(count($message_break) > 2){
                    // CHECK MAC ADDRESS
                    if($command == "check"){
                        $mac = MAC_FIX::index($message_break[2]);
                        if($mac){
                            $check = check_mac::index($message_break[1],$mac);
                            echo $check["message"];
                            die;
                        }else{
                            echo "⚠ MAC is invalid.";
                            die;
                        }
                    }
                    // ADD MAC ADDRESS
                    if($command == "add"){
                        $mac = MAC_FIX::index($message_break[2]);
                        if($mac){
                            $add = add_mac::index($message_break[1],$mac);
                            echo $add["message"];
                            die;
                        }else{
                            echo "⚠ MAC is invalid.";
                            die;
                        }
                    }
                    // REMOVE MAC ADDRESS
                    if($command == "remove"){
                        $mac = MAC_FIX::index($message_break[2]);
                        if($mac){
                            $remove = remove_mac::index($message_break[1],$mac);
                            echo $remove["message"];
                            die;
                        }else{
                            echo "⚠ MAC is invalid.";
                            die;
                        }
                    }
                }else{
                    echo "⚠ Please provide MAC address.";
                    die;
                }
                
            }else{
                // command dont exist
                echo $response;
            }
        }else{
            // query is single line only
            echo $response;
        }
    }
?>

