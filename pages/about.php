<?php
session_start();
require_once __DIR__ . '/../config/connection.php';

// Restrict access if not logged in
//if (!isset($_SESSION['user_id'])) {
 // header("Location: ../index.php");
 // exit();
//}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png" />
  <link rel="stylesheet" href="../assets/css/about.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

  <!-- HEADER (same as welcome) -->
  <header class="navbar">
    <div class="logo">
      <img src="../assets/images/logo.png" alt="VEMS360 Logo">
      <h2>VEMS360</h2>
    </div>
    <nav class="nav-links">
      <a href="welcome.php">Home</a>
      <a href="about.php" class="active">About</a>
      <a href="event.php">Events</a>
      <a href="contact.php">Contact</a>
      <a href="profile.php"><i class="fa-solid fa-user"></i> Profile</a>
    </nav>
    <div class="nav-btns">
      <a href="create_event.php" class="btn primary"><i class="fa-solid fa-plus"></i> Create Event</a>
      <a href="report_event.php" class="btn outline"><i class="fa-solid fa-flag"></i> Report</a>
      <a href="rating.php" class="btn outline"><i class="fa-solid fa-star"></i> Ratings</a>
    </div>
  </header>

  <!-- HERO SECTION -->
  <section class="hero about-hero">
    <div class="overlay"></div>
    <div class="hero-content">
      <h1>About <span>VEMS360</span></h1>
      <p>Your Trusted Partner for Virtual, Hybrid, and Physical Events</p>
    </div>
  </section>

  <!-- WHO WE ARE -->
  <section class="about-section">
    <div class="container">
      <div class="about-content">
        <div class="about-text">
          <h2>Who We Are</h2>
          <p>
            VEMS360 is an innovative event management platform that helps organizations host <b>Virtual, Hybrid, and Physical events</b> with ease.
            We combine technology and creativity to make your event planning simple, efficient, and memorable.
          </p>
          <ul class="about-list">
            <li><i class="fa-solid fa-star"></i> 200+ Five-Star Ratings</li>
            <li><i class="fa-solid fa-users"></i> 98% Client Retention</li>
            <li><i class="fa-solid fa-lightbulb"></i> Innovative Event Solutions</li>
            <li><i class="fa-solid fa-handshake"></i> Trusted by Top Brands</li>
          </ul>
        </div>
        <div class="about-img">
          <img src="../assets/images/events/Event1.png" alt="About VEMS360">
        </div>
      </div>
    </div>
  </section>

  <!-- MISSION & VISION -->
  <section class="mission-vision">
    <div class="container">
      <h2>Our Mission & Vision</h2>
      <div class="mv-grid">
        <div class="mv-card">
          <i class="fa-solid fa-bullseye"></i>
          <h3>Our Mission</h3>
          <p>
            To empower event organizers with smart tools and innovative solutions to deliver meaningful and impactful experiences.
          </p>
        </div>
        <div class="mv-card">
          <i class="fa-solid fa-eye"></i>
          <h3>Our Vision</h3>
          <p>
            To become a global leader in event technology — redefining how people connect, collaborate, and celebrate across platforms.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- TEAM / TESTIMONIALS -->
  <section class="testimonials">
    <h2>What People Say</h2>
    <div class="testimonial-grid">
      <div class="testimonial-card">
        <p>“VEMS360 made our conference planning stress-free and perfectly managed.”</p>
        <h4>Sarah Malik</h4>
      </div>
      <div class="testimonial-card">
        <p>“A complete platform for all event types — simple, smart, and reliable.”</p>
        <h4>Owais Ahmad</h4>
      </div>
      <div class="testimonial-card">
        <p>“Their team’s support and technology integration is unmatched.”</p>
        <h4>Hira Fatima</h4>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
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

  <script src="../assets/js/about.js"></script>
</body>
</html>
