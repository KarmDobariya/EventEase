# EventEase - Quick Start Guide

## ⚡ 5-Minute Setup

### Step 1: Setup Database (2 minutes)
1. Start **XAMPP** and enable **Apache** and **MySQL**
2. Open **phpMyAdmin**: http://localhost/phpmyadmin
3. Click **Import** tab
4. Choose `database_setup.sql` file from project root
5. Click **Go** - Done! ✅

### Step 2: Move Project Files (1 minute)
Copy the entire **EventEase** folder to:
- **XAMPP**: `C:\xampp\htdocs\EventEase`
- **WAMP**: `C:\wamp64\www\EventEase`

### Step 3: Access Website (1 minute)
Open browser and visit:

**🌐 User Site**: http://localhost/EventEase/

**🔐 Admin Panel**: http://localhost/EventEase/admin/login.php
- Username: `admin`
- Password: `admin123`

---

## 🎯 What You Get

### ✅ Complete Features

**USER SIDE:**
- ✅ Homepage with all upcoming events
- ✅ User registration & login system
- ✅ Personal dashboard with registered events
- ✅ Event registration with duplicate prevention
- ✅ Cancel registration option
- ✅ About & Contact pages

**ADMIN SIDE:**
- ✅ Secure admin login (separate from users)
- ✅ Dashboard with live statistics
- ✅ Add new events with image upload
- ✅ Edit existing events
- ✅ Delete events (auto-removes registrations)
- ✅ View all registrations with search
- ✅ Event summary reports

### 🎨 Design Features
- ✅ Fully responsive (mobile, tablet, desktop)
- ✅ Modern gradient UI
- ✅ Form validation (client + server)
- ✅ Success/error alerts
- ✅ Smooth animations
- ✅ Dark admin theme

### 🔒 Security
- ✅ Password hashing (bcrypt)
- ✅ SQL injection protection (prepared statements)
- ✅ XSS protection
- ✅ Session security
- ✅ File upload validation

---

## 📝 Test the Website

### 1. Create User Account
1. Go to http://localhost/EventEase/register.php
2. Fill in your details
3. Click "Register"
4. Login with your credentials

### 2. Register for Events
1. Browse events on homepage
2. Click "Register" on any event
3. View your registrations in Dashboard
4. Try canceling a registration

### 3. Test Admin Panel
1. Go to http://localhost/EventEase/admin/login.php
2. Login (admin/admin123)
3. View statistics on dashboard
4. Add a new event with image
5. Check that event appears on user homepage
6. Edit or delete events
7. View all registrations

---

## 📂 Project Structure

```
EventEase/
├── 📄 index.php                 # Homepage
├── 📄 about.html               # About page  
├── 📄 contact.php              # Contact form
├── 📄 login.php                # User login
├── 📄 register.php             # User registration
├── 📄 logout.php               # Logout handler
│
├── 📁 user/                    # User features
│   ├── dashboard.php           # User dashboard
│   ├── register_event.php      # Register handler
│   └── cancel_registration.php # Cancel handler
│
├── 📁 admin/                   # Admin panel
│   ├── login.php               # Admin login
│   ├── dashboard.php           # Admin dashboard
│   ├── add_event.php           # Add event
│   ├── edit_event.php          # Edit event
│   ├── delete_event.php        # Delete handler
│   ├── manage_events.php       # Event list
│   ├── view_registrations.php  # Registrations
│   └── logout.php              # Admin logout
│
├── 📁 assets/
│   ├── 📁 css/
│   │   └── style.css           # Main styles
│   ├── 📁 js/
│   │   └── main.js             # JavaScript
│   └── 📁 images/              # Event images
│
├── 📁 includes/
│   ├── db_connect.php          # Database config
│   ├── header.php              # Header template
│   └── footer.php              # Footer template
│
├── 📄 database_setup.sql       # Database setup
├── 📄 README.md                # Full documentation
└── 📄 QUICKSTART.md            # This file
```

---

## 🛠️ Database Tables

The system uses 4 tables:

1. **users** - User accounts
2. **events** - Event information
3. **registrations** - User-event registrations
4. **admins** - Admin accounts

Sample data is included with 5 demo events!

---

## 🎓 Key Features Explained

### Duplicate Prevention
- Users can't register twice for same event
- Database constraint ensures data integrity

### Cascade Delete
- Deleting event removes all related registrations
- Keeps database clean automatically

### Real-time Updates
- Admin adds event → Appears on user homepage instantly
- No caching issues

### Image Upload
- Admins can upload event images
- Automatic filename generation
- Fallback to default image

### Search & Filter
- Admin can search registrations by:
  - Event name
  - User name
  - Email address

---

## 🐛 Common Issues

**"Connection failed"**
→ Check MySQL is running in XAMPP

**"Database not found"**
→ Import `database_setup.sql`

**"Can't upload image"**
→ Check `assets/images/` folder permissions

**"Blank page"**
→ Enable PHP error display in php.ini

---

## 🚀 Next Steps

1. ✅ Setup completed
2. ✅ Test all features
3. 📝 Customize design colors in `style.css`
4. 🖼️ Add your own event images
5. 🔐 Change admin password
6. 📧 Add email notifications (optional)

---

## 📞 Need Help?

Check the detailed **README.md** for:
- Full installation guide
- Troubleshooting section
- Security best practices
- Browser compatibility

---

**🎉 Enjoy EventEase!**

Built with ❤️ using PHP, MySQL, HTML, CSS & JavaScript
