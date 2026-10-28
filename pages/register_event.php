<?php
session_start();
require_once __DIR__ . '/../config/connection.php';
// Restrict access to logged-in users only
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // redirect to login if not logged in
    exit();
}

// Check if event ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: event.php");
    exit();
}

$event_id = intval($_GET['id']);

// Fetch event details
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "<h2 style='text-align:center; color:white;'>Event not found.</h2>";
    exit();
}
$event = $result->fetch_assoc();
$stmt->close();

// Handle form submission
$successMsg = $errorMsg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if ($name && $email) {
        $insert = $conn->prepare("INSERT INTO event_registrations (event_id, name, email, phone) VALUES (?, ?, ?, ?)");
        $insert->bind_param("isss", $event_id, $name, $email, $phone);
        if ($insert->execute()) {
            $successMsg = "✅ Registration successful! See you at the event.";
        } else {
            $errorMsg = "❌ Something went wrong. Please try again.";
        }
        $insert->close();
    } else {
        $errorMsg = "⚠️ Please fill all required fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register for <?= htmlspecialchars($event['title']); ?> | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png">
  <link rel="stylesheet" href="../assets/css/register_event.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

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
  </nav>
</header>

<section class="register-section">
  <div class="register-container">
    <h1>Register for <span><?= htmlspecialchars($event['title']); ?></span></h1>
    <p class="event-info"><i class="fa-solid fa-calendar-days"></i> <?= htmlspecialchars($event['date']); ?> | <i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($event['location']); ?></p>

    <?php if ($successMsg): ?>
      <div class="alert success"><?= $successMsg; ?></div>
    <?php elseif ($errorMsg): ?>
      <div class="alert error"><?= $errorMsg; ?></div>
    <?php endif; ?>

    <form method="POST" class="register-form">
      <div class="form-group">
        <label><i class="fa-solid fa-user"></i> Full Name</label>
        <input type="text" name="name" placeholder="Enter your name" required>
      </div>
      <div class="form-group">
        <label><i class="fa-solid fa-envelope"></i> Email</label>
        <input type="email" name="email" placeholder="Enter your email" required>
      </div>
      <div class="form-group">
        <label><i class="fa-solid fa-phone"></i> Phone (optional)</label>
        <input type="text" name="phone" placeholder="Enter phone number">
      </div>
      <button type="submit" class="btn submit"><i class="fa-solid fa-paper-plane"></i> Register</button>
      <a href="event_details.php?id=<?= $event_id; ?>" class="btn back"><i class="fa-solid fa-arrow-left"></i> Back</a>
    </form>
  </div>
</section>

<footer class="footer">
  <p>&copy; 2025 VEMS360. All rights reserved.</p>
</footer>

</body>
</html>
