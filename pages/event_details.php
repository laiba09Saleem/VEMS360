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

// Fetch event details from DB
$stmt = $conn->prepare("SELECT e.*, f.username 
                        FROM events e 
                        JOIN form f ON e.created_by = f.id 
                        WHERE e.id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<h2 style='text-align:center; color:white;'>Event not found.</h2>";
    exit();
}

$event = $result->fetch_assoc();
$stmt->close();

// Handle delete (optional for admin/creator)
if (isset($_POST['delete_event'])) {
    $delete = $conn->prepare("DELETE FROM events WHERE id = ?");
    $delete->bind_param("i", $event_id);
    $delete->execute();
    header("Location: event.php?deleted=true");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['title']); ?> | VEMS360</title>
    <link rel="icon" href="../assets/images/logo.png">
    <link rel="stylesheet" href="../assets/css/event_details.css">
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
    </nav>
</header>

<!-- HERO -->
<section class="hero">
    <div class="overlay"></div>
    <div class="hero-content">
        <h1><?= htmlspecialchars($event['title']); ?></h1>
        <p><i class="fa-solid fa-calendar-days"></i> <?= htmlspecialchars($event['date']); ?> &nbsp; | &nbsp;
        <i class="fa-solid fa-location-dot"></i> <?= htmlspecialchars($event['location']); ?></p>
    </div>
</section>

<!-- EVENT DETAILS -->
<section class="event-details">
    <div class="container">
        <div class="image-container">
            <?php
            $imagePath = "../assets/images/events/" . htmlspecialchars($event['image']);
            if (empty($event['image']) || !file_exists($imagePath)) {
                $imagePath = "../assets/images/default.jpg";
            }
            ?>
            <img src="<?= $imagePath; ?>" alt="<?= htmlspecialchars($event['title']); ?>" class="event-image">
        </div>

        <div class="details-content">
            <h2>Event Overview</h2>
            <p class="description"><?= nl2br(htmlspecialchars($event['description'])); ?></p>

            <div class="info-grid">
                <div><i class="fa-solid fa-layer-group"></i> <strong>Type:</strong> <?= htmlspecialchars($event['event_type']); ?></div>
                <div><i class="fa-solid fa-user"></i> <strong>Organizer:</strong> <?= htmlspecialchars($event['username']); ?></div>
                <div><i class="fa-solid fa-calendar"></i> <strong>Date:</strong> <?= htmlspecialchars($event['date']); ?></div>
                <div><i class="fa-solid fa-location-dot"></i> <strong>Location:</strong> <?= htmlspecialchars($event['location']); ?></div>
            </div>

            <div class="action-buttons">
    <a href="event.php" class="btn back"><i class="fa-solid fa-arrow-left"></i> Back to Events</a>

    <!-- Register Button -->
    <a href="register_event.php?id=<?= $event_id; ?>" class="btn register">
        <i class="fa-solid fa-ticket"></i> Register Now
    </a>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $event['created_by']): ?>
        <a href="edit_event.php?id=<?= $event_id; ?>" class="btn edit"><i class="fa-solid fa-pen"></i> Edit</a>
        <form method="POST" style="display:inline;">
            <button type="submit" name="delete_event" class="btn delete" onclick="return confirm('Are you sure you want to delete this event?');">
                <i class="fa-solid fa-trash"></i> Delete
            </button>
        </form>
    <?php endif; ?>
</div>

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

</body>
</html>
