<?php
session_start();
require_once __DIR__ . '/../config/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Redirect if event id missing
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: event.php");
    exit();
}

$event_id = intval($_GET['id']);
$message = "";

// Fetch existing event data and check ownership
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ? AND created_by = ?");
$stmt->bind_param("ii", $event_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<h2 style='text-align:center; color:red;'>You are not authorized to edit this event.</h2>";
    exit();
}

$event = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $event_type = mysqli_real_escape_string($conn, $_POST['event_type']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Image handling (optional)
    $image = $event['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $uploadDir = "../assets/images/events/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Remove old image if exists
            if (!empty($event['image']) && file_exists($uploadDir . $event['image'])) {
                unlink($uploadDir . $event['image']);
            }
            $image = $imageName;
        }
    }

    // Update query
    $update = $conn->prepare("UPDATE events SET title=?, event_type=?, location=?, date=?, description=?, image=? WHERE id=? AND created_by=?");
    $update->bind_param("ssssssii", $title, $event_type, $location, $date, $description, $image, $event_id, $user_id);

    if ($update->execute()) {
        $message = "✅ Event updated successfully!";
        $event = [
            'title' => $title,
            'event_type' => $event_type,
            'location' => $location,
            'date' => $date,
            'description' => $description,
            'image' => $image
        ];
    } else {
        $message = "❌ Error updating event: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Event | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png">
  <link rel="stylesheet" href="../assets/css/edit_event.css">
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

<!-- EDIT FORM -->
<section class="form-section">
  <div class="form-container">
    <h1>Edit Event</h1>

    <?php if ($message): ?>
      <div class="message"><?= $message; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
      <label>Event Title</label>
      <input type="text" name="title" value="<?= htmlspecialchars($event['title']); ?>" required>

      <label>Event Type</label>
      <select name="event_type" required>
        <option value="Virtual" <?= $event['event_type'] === 'Virtual' ? 'selected' : ''; ?>>Virtual</option>
        <option value="Hybrid" <?= $event['event_type'] === 'Hybrid' ? 'selected' : ''; ?>>Hybrid</option>
        <option value="Physical" <?= $event['event_type'] === 'Physical' ? 'selected' : ''; ?>>Physical</option>
      </select>

      <label>Location / Link</label>
      <input type="text" name="location" value="<?= htmlspecialchars($event['location']); ?>" required>

      <label>Date</label>
      <input type="date" name="date" value="<?= htmlspecialchars($event['date']); ?>" required>

      <label>Description</label>
      <textarea name="description" rows="4"><?= htmlspecialchars($event['description']); ?></textarea>

      <label>Current Image</label>
      <div class="current-image">
        <?php
          $imagePath = "../assets/images/events/" . htmlspecialchars($event['image']);
          if (empty($event['image']) || !file_exists($imagePath)) {
            $imagePath = "../assets/images/default.jpg";
          }
        ?>
        <img src="<?= $imagePath; ?>" alt="Current Event Image">
      </div>

      <label>Upload New Image (optional)</label>
      <input type="file" name="image" accept="image/*">

      <button type="submit" class="btn">Update Event</button>
    </form>
  </div>
</section>

</body>
</html>
