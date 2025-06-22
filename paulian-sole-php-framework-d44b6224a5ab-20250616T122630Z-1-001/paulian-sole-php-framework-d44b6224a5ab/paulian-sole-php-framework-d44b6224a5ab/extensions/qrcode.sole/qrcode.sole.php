<?php
    define("QRCODE_BASEDIR",dirname(__FILE__).DIRECTORY_SEPARATOR);
    class QR{
        public static function create($text){
            include(QRCODE_BASEDIR."phpqrcode/qrlib.php");
            $path = QRCODE_BASEDIR."../../public/root/qr/";
            if(!is_dir($path)===true){
                mkdir($path);
            }
            $name = uniqid()."_".time()."_sl".".png";
            $file = $path.$name;
            QRcode::png($text, $file, QR_ECLEVEL_L, 10);
            $res = [
                "file" => $name,
                "path" => $path
            ];
            return $res;
        }
        public static function logo_create($text){
            include(QRCODE_BASEDIR."phpqrcode/qrlib.php");
            $path = QRCODE_BASEDIR."../../public/root/qr/";
            if(!is_dir($path)===true){
                mkdir($path);
            }
            $name = uniqid()."_".time()."_sl_logo_default".".png";
            $file = $path.$name;
            QRcode::png($text, $file, QR_ECLEVEL_L, 10);
            $imgname = $file;
            $logo = QRCODE_BASEDIR."../../public/assets/icons/favicon.ico";
            
            if(file_exists($logo) === true){
                $QR = imagecreatefrompng($imgname);
                if($logo !== FALSE){
                    $logopng = imagecreatefrompng($logo);
                    $QR_width = imagesx($QR);
                    $QR_height = imagesy($QR);
                    $logo_width = imagesx($logopng);
                    $logo_height = imagesy($logopng);
                    
                    list($newwidth, $newheight) = getimagesize($logo);
                    $out = imagecreatetruecolor($QR_width, $QR_width);
                    imagecopyresampled($out, $QR, 0, 0, 0, 0, $QR_width, $QR_height, $QR_width, $QR_height);
                    imagecopyresampled($out, $logopng, $QR_width/2.37, $QR_height/2.37, 0, 0, $QR_width/6, $QR_height/6, $newwidth, $newheight);
                }
                imagepng($out,$imgname);
                imagedestroy($out);
                $res = [
                    "file" => $name,
                    "path" => $path
                ];
                return $res; 
            }else{
                echo "<b>QR Code Creation Failed: </b>framework logo can't be found in the path specified.<br>";
            }
        }
        public static function logo_custom_create($text,$logo){
            include(QRCODE_BASEDIR."phpqrcode/qrlib.php");
            $path = QRCODE_BASEDIR."../../public/root/qr/";
            if(!is_dir($path)===true){
                mkdir($path);
            }
            $name = uniqid()."_".time()."_sl_logo_custom".".png";
            $file = $path.$name;
            QRcode::png($text, $file, QR_ECLEVEL_L, 10);
            $imgname = $file;
            if(file_exists($logo) === true){
                $QR = imagecreatefrompng($imgname);
                if($logo !== FALSE){
                    $logopng = imagecreatefrompng($logo);
                    $QR_width = imagesx($QR);
                    $QR_height = imagesy($QR);
                    $logo_width = imagesx($logopng);
                    $logo_height = imagesy($logopng);
                    
                    list($newwidth, $newheight) = getimagesize($logo);
                    $out = imagecreatetruecolor($QR_width, $QR_width);
                    imagecopyresampled($out, $QR, 0, 0, 0, 0, $QR_width, $QR_height, $QR_width, $QR_height);
                    imagecopyresampled($out, $logopng, $QR_width/2.37, $QR_height/2.37, 0, 0, $QR_width/6, $QR_height/6, $newwidth, $newheight);
                }
                imagepng($out,$imgname);
                imagedestroy($out);
                $res = [
                    "file" => $name,
                    "path" => $path
                ];
                return $res;
            }else{
                echo "<b>QR Code Creation Failed: </b>Logo can't be found in the path specified.<br>";
            }
        }
        public static function wipe(){
            $path = QRCODE_BASEDIR."../../public/root/qr/";
            if(!is_dir($path)===true){
                mkdir($path);
            }
            $res = glob($path."*.png");
            for ($i=0; $i < count($res); $i++) { 
                unlink($res[$i]);
            }
        }
        public static function delete($res){
            $path = QRCODE_BASEDIR."../../public/root/qr/";
            if(!is_dir($path)===true){
                mkdir($path);
            }
            $res = glob($path.$res);
            for ($i=0; $i < count($res); $i++) { 
                unlink($res[$i]);
            }
        }
    }
?>