<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

require_once '../includes/db_connect.php';

$user_id = $_SESSION['user_id'];
$event_id = isset($_GET['event_id']) ? intval($_GET['event_id']) : 0;

if ($event_id <= 0) {
    $_SESSION['error'] = 'Invalid event ID';
    header('Location: dashboard.php');
    exit();
}

// Check if event exists
$stmt = $conn->prepare("SELECT id, title FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = 'Event not found';
    $stmt->close();
    header('Location: dashboard.php');
    exit();
}

$event = $result->fetch_assoc();
$stmt->close();

// Check if already registered (prevent duplicates)
$stmt = $conn->prepare("SELECT id FROM registrations WHERE user_id = ? AND event_id = ?");
$stmt->bind_param("ii", $user_id, $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['error'] = 'You are already registered for this event';
    $stmt->close();
    header('Location: dashboard.php');
    exit();
}
$stmt->close();

// Register user for event
$stmt = $conn->prepare("INSERT INTO registrations (user_id, event_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $event_id);

if ($stmt->execute()) {
    $_SESSION['success'] = 'Successfully registered for: ' . htmlspecialchars($event['title']);
} else {
    $_SESSION['error'] = 'Registration failed. Please try again.';
}

$stmt->close();
header('Location: dashboard.php');
exit();
?>
