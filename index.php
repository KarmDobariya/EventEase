<?php
session_start();
require_once 'includes/db_connect.php';

// Fetch all upcoming events
$query = "SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date ASC, event_time ASC";
$result = $conn->query($query);

$page_title = 'Home';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Welcome to EventEase</h1>
        <p>Discover and register for amazing events happening near you</p>
    </div>
</section>

<!-- Main Content -->
<div class="main-content">
    <div class="container">
        <h2 class="section-title">Upcoming Events</h2>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="events-grid">
                <?php while ($event = $result->fetch_assoc()): ?>
                    <div class="event-card">
                        <img src="assets/images/<?php echo htmlspecialchars($event['image']); ?>" 
                             alt="<?php echo htmlspecialchars($event['title']); ?>" 
                             class="event-image"
                             onerror="this.src='assets/images/default-event.jpg'">
                        
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
                                <div class="event-detail">
                                    <span>🎯</span>
                                    <span>Organizer: <?php echo htmlspecialchars($event['organizer']); ?></span>
                                </div>
                            </div>

                            <div class="event-actions">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="user/register_event.php?event_id=<?php echo $event['id']; ?>" 
                                       class="btn btn-primary">Register</a>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-primary">Login to Register</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-events">
                <div class="no-events-icon">📅</div>
                <h3>No Upcoming Events</h3>
                <p>Check back later for new events!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
