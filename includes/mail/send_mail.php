<?php
require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendContactEmail($name, $email, $phone, $event_type, $message) {
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'laibasaleem784@gmail.com';
        $mail->Password = 'czxc ljyy uoih xwde';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($email, $name);
        $mail->addAddress('laibasaleem784@gmail.com', 'VEMS360');
        $mail->Subject = "New Contact Form Submission - " . $event_type;
        
        $mail->Body = "
        New contact form submission from VEMS360 website:
        
        Name: $name
        Email: $email
        Phone: $phone
        Event Type: $event_type
        
        Message:
        $message
        
        ---
        This email was sent from the VEMS360 contact form.
        ";

        return $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
?>