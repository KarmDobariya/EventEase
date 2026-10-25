<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

require_once '../includes/db_connect.php';

$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$error = '';
$success = '';

// Fetch event details
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = 'Event not found';
    header('Location: manage_events.php');
    exit();
}

$event = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = trim($_POST['location']);
    $capacity = intval($_POST['capacity']);
    $organizer = trim($_POST['organizer']);
    $image_name = $event['image'];
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = $_FILES['image']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image_name = 'event_' . time() . '_' . rand(1000, 9999) . '.' . $file_extension;
            $upload_path = '../assets/images/' . $image_name;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                // Delete old image if not default
                if ($event['image'] !== 'default-event.jpg' && file_exists('../assets/images/' . $event['image'])) {
                    unlink('../assets/images/' . $event['image']);
                }
            }
        }
    }
    
    // Update event
    $stmt = $conn->prepare("UPDATE events SET title = ?, description = ?, event_date = ?, event_time = ?, location = ?, capacity = ?, organizer = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sssssiisi", $title, $description, $event_date, $event_time, $location, $capacity, $organizer, $image_name, $event_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = 'Event updated successfully!';
        header('Location: manage_events.php');
        exit();
    } else {
        $error = 'Failed to update event';
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <h2>🎉 EventEase</h2>
            <ul class="admin-menu">
                <li><a href="dashboard.php">📊 Dashboard</a></li>
                <li><a href="add_event.php">➕ Add Event</a></li>
                <li><a href="manage_events.php" class="active">🎫 Manage Events</a></li>
                <li><a href="view_registrations.php">👥 View Registrations</a></li>
                <li><a href="logout.php">🚪 Logout</a></li>
            </ul>
        </aside>

        <main class="admin-content">
            <div class="admin-header">
                <h1>Edit Event</h1>
                <p>Update event information</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Event Title *</label>
                        <input type="text" id="title" name="title" class="form-control" required
                               value="<?php echo htmlspecialchars($event['title']); ?>">
                    </div>

                    <div class="form-group">
                        <label for="description">Description *</label>
                        <textarea id="description" name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($event['description']); ?></textarea>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label for="event_date">Event Date *</label>
                            <input type="date" id="event_date" name="event_date" class="form-control" required
                                   value="<?php echo $event['event_date']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="event_time">Event Time *</label>
                            <input type="time" id="event_time" name="event_time" class="form-control" required
                                   value="<?php echo $event['event_time']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location">Location *</label>
                        <input type="text" id="location" name="location" class="form-control" required
                               value="<?php echo htmlspecialchars($event['location']); ?>">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label for="capacity">Capacity *</label>
                            <input type="number" id="capacity" name="capacity" class="form-control" min="1" required
                                   value="<?php echo $event['capacity']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="organizer">Organizer *</label>
                            <input type="text" id="organizer" name="organizer" class="form-control" required
                                   value="<?php echo htmlspecialchars($event['organizer']); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image">Event Image</label>
                        <div style="margin-bottom: 1rem;">
                            <img src="../assets/images/<?php echo htmlspecialchars($event['image']); ?>" 
                                 alt="Current image" style="max-width: 200px; border-radius: 5px;"
                                 onerror="this.src='../assets/images/default-event.jpg'">
                        </div>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*">
                        <small style="color: #6b7280;">Upload new image to replace current one</small>
                    </div>

                    <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary">Update Event</button>
                        <a href="manage_events.php" class="btn btn-outline">Cancel</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="../assets/js/main.js"></script>
</body>
</html>
