<?php
session_start();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Basic validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'All fields are required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format';
    } else {
        // In a real application, you would send an email here
        // For now, we'll just show a success message
        $success = 'Thank you for contacting us! We will get back to you soon.';
        
        // Clear form data
        $_POST = array();
    }
}

$page_title = 'Contact Us';
include 'includes/header.php';
?>

<section class="hero">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you!</p>
    </div>
</section>

<div class="main-content">
    <div class="container">
        <div class="form-container">
            <h2 class="form-title">Get in Touch</h2>

            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" action="" id="contactForm">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" class="form-control" required 
                           value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" class="form-control" required 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" class="form-control" required 
                           value="<?php echo isset($_POST['subject']) ? htmlspecialchars($_POST['subject']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" class="form-control" rows="5" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Send Message</button>
            </form>

            <div style="margin-top: 3rem; padding: 2rem; background: #f9fafb; border-radius: 10px;">
                <h3 style="margin-bottom: 1rem;">Other Ways to Reach Us</h3>
                <p style="margin-bottom: 0.5rem;"><strong>📧 Email:</strong> info@eventease.com</p>
                <p style="margin-bottom: 0.5rem;"><strong>📞 Phone:</strong> +1 234 567 8900</p>
                <p style="margin-bottom: 0.5rem;"><strong>📍 Address:</strong> 123 Event Street, City, Country</p>
                <p style="margin-bottom: 0.5rem;"><strong>🕐 Business Hours:</strong> Mon-Fri, 9:00 AM - 6:00 PM</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
