<?php
session_start();
require_once __DIR__ . '/../config/connection.php';

// Check if event ID provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: event.php");
    exit();
}
// Restrict access to logged-in users only
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // redirect to login if not logged in
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

$message = "";

// Handle confirmation
if (isset($_POST['confirm_delete'])) {
    // Delete image file if exists
    $imagePath = "../assets/images/events/" . $event['image'];
    if (!empty($event['image']) && file_exists($imagePath)) {
        unlink($imagePath);
    }

    // Delete event from DB
    $delete = $conn->prepare("DELETE FROM events WHERE id = ?");
    $delete->bind_param("i", $event_id);

    if ($delete->execute()) {
        header("Location: event.php?deleted=true");
        exit();
    } else {
        $message = "❌ Error deleting event: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Event | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png">
  <link rel="stylesheet" href="../assets/css/delete_event.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<!-- HEADER -->
<header class="navbar">
  <div class="logo">
    <img src="../assets/images/logo.png" alt="Logo">
    <h2>VEMS360</h2>
  </div>
  <nav class="nav-links">
    <a href="welcome.php">Home</a>
    <a href="about.php">About</a>
    <a href="event.php" class="active">Events</a>
    <a href="contact.php">Contact</a>
  </nav>
</header>

<!-- DELETE CONFIRMATION -->
<section class="delete-section">
  <div class="delete-container">
    <h1>Confirm Delete</h1>

    <?php if ($message): ?>
      <div class="message"><?= $message; ?></div>
    <?php endif; ?>

    <div class="event-summary">
      <?php
        $imagePath = "../assets/images/events/" . htmlspecialchars($event['image']);
        if (empty($event['image']) || !file_exists($imagePath)) {
          $imagePath = "../assets/images/default.jpg";
        }
      ?>
      <img src="<?= $imagePath; ?>" alt="<?= htmlspecialchars($event['title']); ?>">
      <h2><?= htmlspecialchars($event['title']); ?></h2>
      <p><i class="fa-solid fa-calendar-days"></i> <?= htmlspecialchars($event['date']); ?> </p>
      <p><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($event['location']); ?></p>
    </div>

    <p class="warning-text">Are you sure you want to permanently delete this event? This action cannot be undone.</p>

    <form method="POST" class="action-buttons">
      <button type="submit" name="confirm_delete" class="btn delete"><i class="fa-solid fa-trash"></i> Yes, Delete</button>
      <a href="event_details.php?id=<?= $event_id; ?>" class="btn cancel"><i class="fa-solid fa-xmark"></i> Cancel</a>
    </form>
  </div>
</section>

</body>
</html>
