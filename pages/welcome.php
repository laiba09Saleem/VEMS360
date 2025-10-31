<?php
session_start();
require_once __DIR__ . '/../config/connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png" />
  <link rel="stylesheet" href="../assets/css/welcome.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

  <!-- HEADER -->
  <header class="navbar">
    <div class="logo">
      <img src="../assets/images/logo.png" alt="VEMS360 Logo">
      <h2>VEMS360</h2>
    </div>
    <nav class="nav-links">
      <a href="welcome.php" class="active">Home</a>
      <a href="about.php">About</a>
      <a href="event.php">Events</a>
      <a href="contact.php">Contact</a>
    </nav>
    <div class="nav-btns">
      <a href="create_event.php" class="btn primary"><i class="fa-solid fa-plus"></i> Create Event</a>
      <a href="report_event.php" class="btn outline"><i class="fa-solid fa-flag"></i> Report</a>
      <a href="rating.php" class="btn outline"><i class="fa-solid fa-star"></i> Ratings</a>
    </div>
  </header>

  <!-- HERO SECTION -->
  <section class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
      <h1>Welcome to <span>VEMS360</span></h1>
      <p>Your Complete Event Management Platform — Plan, Host, and Manage Seamlessly.</p>
      <a href="event.php" class="btn primary large">Explore Events</a>
    </div>
  </section>

  <!-- ABOUT / FEATURES -->
  <section class="features">
    <h2>Our Core Services</h2>
    <p class="intro">VEMS360 simplifies virtual, hybrid, and physical event management with intuitive tools, real-time insights, and seamless communication.</p>
    
    <div class="feature-grid">
      <div class="feature-card">
        <i class="fa-solid fa-laptop"></i>
        <h3>Virtual Events</h3>
        <p>Host webinars, workshops, and online conferences with live chat, polls, and analytics.</p>
      </div>
      <div class="feature-card">
        <i class="fa-solid fa-people-arrows"></i>
        <h3>Hybrid Events</h3>
        <p>Engage both in-person and remote attendees through integrated streaming and interactive tools.</p>
      </div>
      <div class="feature-card">
        <i class="fa-solid fa-building"></i>
        <h3>Physical Events</h3>
        <p>Organize on-site conferences, seminars, and corporate gatherings effortlessly.</p>
      </div>
    </div>
  </section>

  <!-- VIDEOS SECTION -->
  <section class="video-section">
    <div class="video-block">
      <video controls>
        <source src="../assets/videos/Virtual event.mp4" type="video/mp4">
      </video>
      <div class="video-text">
        <h3>Virtual Event Experience</h3>
        <p>Deliver interactive online events with real-time Q&A and virtual networking rooms.</p>
      </div>
    </div>

    <div class="video-block reverse">
      <video controls>
        <source src="../assets/videos/Hybrid events.mp4" type="video/mp4">
      </video>
      <div class="video-text">
        <h3>Hybrid Events</h3>
        <p>Seamlessly connect physical and virtual attendees through immersive hybrid setups.</p>
      </div>
    </div>

    <div class="video-block">
      <video controls>
        <source src="../assets/videos/Physical Events.mp4" type="video/mp4">
      </video>
      <div class="video-text">
        <h3>Physical Events</h3>
        <p>Plan, manage, and execute on-ground events with advanced logistics and automation tools.</p>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS -->
  <section class="testimonials">
    <h2>What Our Users Say</h2>
    <div class="testimonial-grid">
      <div class="testimonial-card">
        <p>“VEMS360 made our virtual summit a huge success — professional, engaging, and smooth.”</p>
        <h4>Amna Jafar</h4>
      </div>
      <div class="testimonial-card">
        <p>“The hybrid setup was flawless. Our on-site and remote teams collaborated effortlessly.”</p>
        <h4>Sarah Khan</h4>
      </div>
      <div class="testimonial-card">
        <p>“Great platform! Loved the interface, simplicity, and analytics dashboard.”</p>
        <h4>Ali Raza</h4>
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

  <script src="../assets/js/welcome.js"></script>
</body>
</html>
