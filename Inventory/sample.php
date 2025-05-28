<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'paulian.dumdum@gmail.com'; // Your Gmail address
    $mail->Password = 'ytrr qwdo kqox vdre'; // Use the App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Email details
    $mail->setFrom('paulian.dumdum@gmail.com', 'Wifi Team Inventory');
    $mail->addAddress('ianpaulianchasea@gmail.com');
    $mail->Subject = 'Test Email';
    $mail->Body = 'Hello, this is a test email using PHPMailer and Gmail SMTP.';

    // Send email
    $mail->send();
    echo 'Email sent successfully!';
} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}
