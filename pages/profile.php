<?php
session_start();
require_once __DIR__ . '/../config/connection.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$stmt = $conn->prepare("SELECT id, username, fullname, email, role, profile_image, created_at FROM form WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch user events (if organizer)
$events = [];
$event_stmt = $conn->prepare("SELECT * FROM events WHERE created_by = ? ORDER BY id DESC");
$event_stmt->bind_param("i", $user_id);
$event_stmt->execute();
$event_result = $event_stmt->get_result();
while($row = $event_result->fetch_assoc()) {
    $events[] = $row;
}
$event_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile | VEMS360</title>
<link rel="icon" href="../assets/images/logo.png">
<link rel="stylesheet" href="../assets/css/profile.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
    <div class="navbar-container">
        <div class="logo">
            <a href="welcome.php">
                <img src="../assets/images/logo.png" alt="VEMS360 Logo">
                <h2>VEMS360</h2>
            </a>
        </div>
        <nav class="nav-links">
            <a href="welcome.php">Home</a>
            <a href="about.php">About</a>
            <a href="event.php">Events</a>
            <a href="contact.php">Contact</a>
            <a href="profile.php" class="active">Profile</a>
        </nav>
        <div class="nav-btns">
            <a href="logout.php" class="btn outline"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>
        <div class="hamburger"><i class="fa fa-bars"></i></div>
    </div>
</header>

<!-- PROFILE SECTION -->
<section class="profile-section">
    <div class="container">

        <!-- PROFILE INFO -->
        <div class="profile-card">
            <div class="profile-image">
                <?php
                $profile_image = !empty($user['profile_image']) && file_exists("../uploads/profiles/" . $user['profile_image']) 
                                 ? "../uploads/profiles/" . $user['profile_image'] 
                                 : "../assets/images/default_user.png";
                ?>
                <img src="<?= htmlspecialchars($profile_image); ?>" alt="Profile Picture">
            </div>
            <div class="profile-info">
                <h2><?= htmlspecialchars($user['username'] ?? 'User'); ?></h2>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email'] ?? 'N/A'); ?></p>
                <p><strong>Full Name:</strong> <?= htmlspecialchars($user['fullname'] ?? 'N/A'); ?></p>
                <p><strong>Role:</strong> <?= htmlspecialchars($user['role'] ?? 'User'); ?></p>
                <p><strong>Joined:</strong> <?= !empty($user['created_at']) ? date("F j, Y", strtotime($user['created_at'])) : 'N/A'; ?></p>
            </div>
        </div>

        <!-- EDIT PROFILE FORM -->
        <div class="edit-card">
            <h3>Edit Profile</h3>
            <form action="update_profile.php" method="POST" enctype="multipart/form-data">
                <label>Full Name</label>
                <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname'] ?? ''); ?>" required>

                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? ''); ?>" required>

                <label>Password <small>(Leave blank to keep current)</small></label>
                <input type="password" name="password" placeholder="New password">

                <label>Profile Image</label>
                <input type="file" name="profile_image" accept="image/*">

                <button type="submit" class="btn primary"><i class="fa-solid fa-pen"></i> Update Profile</button>
            </form>
        </div>

        <!-- USER EVENTS -->
        <?php if(!empty($events)): ?>
        <div class="user-events">
            <h3>My Created Events</h3>
            <div class="event-grid">
                <?php foreach($events as $event): 
                    $event_image = !empty($event['image']) && file_exists("../assets/images/events/" . $event['image']) 
                                   ? "../assets/images/events/" . $event['image'] 
                                   : "../assets/images/default.jpg";
                ?>
                <div class="event-card">
                    <img src="<?= htmlspecialchars($event_image); ?>" alt="<?= htmlspecialchars($event['title']); ?>">
                    <div class="event-content">
                        <h4><?= htmlspecialchars($event['title']); ?></h4>
                        <p><i class="fa-solid fa-calendar-days"></i> <?= htmlspecialchars($event['date']); ?></p>
                        <a href="event_details.php?id=<?= $event['id']; ?>" class="btn outline">View Details</a>

                        <!-- Edit button shown only for events created by this user -->
                        <?php if($event['created_by'] == $user_id): ?>
                            <a href="edit_event.php?id=<?= $event['id']; ?>" class="btn primary" title="Edit Event ID: <?= $event['id']; ?>">Edit</a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

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
