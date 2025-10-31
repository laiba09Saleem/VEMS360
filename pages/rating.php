<?php
require_once __DIR__ . '/../config/connection.php';
// Restrict access to logged-in users only
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // redirect to login if not logged in
    exit();
}

// Fetch events for dropdown
$events = $conn->query("SELECT id, title FROM events ORDER BY id DESC");

// Handle rating submission
$success = $error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = intval($_POST['event_id']);
    $user_name = trim($_POST['user_name']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);

    if ($event_id && $user_name && $rating > 0) {
        $stmt = $conn->prepare("INSERT INTO event_ratings (event_id, user_name, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $event_id, $user_name, $rating, $comment);
        if ($stmt->execute()) {
            $success = "Thank you for your feedback!";
        } else {
            $error = "Error submitting rating. Please try again.";
        }
        $stmt->close();
    } else {
        $error = "Please fill all required fields.";
    }
}

// Fetch average ratings
$avgRatings = $conn->query("
    SELECT e.id, e.title, ROUND(AVG(r.rating),1) AS avg_rating, COUNT(r.id) AS total_reviews
    FROM events e
    LEFT JOIN event_ratings r ON e.id = r.event_id
    GROUP BY e.id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ratings | VEMS360</title>
  <link rel="icon" href="../assets/images/logo.png">
  <link rel="stylesheet" href="../assets/css/rating.css">
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
    <a href="event.php">Events</a>
    <a href="rating.php" class="active">Ratings</a>
    <a href="contact.php">Contact</a>
  </nav>
</header>

<section class="rating-section">
  <div class="container">
    <h1>Rate an Event</h1>

    <?php if ($success): ?>
      <div class="alert success"><?= $success; ?></div>
    <?php elseif ($error): ?>
      <div class="alert error"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST" class="rating-form">
      <label>Select Event *</label>
      <select name="event_id" required>
        <option value="">-- Select Event --</option>
        <?php while ($row = $events->fetch_assoc()): ?>
          <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['title']); ?></option>
        <?php endwhile; ?>
      </select>

      <label>Your Name *</label>
      <input type="text" name="user_name" required>

      <label>Rating *</label>
      <div class="stars">
        <?php for ($i=1; $i<=5; $i++): ?>
          <input type="radio" id="star<?= $i; ?>" name="rating" value="<?= $i; ?>" required>
          <label for="star<?= $i; ?>"><i class="fa-solid fa-star"></i></label>
        <?php endfor; ?>
      </div>

      <label>Comment</label>
      <textarea name="comment" rows="4" placeholder="Write your feedback..."></textarea>

      <button type="submit" class="btn"><i class="fa-solid fa-paper-plane"></i> Submit Rating</button>
    </form>

    <h2 class="section-title">Event Ratings Overview</h2>
    <div class="rating-list">
      <?php while ($r = $avgRatings->fetch_assoc()): ?>
        <div class="rating-card">
          <h3><?= htmlspecialchars($r['title']); ?></h3>
          <p><strong>Average:</strong> <?= $r['avg_rating'] ? $r['avg_rating'] : 'No Ratings Yet'; ?></p>
          <p><i class="fa-solid fa-users"></i> <?= $r['total_reviews']; ?> Reviews</p>
        </div>
      <?php endwhile; ?>
    </div>

  </div>
</section>

</body>
</html>
