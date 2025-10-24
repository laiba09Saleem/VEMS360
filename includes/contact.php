<?php
require_once 'config/connection.php';

// PHPMailer setup - make sure these files exist in includes/mail/PHPMailer/
require_once 'includes/mail/PHPMailer/Exception.php';
require_once 'includes/mail/PHPMailer/SMTP.php';
require_once 'includes/mail/PHPMailer/PHPMailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    $errors = [];

    // Validate inputs
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    }
    if (empty($subject)) {
        $errors[] = "Subject is required.";
    }
    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    if (empty($errors)) {
        // Store message in database
        $stmt = $conn->prepare("INSERT INTO contact_form (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);
        
        if ($stmt->execute()) {
            $success = "Thank you for your message! We'll get back to you soon.";

            // Send email using PHPMailer
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
                $mail->Subject = "Contact Us Form: " . $subject;
                $mail->Body = "You have received a new message:\n\n" .
                              "Name: $name\nEmail: $email\nPhone: $phone\n\nMessage:\n$message";

                $mail->send();
            } catch (Exception $e) {
                $mail_error = "Message stored but email notification failed.";
            }
        } else {
            $error = "Error: " . $stmt->error;
        }
    } else {
        $error = implode("<br>", $errors);
    }
}
?>

    <?php include 'includes/navbar.php'; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/images/logo.png">
    <title><?php echo SITE_NAME; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/contact.css">
</head>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="contact-container">
            <!-- Success/Error Messages -->
            <?php if (isset($success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($mail_error)): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?php echo $mail_error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="row g-5">
                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="contact-form">
                        <h2 class="text-center mb-4">Get In Touch</h2>
                        <form action="contact.php" method="POST" id="contactForm">
                            <div class="input-box">
                                <div class="input-field field">
                                    <input type="text" name="name" placeholder="Full Name" id="name" class="item" autocomplete="off" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
                                    <div class="error-text">Full Name can't be blank.</div>
                                </div>
                                <div class="input-field field">
                                    <input type="text" name="email" placeholder="Email Address" id="email" class="item" autocomplete="off" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                                    <div class="error-text">Email Address can't be blank.</div>
                                </div>
                            </div>

                            <div class="input-box">
                                <div class="input-field field">
                                    <input type="text" name="phone" placeholder="Phone Number" id="phone" class="item" autocomplete="off" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
                                    <div class="error-text">Phone Number can't be blank.</div>
                                </div>
                                <div class="input-field field">
                                    <input type="text" name="subject" placeholder="Subject" id="subject" class="item" autocomplete="off" value="<?php echo isset($_POST['subject']) ? $_POST['subject'] : ''; ?>">
                                    <div class="error-text">Subject can't be blank.</div>
                                </div>
                            </div>

                            <div class="textarea-field field">
                                <textarea name="message" id="message" cols="30" rows="10" placeholder="Your Message" class="item" autocomplete="off"><?php echo isset($_POST['message']) ? $_POST['message'] : ''; ?></textarea>
                                <div class="error-text">Message can't be blank.</div>
                            </div>
                            <button type="submit" class="btn-submit">Send Message</button>
                        </form>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="col-lg-4">
                    <div class="contact-info">
                        <h4>Contact Information</h4>
                        
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="info-content">
                                <h5>Our Office</h5>
                                <p>Lahore, Punjab, Pakistan</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <div class="info-content">
                                <h5>Phone Number</h5>
                                <p>+92 8429972042</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <div class="info-content">
                                <h5>Email Address</h5>
                                <p>info@vems360.com</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <div class="info-content">
                                <h5>Working Hours</h5>
                                <p>24/7 Customer Support</p>
                            </div>
                        </div>

                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>