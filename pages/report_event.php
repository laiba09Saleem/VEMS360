<?php
require_once __DIR__ . '/../config/connection.php';
// Restrict access to logged-in users only
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // redirect to login if not logged in
    exit();
}

// Check event ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: event.php");
    exit();
}

$event_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$event) {
    echo "<h2 style='text-align:center; color:white;'>Event not found.</h2>";
    exit();
}

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reporter_name = trim($_POST['reporter_name']);
    $reporter_email = trim($_POST['reporter_email']);
    $reason = $_POST['reason'];
    $message = trim($_POST['message']);

    if (!empty($reporter_name) && !empty($reporter_email) && !empty($reason)) {
        $stmt = $conn->prepare("INSERT INTO event_reports (event_id, reporter_name, reporter_email, reason, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $event_id, $reporter_name, $reporter_email, $reason, $message);
        if ($stmt->execute()) {
            $success = "Thank you! Your report has been submitted successfully.";
        } else {
            $error = "Error submitting report. Please try again later.";
        }
        $stmt->close();
    } else {
        $error = "Please fill all required fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Report Event | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png">
  <link rel="stylesheet" href="../assets/css/report_event.css">
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
    <a href="event.php" class="active">Events</a>
    <a href="about.php">About</a>
    <a href="contact.php">Contact</a>
  </nav>
</header>

<section class="report-section">
  <div class="report-container">
    <h1>Report Event</h1>

    <?php if ($success): ?>
      <div class="alert success"><?= $success; ?></div>
    <?php elseif ($error): ?>
      <div class="alert error"><?= $error; ?></div>
    <?php endif; ?>

    <div class="event-preview">
      <img src="../assets/images/events/<?= htmlspecialchars($event['image']); ?>" alt="<?= htmlspecialchars($event['title']); ?>">
      <h2><?= htmlspecialchars($event['title']); ?></h2>
      <p><i class="fa-solid fa-calendar"></i> <?= htmlspecialchars($event['date']); ?></p>
      <p><i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($event['location']); ?></p>
    </div>

    <form method="POST" class="report-form">
      <label>Your Name *</label>
      <input type="text" name="reporter_name" required>

      <label>Your Email *</label>
      <input type="email" name="reporter_email" required>

      <label>Reason for Report *</label>
      <select name="reason" required>
        <option value="">-- Select Reason --</option>
        <option value="Spam">Spam</option>
        <option value="Fake Event">Fake Event</option>
        <option value="Inappropriate Content">Inappropriate Content</option>
        <option value="Other">Other</option>
      </select>

      <label>Additional Details</label>
      <textarea name="message" rows="5" placeholder="Describe the issue..."></textarea>

      <button type="submit" class="btn"><i class="fa-solid fa-flag"></i> Submit Report</button>
      <a href="event_details.php?id=<?= $event_id; ?>" class="btn cancel">Cancel</a>
    </form>
  </div>
</section>

</body>
</html>
