<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

require_once '../includes/db_connect.php';

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Fetch user's registered events
$query_registered = "SELECT e.*, r.registration_date 
                     FROM events e 
                     INNER JOIN registrations r ON e.id = r.event_id 
                     WHERE r.user_id = ? 
                     ORDER BY e.event_date ASC, e.event_time ASC";
$stmt = $conn->prepare($query_registered);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$registered_events = $stmt->get_result();
$stmt->close();

// Fetch available upcoming events (not registered)
$query_available = "SELECT e.* FROM events e 
                    WHERE e.event_date >= CURDATE() 
                    AND e.id NOT IN (SELECT event_id FROM registrations WHERE user_id = ?)
                    ORDER BY e.event_date ASC, e.event_time ASC";
$stmt = $conn->prepare($query_available);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$available_events = $stmt->get_result();
$stmt->close();

$page_title = 'Dashboard';
$base_url = '..';
include '../includes/header.php';
?>

<div class="main-content">
    <div class="container">
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="dashboard-header">
            <h1>Welcome back, <?php echo htmlspecialchars($user_name); ?>! 👋</h1>
            <p>Manage your event registrations and discover new events</p>
        </div>

        <!-- Registered Events Section -->
        <section style="margin-bottom: 3rem;">
            <h2 class="section-title">My Registered Events</h2>

            <?php if ($registered_events && $registered_events->num_rows > 0): ?>
                <div class="events-grid">
                    <?php while ($event = $registered_events->fetch_assoc()): ?>
                        <div class="event-card">
                            <img src="../assets/images/<?php echo htmlspecialchars($event['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($event['title']); ?>" 
                                 class="event-image"
                                 onerror="this.src='../assets/images/default-event.jpg'">
                            
                            <div class="event-content">
                                <h3 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h3>
                                <p class="event-description"><?php echo htmlspecialchars($event['description']); ?></p>
                                
                                <div class="event-details">
                                    <div class="event-detail">
                                        <span>📅</span>
                                        <span><?php echo date('F d, Y', strtotime($event['event_date'])); ?></span>
                                    </div>
                                    <div class="event-detail">
                                        <span>🕐</span>
                                        <span><?php echo date('g:i A', strtotime($event['event_time'])); ?></span>
                                    </div>
                                    <div class="event-detail">
                                        <span>📍</span>
                                        <span><?php echo htmlspecialchars($event['location']); ?></span>
                                    </div>
                                    <div class="event-detail">
                                        <span>✅</span>
                                        <span>Registered on: <?php echo date('M d, Y', strtotime($event['registration_date'])); ?></span>
                                    </div>
                                </div>

                                <div class="event-actions">
                                    <a href="cancel_registration.php?event_id=<?php echo $event['id']; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Are you sure you want to cancel this registration?')">
                                        Cancel Registration
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="no-events">
                    <div class="no-events-icon">📝</div>
                    <h3>No Registered Events Yet</h3>
                    <p>Browse available events below to get started!</p>
                </div>
            <?php endif; ?>
        </section>

        <!-- Available Events Section -->
        <section>
            <h2 class="section-title">Available Events</h2>

            <?php if ($available_events && $available_events->num_rows > 0): ?>
                <div class="events-grid">
                    <?php while ($event = $available_events->fetch_assoc()): ?>
                        <div class="event-card">
                            <img src="../assets/images/<?php echo htmlspecialchars($event['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($event['title']); ?>" 
                                 class="event-image"
                                 onerror="this.src='../assets/images/default-event.jpg'">
                            
                            <div class="event-content">
                                <h3 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h3>
                                <p class="event-description"><?php echo htmlspecialchars($event['description']); ?></p>
                                
                                <div class="event-details">
                                    <div class="event-detail">
                                        <span>📅</span>
                                        <span><?php echo date('F d, Y', strtotime($event['event_date'])); ?></span>
                                    </div>
                                    <div class="event-detail">
                                        <span>🕐</span>
                                        <span><?php echo date('g:i A', strtotime($event['event_time'])); ?></span>
                                    </div>
                                    <div class="event-detail">
                                        <span>📍</span>
                                        <span><?php echo htmlspecialchars($event['location']); ?></span>
                                    </div>
                                    <div class="event-detail">
                                        <span>👥</span>
                                        <span>Capacity: <?php echo htmlspecialchars($event['capacity']); ?></span>
                                    </div>
                                </div>

                                <div class="event-actions">
                                    <a href="register_event.php?event_id=<?php echo $event['id']; ?>" 
                                       class="btn btn-primary">Register Now</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="no-events">
                    <div class="no-events-icon">🎉</div>
                    <h3>All Caught Up!</h3>
                    <p>You've registered for all available events. Check back later for more!</p>
                </div>
            <?php endif; ?>
        </section>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
