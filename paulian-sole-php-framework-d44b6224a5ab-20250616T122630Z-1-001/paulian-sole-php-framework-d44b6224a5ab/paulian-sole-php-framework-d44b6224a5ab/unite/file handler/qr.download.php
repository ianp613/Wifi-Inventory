<?php
    $file = $_GET["file"];
    $name = $_GET["name"];
    if(file_exists("../../public/root/qr/".$file)){
        $destination = "../../public/root/qr/".$file;
        /**Rename file to download filename */
        rename($destination, "../../public/root/qr/".$name);
        file_exists("../../public/root/qr/".$name);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename("../../public/root/qr/".$name));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize("../../public/root/qr/".$name));
        readfile("../../public/root/qr/".$name);
        /**Rename file to system filename */
        rename("../../public/root/qr/".$name, $destination);
    }else{
        echo("<b>Download Error: </b>File or folder doesn't exist.");
    }
?>