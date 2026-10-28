<?php
require_once __DIR__ . '/config/connection.php';
require_once __DIR__ . '/config/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Welcome | VEMS360 - Event Management System</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    :root {
      --main-color: #00adb5;
      --bg-dark: #0e0e0e;
      --bg-light: #121212;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: var(--bg-dark);
      color: #fff;
      overflow-x: hidden;
    }

    /* Header */
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 50px;
      background-color: var(--bg-light);
      border-bottom: 1px solid #222;
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .logo {
      font-size: 1.6rem;
      font-weight: 600;
      color: var(--main-color);
      text-decoration: none;
    }

    nav {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    nav a {
      color: #ccc;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s;
    }

    nav a:hover {
      color: var(--main-color);
    }

    /* Mobile Menu Icon */
    .menu-toggle {
      display: none;
      font-size: 1.8rem;
      cursor: pointer;
      color: var(--main-color);
    }

    /* Hero */
    .hero {
      background: url('assets/images/header/musical_festival.jpg') center/cover no-repeat;
      height: 90vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      background-color: rgba(0, 0, 0, 0.6);
      background-blend-mode: overlay;
    }

    .hero h1 {
      font-size: 3rem;
      margin-bottom: 10px;
      color: #fff;
    }

    .hero p {
      font-size: 1.2rem;
      color: #ddd;
      margin-bottom: 30px;
    }

    .hero a {
      background: var(--main-color);
      padding: 12px 30px;
      border-radius: 30px;
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      transition: 0.3s;
    }

    .hero a:hover {
      background: #008c95;
    }

    /* About */
    .about {
      padding: 60px 80px;
      text-align: center;
    }

    .about h2 {
      color: var(--main-color);
      font-size: 2rem;
    }

    .about p {
      color: #aaa;
      max-width: 700px;
      margin: 15px auto;
      line-height: 1.7;
    }

    /* Events */
    .events {
      padding: 60px 80px;
      background-color: var(--bg-light);
    }

    .events h2 {
      text-align: center;
      color: var(--main-color);
      margin-bottom: 40px;
    }

    .event-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
    }

    .event-card {
      background: #1c1c1c;
      border-radius: 10px;
      overflow: hidden;
      transition: 0.3s;
    }

    .event-card:hover {
      transform: translateY(-5px);
    }

    .event-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .event-card h3 {
      margin: 15px;
      color: #fff;
    }

    .event-card p {
      color: #bbb;
      margin: 0 15px 15px;
    }

    /* Footer */
    footer {
      background: #0a0a0a;
      text-align: center;
      padding: 20px;
      border-top: 1px solid #222;
      color: #777;
      font-size: 0.9rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
      header {
        padding: 15px 25px;
      }

      nav {
        display: none;
        flex-direction: column;
        background-color: var(--bg-light);
        position: absolute;
        top: 60px;
        right: 0;
        width: 200px;
        border-left: 1px solid #222;
        padding: 15px;
        text-align: right;
      }

      nav.active {
        display: flex;
      }

      nav a {
        margin: 10px 0;
      }

      .menu-toggle {
        display: block;
      }

      .hero h1 {
        font-size: 2.2rem;
      }

      .hero p {
        font-size: 1rem;
      }

      .about, .events {
        padding: 40px 25px;
      }
    }
  </style>
</head>

<body>
  <header>
    <a href="index.php" class="logo">VEMS360</a>
    <div class="menu-toggle" onclick="toggleMenu()">☰</div>
    <nav id="navMenu">
      <a href="pages/event.php">Events</a>
      <a href="pages/about.php">About</a>
      <a href="pages/contact.php">Contact</a>
      <a href="pages/login.php">Login</a>
      <a href="pages/register.php">Register</a>
    </nav>
  </header>

  <section class="hero">
    <h1>Welcome to VEMS360</h1>
    <p>Your All-in-One Event Management System</p>
    <a href="pages/event.php">Explore Events</a>
  </section>

  <section class="about">
    <h2>About VEMS360</h2>
    <p>VEMS360 is a complete Event Management System that helps you organize, manage, and attend virtual, hybrid, and physical events with ease. From registration to rating, everything is just a few clicks away!</p>
  </section>

  <section class="events">
    <h2>Featured Events</h2>
    <div class="event-grid">
      <div class="event-card">
        <img src="assets/images/events/Event_1.jpg" alt="Event">
        <h3>Tech Conference 2025</h3>
        <p>Join the top innovators and creators shaping the future of technology.</p>
      </div>
      <div class="event-card">
        <img src="assets/images/events/Event 2.jpg" alt="Event">
        <h3>Music Fest</h3>
        <p>Experience live music from global artists in one amazing festival.</p>
      </div>
      <div class="event-card">
        <img src="assets/images/events/Event 3.jpg" alt="Event">
        <h3>Startup Expo</h3>
        <p>Showcase your business idea and connect with investors worldwide.</p>
      </div>
    </div>
  </section>

  <footer>
    &copy; <?php echo date('Y'); ?> VEMS360. All Rights Reserved.
  </footer>

  <script>
    function toggleMenu() {
      document.getElementById("navMenu").classList.toggle("active");
    }
  </script>
</body>
</html>
