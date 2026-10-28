<?php
session_start();
require_once __DIR__ . '/../config/connection.php';
// Restrict access to logged-in users only
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // redirect to login if not logged in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Events | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png">
  <link rel="stylesheet" href="../assets/css/event.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

  <!-- NAVBAR -->
  <header class="navbar">
    <div class="logo">
      <img src="../assets/images/logo.png" alt="VEMS360 Logo">
      <h2>VEMS360</h2>
    </div>
    <nav class="nav-links">
      <a href="welcome.php">Home</a>
      <a href="about.php">About</a>
      <a href="event.php" class="active">Events</a>
      <a href="contact.php">Contact</a>
      <a href="profile.php"><i class="fa-solid fa-user"></i> Profile</a>
    </nav>
    <div class="nav-btns">
      <a href="create_event.php" class="btn primary"><i class="fa-solid fa-plus"></i> Create Event</a>
    </div>
  </header>

  <!-- HERO SECTION -->
  <section class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
      <h1>Discover <span>Upcoming Events</span></h1>
      <p>Browse virtual, hybrid, and physical events organized through VEMS360.</p>
    </div>
  </section>

  <!-- EVENT GRID SECTION -->
  <section class="event-section">
    <h2>Explore Events</h2>
    <div class="event-grid">
      <?php
      $query = "SELECT * FROM events ORDER BY id DESC";
      $result = mysqli_query($conn, $query);

      if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $eventType = htmlspecialchars($row['event_type']);
          $eventDate = htmlspecialchars($row['date']);
          $title = htmlspecialchars($row['title']);
          $location = htmlspecialchars($row['location']);
          $image = htmlspecialchars($row['image']);
          $id = (int)$row['id'];

          // Proper image path check
          $imagePath = "../assets/images/events/" . $image;
          if (empty($image) || !file_exists($imagePath)) {
            $imagePath = "../assets/images/default.jpg"; // fallback image
          }

          echo "
          <div class='event-card'>
            <img src='{$imagePath}' alt='{$title}' class='event-img'>
            <div class='event-content'>
              <h3>{$title}</h3>
              <p class='type'><i class='fa-solid fa-layer-group'></i> {$eventType}</p>
              <p class='date'><i class='fa-solid fa-calendar-days'></i> {$eventDate}</p>
              <p class='location'><i class='fa-solid fa-location-dot'></i> {$location}</p>
              <a href='event_details.php?id={$id}' class='btn outline'>View Details</a>
              <a href='report_event.php?id={$id}' class='btn report'><i class='fa-solid fa-flag'></i> Report</a>
            </div>
          </div>";
        }
      } else {
        echo "<p class='no-events'>No events available right now.</p>";
      }
      ?>
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

  <script src="../assets/js/event.js"></script>
</body>
</html>
