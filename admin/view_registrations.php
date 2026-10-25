<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

require_once '../includes/db_connect.php';

// Get search query
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Fetch all registrations with user and event details using JOIN
$query = "SELECT r.id, r.registration_date, 
                 u.name as user_name, u.email as user_email, u.phone as user_phone,
                 e.title as event_title, e.event_date, e.event_time, e.location
          FROM registrations r
          INNER JOIN users u ON r.user_id = u.id
          INNER JOIN events e ON r.event_id = e.id";

if (!empty($search)) {
    $query .= " WHERE e.title LIKE ? OR u.name LIKE ? OR u.email LIKE ?";
}

$query .= " ORDER BY r.registration_date DESC";

if (!empty($search)) {
    $search_param = '%' . $search . '%';
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $search_param, $search_param, $search_param);
    $stmt->execute();
    $registrations = $stmt->get_result();
} else {
    $registrations = $conn->query($query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registrations - Admin</title>
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
                <li><a href="manage_events.php">🎫 Manage Events</a></li>
                <li><a href="view_registrations.php" class="active">👥 View Registrations</a></li>
                <li><a href="logout.php">🚪 Logout</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="admin-content">
            <div class="admin-header">
                <h1>Event Registrations</h1>
                <p>View all user registrations for events</p>
            </div>

            <!-- Search Bar -->
            <form method="GET" action="" class="search-bar">
                <input type="text" name="search" id="searchInput" class="search-input" 
                       placeholder="Search by event name, user name, or email..." 
                       value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary">🔍 Search</button>
                <?php if (!empty($search)): ?>
                    <a href="view_registrations.php" class="btn btn-outline">Clear</a>
                <?php endif; ?>
            </form>

            <div class="table-container">
                <div class="table-header">
                    <h2>All Registrations (<?php echo $registrations->num_rows; ?>)</h2>
                </div>

                <?php if ($registrations && $registrations->num_rows > 0): ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Event Title</th>
                                <th>Event Date</th>
                                <th>Event Time</th>
                                <th>Location</th>
                                <th>Registered On</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($reg = $registrations->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $reg['id']; ?></td>
                                    <td><strong><?php echo htmlspecialchars($reg['user_name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($reg['user_email']); ?></td>
                                    <td><?php echo htmlspecialchars($reg['user_phone']); ?></td>
                                    <td><strong><?php echo htmlspecialchars($reg['event_title']); ?></strong></td>
                                    <td><?php echo date('M d, Y', strtotime($reg['event_date'])); ?></td>
                                    <td><?php echo date('g:i A', strtotime($reg['event_time'])); ?></td>
                                    <td><?php echo htmlspecialchars($reg['location']); ?></td>
                                    <td><?php echo date('M d, Y g:i A', strtotime($reg['registration_date'])); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div style="padding: 3rem; text-align: center; color: #6b7280;">
                        <div style="font-size: 4rem; margin-bottom: 1rem;">👥</div>
                        <h3><?php echo !empty($search) ? 'No Registrations Found' : 'No Registrations Yet'; ?></h3>
                        <p><?php echo !empty($search) ? 'Try a different search term' : 'Registrations will appear here once users start signing up'; ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Summary by Event -->
            <?php
            $summary_query = "SELECT e.title, e.event_date, COUNT(r.id) as total_registrations
                             FROM events e
                             LEFT JOIN registrations r ON e.id = r.event_id
                             GROUP BY e.id
                             HAVING total_registrations > 0
                             ORDER BY total_registrations DESC";
            $summary_result = $conn->query($summary_query);
            ?>

            <?php if ($summary_result && $summary_result->num_rows > 0): ?>
                <div class="table-container" style="margin-top: 2rem;">
                    <div class="table-header">
                        <h2>Registrations Summary by Event</h2>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Event Title</th>
                                <th>Event Date</th>
                                <th>Total Registrations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($summary = $summary_result->fetch_assoc()): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($summary['title']); ?></strong></td>
                                    <td><?php echo date('M d, Y', strtotime($summary['event_date'])); ?></td>
                                    <td><strong style="color: #6366f1; font-size: 1.2rem;"><?php echo $summary['total_registrations']; ?></strong></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <script src="../assets/js/main.js"></script>
</body>
</html>
