<?php
session_start();
require_once __DIR__ . '/../config/connection.php';
// Restrict access to logged-in users only
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // redirect to login if not logged in
    exit();
}

// Restrict if user not logged in (optional, if session exists)
if (!isset($_SESSION['user_id'])) {
  // temporarily assigning a fake ID for testing
  $_SESSION['user_id'] = 1;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $event_type = mysqli_real_escape_string($conn, $_POST['event_type']);
  $location = mysqli_real_escape_string($conn, $_POST['location']);
  $date = mysqli_real_escape_string($conn, $_POST['date']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $created_by = $_SESSION['user_id'];

  // Handle image upload
  $image = "";
  if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $uploadDir = "../assets/images/events/";
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }
    $imageName = time() . "_" . basename($_FILES['image']['name']);
    $targetFile = $uploadDir . $imageName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
      $image = $imageName;
    }
  }

  $sql = "INSERT INTO events (title, event_type, location, date, description, image, created_by)
          VALUES ('$title', '$event_type', '$location', '$date', '$description', '$image', '$created_by')";

  if (mysqli_query($conn, $sql)) {
    $message = "✅ Event created successfully!";
  } else {
    $message = "❌ Error: " . mysqli_error($conn);
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Event | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png">
  <link rel="stylesheet" href="../assets/css/create_event.css">
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
    <a href="contact.php">Contact</a>
  </nav>
</header>

<section class="form-section">
  <div class="form-container">
    <h1>Create New Event</h1>

    <?php if ($message): ?>
      <div class="message"><?= $message; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
      <label>Event Title</label>
      <input type="text" name="title" required placeholder="Enter event title">

      <label>Event Type</label>
      <select name="event_type" required>
        <option value="">Select Type</option>
        <option value="Virtual">Virtual</option>
        <option value="Hybrid">Hybrid</option>
        <option value="Physical">Physical</option>
      </select>

      <label>Location / Link</label>
      <input type="text" name="location" required placeholder="Venue or online link">

      <label>Date</label>
      <input type="date" name="date" required>

      <label>Description</label>
      <textarea name="description" rows="4" placeholder="Write short event details"></textarea>

      <label>Upload Image</label>
      <input type="file" name="image" accept="image/*">

      <button type="submit" class="btn">Create Event</button>
    </form>
  </div>
</section>

</body>
</html>
