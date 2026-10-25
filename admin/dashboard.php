<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

require_once '../includes/db_connect.php';

// Fetch statistics
$stats = [
    'total_events' => 0,
    'total_users' => 0,
    'total_registrations' => 0,
    'upcoming_events' => 0
];

// Total events
$result = $conn->query("SELECT COUNT(*) as count FROM events");
$stats['total_events'] = $result->fetch_assoc()['count'];

// Total users
$result = $conn->query("SELECT COUNT(*) as count FROM users");
$stats['total_users'] = $result->fetch_assoc()['count'];

// Total registrations
$result = $conn->query("SELECT COUNT(*) as count FROM registrations");
$stats['total_registrations'] = $result->fetch_assoc()['count'];

// Upcoming events
$result = $conn->query("SELECT COUNT(*) as count FROM events WHERE event_date >= CURDATE()");
$stats['upcoming_events'] = $result->fetch_assoc()['count'];

// Fetch recent events
$recent_events = $conn->query("SELECT * FROM events ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - EventEase</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <h2>🎉 EventEase</h2>
            <ul class="admin-menu">
                <li><a href="dashboard.php" class="active">📊 Dashboard</a></li>
                <li><a href="add_event.php">➕ Add Event</a></li>
                <li><a href="manage_events.php">🎫 Manage Events</a></li>
                <li><a href="view_registrations.php">👥 View Registrations</a></li>
                <li><a href="logout.php">🚪 Logout</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="admin-content">
            <div class="admin-header">
                <h1>Admin Dashboard</h1>
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</p>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <!-- Statistics Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <div class="stat-value"><?php echo $stats['total_events']; ?></div>
                    <div class="stat-label">Total Events</div>
                    <a href="manage_events.php" style="margin-top: 1rem; display: inline-block; color: #6366f1; text-decoration: none;">View All →</a>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">👤</div>
                    <div class="stat-value"><?php echo $stats['total_users']; ?></div>
                    <div class="stat-label">Registered Users</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">✅</div>
                    <div class="stat-value"><?php echo $stats['total_registrations']; ?></div>
                    <div class="stat-label">Total Registrations</div>
                    <a href="view_registrations.php" style="margin-top: 1rem; display: inline-block; color: #6366f1; text-decoration: none;">View All →</a>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">🚀</div>
                    <div class="stat-value"><?php echo $stats['upcoming_events']; ?></div>
                    <div class="stat-label">Upcoming Events</div>
                </div>
            </div>

            <!-- Recent Events -->
            <div class="table-container">
                <div class="table-header">
                    <h2>Recent Events</h2>
                    <a href="add_event.php" class="btn btn-primary btn-sm">Add New Event</a>
                </div>

                <?php if ($recent_events && $recent_events->num_rows > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th>Location</th>
                                <th>Capacity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($event = $recent_events->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <img src="../assets/images/<?php echo htmlspecialchars($event['image']); ?>" 
                                             alt="<?php echo htmlspecialchars($event['title']); ?>"
                                             onerror="this.src='../assets/images/default-event.jpg'">
                                    </td>
                                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($event['event_date'])); ?></td>
                                    <td><?php echo htmlspecialchars($event['location']); ?></td>
                                    <td><?php echo htmlspecialchars($event['capacity']); ?></td>
                                    <td class="action-buttons">
                                        <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="delete_event.php?id=<?php echo $event['id']; ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirmDelete('Are you sure you want to delete this event?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div style="padding: 3rem; text-align: center; color: #6b7280;">
                        <p>No events found. <a href="add_event.php">Add your first event</a></p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script src="../assets/js/main.js"></script>
</body>
</html>
