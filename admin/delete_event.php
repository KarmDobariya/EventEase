<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

require_once '../includes/db_connect.php';

$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($event_id <= 0) {
    $_SESSION['error'] = 'Invalid event ID';
    header('Location: manage_events.php');
    exit();
}

// Get event details for confirmation
$stmt = $conn->prepare("SELECT title, image FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = 'Event not found';
    $stmt->close();
    header('Location: manage_events.php');
    exit();
}

$event = $result->fetch_assoc();
$stmt->close();

// Delete event (CASCADE will delete related registrations)
$stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);

if ($stmt->execute()) {
    // Delete event image if not default
    if ($event['image'] !== 'default-event.jpg' && file_exists('../assets/images/' . $event['image'])) {
        unlink('../assets/images/' . $event['image']);
    }
    
    $_SESSION['success'] = 'Event "' . htmlspecialchars($event['title']) . '" deleted successfully';
} else {
    $_SESSION['error'] = 'Failed to delete event';
}

$stmt->close();
header('Location: manage_events.php');
exit();
?>
