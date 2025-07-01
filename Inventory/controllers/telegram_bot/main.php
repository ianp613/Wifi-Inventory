<?php
include("../../includes.php");
include("interpreter.php");
if (isset($_POST['message'])) {
    $message = $_POST['message'];

    $message = Interprepter::solve($message);
    
    echo json_encode($message);
} else {
    echo "No message received, something is wrong with bot module [python]";
}
?>