<?php
require_once __DIR__ . '/../config/connection.php';

// Restrict access to logged-in users only
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // redirect to login if not logged in
    exit();
}

// Handle contact form submission
$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if ($name && $email && $subject && $message) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        if ($stmt->execute()) {
            $success = "Your message has been sent successfully!";
        } else {
            $error = "Something went wrong. Please try again.";
        }
        $stmt->close();
    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png">
  <link rel="stylesheet" href="../assets/css/contact.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<header class="navbar">
  <div class="logo">
    <img src="../assets/images/logo.png" alt="Logo">
    <h2>VEMS360</h2>
  </div>
  <nav class="nav-links">
    <a href="welcome.php">Home</a>
    <a href="about.php">About</a>
    <a href="event.php">Events</a>
    <a href="rating.php">Ratings</a>
    <a href="contact.php" class="active">Contact</a>
    <a href="profile.php"><i class="fa-solid fa-user"></i> Profile</a>
  </nav>
</header>

<section class="contact-hero">
  <div class="overlay"></div>
  <div class="hero-content">
    <h1>Get in Touch</h1>
    <p>We’d love to hear from you! Send us your feedback, suggestions, or event queries.</p>
  </div>
</section>

<section class="contact-section">
  <div class="container">
    <div class="contact-info">
      <h2>Contact Information</h2>
      <p><i class="fa-solid fa-envelope"></i> support@vems360.com</p>
      <p><i class="fa-solid fa-phone"></i> +92 300 1234567</p>
      <p><i class="fa-solid fa-location-dot"></i> Lahore, Pakistan</p>
    </div>

    <div class="contact-form">
      <h2>Send Message</h2>

      <?php if ($success): ?>
        <div class="alert success"><?= $success; ?></div>
      <?php elseif ($error): ?>
        <div class="alert error"><?= $error; ?></div>
      <?php endif; ?>

      <form method="POST">
        <label>Your Name *</label>
        <input type="text" name="name" required>

        <label>Email Address *</label>
        <input type="email" name="email" required>

        <label>Subject *</label>
        <input type="text" name="subject" required>

        <label>Message *</label>
        <textarea name="message" rows="5" required></textarea>

        <button type="submit" class="btn"><i class="fa-solid fa-paper-plane"></i> Send</button>
      </form>
    </div>
  </div>
</section>

<footer class="footer">
  <div class="footer-content">
    <div class="footer-about">
      <img src="../assets/images/logo.png" alt="VEMS360 Logo">
      <p>VEMS360 — Manage your events smartly and professionally.</p>
    </div>
    <div class="footer-links">
      <h4>Quick Links</h4>
      <a href="about.php">About</a>
      <a href="contact.php">Contact</a>
      <a href="privacy.php">Privacy Policy</a>
    </div>
    <div class="footer-social">
      <h4>Follow Us</h4>
      <a href="#"><i class="fab fa-facebook"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
    </div>
  </div>
  <p class="copyright">&copy; 2025 VEMS360. All rights reserved.</p>
</footer>

</body>
</html>
