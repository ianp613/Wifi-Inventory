<?php
include("../../includes.php");
include("Identifier.php");
if (isset($_POST['message'])) {
    $message = $_POST['message'];
    
    echo json_encode(Identifier::main($message), JSON_UNESCAPED_UNICODE);
} else {
    echo "No message received, something is wrong with bot module [python]";
}
?>