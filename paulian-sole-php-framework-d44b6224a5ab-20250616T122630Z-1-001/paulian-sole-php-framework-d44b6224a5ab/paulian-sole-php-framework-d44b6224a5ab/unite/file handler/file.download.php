<?php
    $type = $_GET["type"];
    $file = $_GET["file"];
    $name = $_GET["name"];
    $folder = $_GET["folder"];
    if(file_exists("../../public/root/".$type."/".$folder."/".$file)){
        /**Rename file to download filename */
        rename("../../public/root/".$type."/".$folder."/".$file, "../../public/root/".$type."/".$folder."/".$name);
        $destination = "../../public/root/".$type."/".$folder."/" . $name;
        file_exists($destination);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($destination));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize("../../public/root/".$type."/".$folder."/" . $name));
        readfile("../../public/root/".$type."/".$folder."/". $name);
        /**Rename file to system filename */
        rename("../../public/root/".$type."/".$folder."/".$name, "../../public/root/".$type."/".$folder."/".$file);
    }else{
        echo("<b>Download Error: </b>File or folder doesn't exist.");
    }
?>