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

// Get event title for success message
$stmt = $conn->prepare("SELECT e.title FROM events e 
                        INNER JOIN registrations r ON e.id = r.event_id 
                        WHERE r.user_id = ? AND r.event_id = ?");
$stmt->bind_param("ii", $user_id, $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = 'Registration not found';
    $stmt->close();
    header('Location: dashboard.php');
    exit();
}

$event = $result->fetch_assoc();
$stmt->close();

// Cancel registration
$stmt = $conn->prepare("DELETE FROM registrations WHERE user_id = ? AND event_id = ?");
$stmt->bind_param("ii", $user_id, $event_id);

if ($stmt->execute()) {
    $_SESSION['success'] = 'Successfully cancelled registration for: ' . htmlspecialchars($event['title']);
} else {
    $_SESSION['error'] = 'Failed to cancel registration. Please try again.';
}

$stmt->close();
header('Location: dashboard.php');
exit();
?>
