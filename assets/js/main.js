/**
 * EventEase - Main JavaScript File
 * Handles client-side interactivity and form validation
 */

// Mobile Navigation Toggle
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('navMenu');

    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function() {
            navMenu.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (!hamburger.contains(event.target) && !navMenu.contains(event.target)) {
                navMenu.classList.remove('active');
            }
        });
    }

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });
});

/**
 * Form Validation
 */
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;

    let isValid = true;
    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');

    inputs.forEach(function(input) {
        if (!input.value.trim()) {
            input.style.borderColor = '#ef4444';
            isValid = false;
        } else {
            input.style.borderColor = '#e5e7eb';
        }
    });

    return isValid;
}

/**
 * Email Validation
 */
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}

/**
 * Registration Form Validation
 */
const registerForm = document.getElementById('registerForm');
if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const phone = document.getElementById('phone');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');

        let isValid = true;

        // Reset borders
        [name, email, phone, password, confirmPassword].forEach(input => {
            if (input) input.style.borderColor = '#e5e7eb';
        });

        // Validate name
        if (name && name.value.trim().length < 2) {
            name.style.borderColor = '#ef4444';
            isValid = false;
            showAlert('Name must be at least 2 characters long', 'error');
        }

        // Validate email
        if (email && !validateEmail(email.value)) {
            email.style.borderColor = '#ef4444';
            isValid = false;
            showAlert('Please enter a valid email address', 'error');
        }

        // Validate phone
        if (phone && phone.value.trim().length < 10) {
            phone.style.borderColor = '#ef4444';
            isValid = false;
            showAlert('Please enter a valid phone number', 'error');
        }

        // Validate password
        if (password && password.value.length < 6) {
            password.style.borderColor = '#ef4444';
            isValid = false;
            showAlert('Password must be at least 6 characters long', 'error');
        }

        // Validate password match
        if (confirmPassword && password && confirmPassword.value !== password.value) {
            confirmPassword.style.borderColor = '#ef4444';
            isValid = false;
            showAlert('Passwords do not match', 'error');
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
}

/**
 * Login Form Validation
 */
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        const email = document.getElementById('email');
        const password = document.getElementById('password');

        let isValid = true;

        if (email) email.style.borderColor = '#e5e7eb';
        if (password) password.style.borderColor = '#e5e7eb';

        if (email && !validateEmail(email.value)) {
            email.style.borderColor = '#ef4444';
            isValid = false;
            showAlert('Please enter a valid email address', 'error');
        }

        if (password && password.value.length === 0) {
            password.style.borderColor = '#ef4444';
            isValid = false;
            showAlert('Password is required', 'error');
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
}

/**
 * Event Form Validation (Admin)
 */
const eventForm = document.getElementById('eventForm');
if (eventForm) {
    eventForm.addEventListener('submit', function(e) {
        const title = document.getElementById('title');
        const description = document.getElementById('description');
        const eventDate = document.getElementById('event_date');
        const eventTime = document.getElementById('event_time');
        const location = document.getElementById('location');
        const capacity = document.getElementById('capacity');
        const organizer = document.getElementById('organizer');

        let isValid = true;

        // Reset borders
        [title, description, eventDate, eventTime, location, capacity, organizer].forEach(input => {
            if (input) input.style.borderColor = '#e5e7eb';
        });

        // Validate all required fields
        if (title && title.value.trim().length < 5) {
            title.style.borderColor = '#ef4444';
            isValid = false;
            showAlert('Event title must be at least 5 characters long', 'error');
        }

        if (description && description.value.trim().length < 20) {
            description.style.borderColor = '#ef4444';
            isValid = false;
            showAlert('Event description must be at least 20 characters long', 'error');
        }

        if (capacity && (capacity.value < 1 || capacity.value > 10000)) {
            capacity.style.borderColor = '#ef4444';
            isValid = false;
            showAlert('Capacity must be between 1 and 10000', 'error');
        }

        // Validate date is in future
        if (eventDate) {
            const selectedDate = new Date(eventDate.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (selectedDate < today) {
                eventDate.style.borderColor = '#ef4444';
                isValid = false;
                showAlert('Event date must be in the future', 'error');
            }
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
}

/**
 * Contact Form Validation
 */
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const subject = document.getElementById('subject');
        const message = document.getElementById('message');

        let isValid = true;

        [name, email, subject, message].forEach(input => {
            if (input) input.style.borderColor = '#e5e7eb';
        });

        if (name && name.value.trim().length < 2) {
            name.style.borderColor = '#ef4444';
            isValid = false;
        }

        if (email && !validateEmail(email.value)) {
            email.style.borderColor = '#ef4444';
            isValid = false;
        }

        if (message && message.value.trim().length < 10) {
            message.style.borderColor = '#ef4444';
            isValid = false;
            showAlert('Message must be at least 10 characters long', 'error');
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
}

/**
 * Show Alert Message
 */
function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;

    const mainContent = document.querySelector('.main-content') || document.querySelector('.admin-content');
    if (mainContent) {
        mainContent.insertBefore(alertDiv, mainContent.firstChild);

        setTimeout(function() {
            alertDiv.style.opacity = '0';
            setTimeout(function() {
                alertDiv.remove();
            }, 300);
        }, 5000);
    }
}

/**
 * Confirm Delete Action
 */
function confirmDelete(message) {
    return confirm(message || 'Are you sure you want to delete this item? This action cannot be undone.');
}

/**
 * Search Filter for Tables
 */
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const table = document.querySelector('.table tbody');
        if (!table) return;

        const rows = table.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let found = false;

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                if (cell.textContent.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }

            row.style.display = found ? '' : 'none';
        }
    });
}

/**
 * Image Preview for File Upload
 */
const imageInput = document.getElementById('image');
if (imageInput) {
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                if (preview) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
            };
            reader.readAsDataURL(file);
        }
    });
}

/**
 * Smooth Scroll for Anchor Links
 */
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }
    });
});
