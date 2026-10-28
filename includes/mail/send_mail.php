<?php
require_once 'PHPMailer/Exception.php';
require_once 'PHPMailer/SMTP.php';
require_once 'PHPMailer/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load environment variables
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

/**
 * Send contact form submission email
 */
function sendContactEmail($name, $email, $phone, $event_type, $message)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
        $mail->Port = $_ENV['MAIL_PORT'];

        // Sender & Receiver
        $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress($_ENV['MAIL_FROM_ADDRESS'], 'VEMS360');

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
        $mail->Host = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
        $mail->Port = $_ENV['MAIL_PORT'];

        // Sender & Receiver
        $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
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
