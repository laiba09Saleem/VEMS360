<?php
session_start();
require_once __DIR__ . '/../config/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Handle profile image upload
    $profile_image = "";
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $uploadDir = "../uploads/profiles/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $profile_image = time() . "_" . basename($_FILES['profile_image']['name']);
        $targetFile = $uploadDir . $profile_image;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile);
    }

    // Update SQL
    $sql = "UPDATE form SET fullname=?, email=?";
    $params = [$fullname, $email];
    $types = "ss";

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql .= ", password=?";
        $types .= "s";
        $params[] = $hashed_password;
    }

    if (!empty($profile_image)) {
        $sql .= ", profile_image=?";
        $types .= "s";
        $params[] = $profile_image;
    }

    $sql .= " WHERE id=?";
    $types .= "i";
    $params[] = $user_id;

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    if ($stmt->execute()) {
        header("Location: profile.php?updated=true");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
