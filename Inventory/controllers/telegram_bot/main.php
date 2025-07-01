<?php
include("../../includes.php");
include("SQLGenerator.php");
if (isset($_POST['message'])) {
    $message = $_POST['message'];
    
    echo json_encode(SQLGenerator::generate($message));
} else {
    echo "No message received, something is wrong with bot module [python]";
}
?>