<?php
require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Send contact form submission email
 */
function sendContactEmail($name, $email, $phone, $event_type, $message)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'laibasaleem784@gmail.com'; // Your Gmail address
        $mail->Password = 'czxc ljyy uoih xwde'; // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender & Receiver
        $mail->setFrom($email, $name);
        $mail->addAddress('laibasaleem784@gmail.com', 'VEMS360');

        // Email content
        $mail->isHTML(false);
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
        error_log("Mailer Error (Contact): " . $mail->ErrorInfo);
        return false;
    }
}

/**
 * Send account verification email after registration
 */
function sendVerificationEmail($email, $fullName, $verification_link)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'laibasaleem784@gmail.com'; // Your Gmail address
        $mail->Password = 'czxc ljyy uoih xwde'; // Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender & Receiver
        $mail->setFrom('laibasaleem784@gmail.com', 'VEMS360');
        $mail->addAddress($email, $fullName);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Verify Your Email - VEMS360";
        $mail->Body = "
            <h2>Welcome to VEMS360, $fullName!</h2>
            <p>Thank you for registering. Please verify your email address by clicking the button below:</p>
            <p style='text-align:center;'>
                <a href='$verification_link' style='background-color:#007BFF; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>Verify Email</a>
            </p>
            <p>If you didn’t register on VEMS360, please ignore this message.</p>
            <br>
            <p>Regards,<br><strong>VEMS360 Team</strong></p>
        ";

        return $mail->send();
    } catch (Exception $e) {
        error_log("Mailer Error (Verification): " . $mail->ErrorInfo);
        return false;
    }
}
?>
