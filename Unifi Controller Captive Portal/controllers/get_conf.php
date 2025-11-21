<?php
    $conf = json_decode(file_get_contents("../conf.json"));
    echo json_encode($conf);

?>