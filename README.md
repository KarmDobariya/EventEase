# EventEase - Event Registration Website

A complete responsive event registration and management system built with HTML, CSS, JavaScript, and PHP with MySQL database.

CI/CD demonstration verified on Windows Docker Desktop.

## 🚀 Features

### User Side
- **Browse Events**: View all upcoming events with details
- **User Registration & Login**: Secure authentication with password hashing
- **User Dashboard**: Manage registered events and browse available events
- **Event Registration**: Register for events with duplicate prevention
- **Cancel Registration**: Option to cancel event registrations
- **Responsive Design**: Works seamlessly on all devices

### Admin Side
- **Secure Admin Login**: Separate admin authentication
- **Admin Dashboard**: View statistics (total events, users, registrations)
- **Add Events**: Create new events with image upload
- **Manage Events**: Edit and delete existing events
- **View Registrations**: See all registrations with search/filter functionality
- **Real-time Updates**: Events instantly appear on user side after creation

## 📁 Folder Structure

```
EventEase/
├── index.php                    # Homepage with all events
├── about.html                   # About page
├── contact.php                  # Contact form
├── login.php                    # User login
├── register.php                 # User registration
├── logout.php                   # User logout
├── user/
│   ├── dashboard.php           # User dashboard
│   ├── register_event.php      # Event registration handler
│   └── cancel_registration.php # Cancel registration handler
├── admin/
│   ├── login.php               # Admin login
│   ├── dashboard.php           # Admin dashboard
│   ├── add_event.php           # Add new event
│   ├── edit_event.php          # Edit event
│   ├── delete_event.php        # Delete event handler
│   ├── manage_events.php       # Manage all events
│   ├── view_registrations.php  # View all registrations
│   └── logout.php              # Admin logout
├── assets/
│   ├── css/
│   │   └── style.css           # Main stylesheet
│   ├── js/
│   │   └── main.js             # JavaScript for interactivity
│   └── images/                 # Event images folder
├── includes/
│   ├── db_connect.php          # Database connection
│   ├── header.php              # Header template
│   └── footer.php              # Footer template
└── README.md                   # This file
```

## 🛠️ Installation & Setup

### Prerequisites
- XAMPP/WAMP/MAMP (Apache + MySQL + PHP)
- Web browser
- Text editor (optional)

### Step 1: Setup Database

1. Start Apache and MySQL from XAMPP/WAMP control panel
2. Open phpMyAdmin (http://localhost/phpmyadmin)
3. Create a new database named `eventease`
4. Run the following SQL queries:

```sql
-- Create Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Events table
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    capacity INT NOT NULL,
    organizer VARCHAR(100) NOT NULL,
    image VARCHAR(255) DEFAULT 'default-event.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Registrations table
CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    UNIQUE KEY unique_registration (user_id, event_id)
);

-- Create Admins table
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin account
-- Username: admin
-- Password: admin123
INSERT INTO admins (username, password, email) 
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@eventease.com');
```

### Step 2: Configure Database Connection

1. Open `includes/db_connect.php`
2. Update database credentials if needed:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'eventease');
```

### Step 3: Setup Project Files

1. Copy the EventEase folder to your web server directory:
   - XAMPP: `C:\xampp\htdocs\EventEase`
   - WAMP: `C:\wamp64\www\EventEase`
   - MAMP: `/Applications/MAMP/htdocs/EventEase`

2. Create a placeholder image for events (optional):
   - Add `default-event.jpg` to `assets/images/` folder
   - Or the system will show a fallback message

### Step 4: Access the Website

1. Open your browser and navigate to:
   - **Homepage**: http://localhost/EventEase/
   - **Admin Panel**: http://localhost/EventEase/admin/login.php

2. **Admin Login Credentials**:
   - Username: `admin`
   - Password: `admin123`

## 📝 Usage Guide

### For Users:

1. **Register**: Create an account at `/register.php`
2. **Login**: Sign in with your credentials at `/login.php`
3. **Browse Events**: View all available events on the homepage
4. **Register for Events**: Click "Register" button on any event
5. **Manage Registrations**: View and cancel registrations from your dashboard

### For Admins:

1. **Login**: Access admin panel at `/admin/login.php`
2. **View Dashboard**: See statistics and recent events
3. **Add Event**: Fill out the event form with all details and upload an image
4. **Manage Events**: Edit or delete existing events
5. **View Registrations**: See all user registrations with search functionality

## 🔒 Security Features

- **Password Hashing**: Uses PHP's `password_hash()` for secure password storage
- **Prepared Statements**: All database queries use prepared statements to prevent SQL injection
- **Session Management**: Secure session handling for user and admin authentication
- **Input Validation**: Client-side and server-side validation for all forms
- **XSS Protection**: Uses `htmlspecialchars()` for output escaping
- **File Upload Security**: Validates file types and generates unique filenames

## 🎨 Design Features

- **Modern UI**: Clean and professional design with gradient colors
- **Responsive Layout**: Mobile-first design that works on all screen sizes
- **Interactive Elements**: Smooth animations and transitions
- **Form Validation**: Real-time JavaScript validation with visual feedback
- **Alert Messages**: Success/error notifications with auto-hide
- **Dark Admin Theme**: Distinct styling for admin panel

## 🔧 Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript (ES6)
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Server**: Apache
- **Architecture**: MVC-inspired structure with includes

## 📱 Browser Compatibility

- Chrome (recommended)
- Firefox
- Safari
- Edge
- Opera

## 🐛 Troubleshooting

### Database Connection Error
- Verify MySQL is running
- Check database credentials in `includes/db_connect.php`
- Ensure database `eventease` exists

### Image Upload Issues
- Check `assets/images/` folder has write permissions
- Verify PHP `upload_max_filesize` in php.ini

### Session Issues
- Clear browser cookies
- Check PHP session configuration
- Ensure session save path is writable

## 📄 License

This project is created for educational purposes.

## 👨‍💻 Developer Notes

- Events are automatically shown on user side after admin creates them
- Deleting an event removes all related registrations (CASCADE)
- Duplicate registrations are prevented by database constraint
- Images are uploaded to `assets/images/` with unique names
- Default admin password should be changed in production

## 🆘 Support

For issues or questions, please check the code comments or contact the development team.

---

**EventEase** - Making event registration easy! 🎉
