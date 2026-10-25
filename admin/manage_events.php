<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

require_once '../includes/db_connect.php';

// Fetch all events
$query = "SELECT * FROM events ORDER BY event_date DESC, event_time DESC";
$events = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events - Admin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
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

        <!-- Main Content -->
        <main class="admin-content">
            <div class="admin-header">
                <h1>Manage Events</h1>
                <p>View, edit, and delete events</p>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <div class="table-container">
                <div class="table-header">
                    <h2>All Events (<?php echo $events->num_rows; ?>)</h2>
                    <a href="add_event.php" class="btn btn-primary btn-sm">➕ Add New Event</a>
                </div>

                <?php if ($events && $events->num_rows > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Date & Time</th>
                                <th>Location</th>
                                <th>Capacity</th>
                                <th>Organizer</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($event = $events->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $event['id']; ?></td>
                                    <td>
                                        <img src="../assets/images/<?php echo htmlspecialchars($event['image']); ?>" 
                                             alt="<?php echo htmlspecialchars($event['title']); ?>"
                                             onerror="this.src='../assets/images/default-event.jpg'">
                                    </td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($event['title']); ?></strong><br>
                                        <small style="color: #6b7280;">
                                            <?php echo substr(htmlspecialchars($event['description']), 0, 50); ?>...
                                        </small>
                                    </td>
                                    <td>
                                        <?php echo date('M d, Y', strtotime($event['event_date'])); ?><br>
                                        <small><?php echo date('g:i A', strtotime($event['event_time'])); ?></small>
                                    </td>
                                    <td><?php echo htmlspecialchars($event['location']); ?></td>
                                    <td><?php echo $event['capacity']; ?></td>
                                    <td><?php echo htmlspecialchars($event['organizer']); ?></td>
                                    <td class="action-buttons">
                                        <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                                        <a href="delete_event.php?id=<?php echo $event['id']; ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirmDelete('Are you sure you want to delete this event? All related registrations will also be deleted.')">
                                            🗑️ Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div style="padding: 3rem; text-align: center; color: #6b7280;">
                        <div style="font-size: 4rem; margin-bottom: 1rem;">📅</div>
                        <h3>No Events Found</h3>
                        <p>Get started by adding your first event!</p>
                        <a href="add_event.php" class="btn btn-primary" style="margin-top: 1rem;">Add Event</a>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="../assets/js/main.js"></script>
</body>
</html>
