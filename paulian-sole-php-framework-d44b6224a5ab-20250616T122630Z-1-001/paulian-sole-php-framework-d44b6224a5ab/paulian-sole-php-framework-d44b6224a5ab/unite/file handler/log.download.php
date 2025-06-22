<?php
    if(file_exists("../log/sole.log")){
        $destination = "../log/sole.log";
        file_exists($destination);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($destination));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($destination));
        readfile($destination);
    }else{
        echo("<b>Download Error: </b>File or folder doesn't exist.");
    }
?>