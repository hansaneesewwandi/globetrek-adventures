
# 🌍 GlobeTrek Adventures

### Travel and Tourism Management System

A web-based Travel and Tourism Management System developed using **PHP, MySQL, HTML5, CSS3, and JavaScript**.

GlobeTrek Adventures provides a platform for customers to explore travel packages, make bookings, and manage their travel reservations through a user-friendly web interface.

---

## 📌 Project Overview

**GlobeTrek Adventures** is a database-driven travel and tourism management application designed to simplify travel booking and management processes.

The system supports three main user roles:

- 👤 **Customer** – Explore packages, make bookings, and manage reservations.
- 👥 **Staff** – Manage travel packages, customer bookings, and inquiries.
- 🛡️ **Administrator** – Manage users, staff, bookings, and system operations.

The project demonstrates practical experience in full-stack web development, database management, authentication, and role-based functionality.

---

## ✨ Key Features

### 👤 Customer Features

- User registration and login
- Browse and search travel packages
- View detailed travel package information
- Make travel bookings
- Track bookings through a customer dashboard
- Submit inquiries through the contact page
- Manage customer account information

### 👥 Staff Features

- Staff authentication
- Manage travel packages
- View and manage customer bookings
- Review customer inquiries
- Access staff dashboard functionality

### 🛡️ Administrator Features

- Administrative dashboard
- Booking and sales statistics
- User management
- Staff account creation
- Travel package management
- Booking monitoring
- Sales and payment reporting

### 💳 Payment Features

- Demonstration payment workflow
- Payment records and booking status updates
- Payment-related information displayed in dashboards

> **Note:** Payment functionality is simulated for educational purposes. No real payment gateway is integrated.

---

## 🛠️ Technologies Used

| Category | Technologies |
|----------|-------------|
| 🎨 Frontend | HTML5, CSS3, JavaScript |
| ⚙️ Backend | PHP |
| 🗄️ Database | MySQL |
| 💻 Development Environment | XAMPP |
| 📝 Code Editor | Visual Studio Code |
| 🔧 Version Control | Git, GitHub |

---

## 📸 Project Screenshots

### 🏠 Homepage

![GlobeTrek Adventures Homepage](docs/screenshots/homepage.png)

### 🏝️ Travel Packages

![GlobeTrek Travel Packages](docs/screenshots/packages.png)

### 📅 Booking System

![GlobeTrek Booking System](docs/screenshots/booking.png)

### 👤 Customer Dashboard

![GlobeTrek Customer Dashboard](docs/screenshots/customer-dashboard.png)

### 📊 Admin Dashboard

![GlobeTrek Admin Dashboard](docs/screenshots/admin-dashboard.png)

---

## 📂 Project Structure

```text
globetrek-adventures/
│
├── assets/
│   ├── css/
│   ├── images/
│   ├── js/
│   └── videos/
│
├── partials/
│   ├── header.php
│   └── footer.php
│
├── docs/
│   └── screenshots/
│       ├── homepage.png
│       ├── packages.png
│       ├── booking.png
│       ├── customer-dashboard.png
│       └── admin-dashboard.png
│
├── index.php
├── about.php
├── packages.php
├── package-details.php
├── booking.php
├── payment.php
├── contact.php
├── login.php
├── register.php
├── logout.php
├── customer-dashboard.php
├── staff-dashboard.php
├── admin-dashboard.php
├── manage-package.php
├── delete-package.php
├── config.example.php
├── .gitignore
└── README.md
```

---

## 💻 Local Installation

### 📋 Requirements

- XAMPP (Apache and MySQL)
- PHP
- Web browser
- Git (optional)

### ⚙️ Setup Instructions

**Step 1 — Clone the repository**

```bash
git clone https://github.com/hansaneesewwandi/globetrek-adventures.git
```

**Step 2 — Move the project**

Place the project folder inside the XAMPP `htdocs` directory.

Example:

```text
C:\xampp\htdocs\globetrek-adventures
```

**Step 3 — Start XAMPP**

Open the XAMPP Control Panel and start:

- Apache
- MySQL

**Step 4 — Database Setup**

1. Open phpMyAdmin.
2. Create a database named `globetrek_db`.
3. Import the local database SQL file when available.
4. Create a `config.php` file based on `config.example.php`.
5. Configure your local database connection.

**Step 5 — Run the Website**

Open your browser and visit:

```text
http://localhost/globetrek-adventures/
```

**Important:** The database dump and local credentials are excluded from this public repository. A sanitized database schema is planned for a future update.

---

## 🔐 Security Notes

The application includes authentication, role-based features, and database-driven operations.

Security-related implementations include:

- Password hashing and verification
- Role-based user functionality
- Prepared statements for database operations
- Local database credentials excluded from Git version control

This is an educational project and requires additional security review and testing before production deployment.

---

## 🚀 Project Status

**Status:** Completed Academic Project / Portfolio Demonstration

The application was developed for educational purposes and has been tested in a local XAMPP environment.

### 🔮 Future Improvements

- Additional security enhancements
- Improved responsive design
- Automated testing
- Production deployment with PHP and MySQL hosting
- Improved database setup documentation
- Enhanced error handling and validation

---

## 👩‍💻 Developer

**Hansanee Sewwandi**

Software Engineering Undergraduate

📍 Kandy, Sri Lanka

### 🔗 Connect With Me

- 💻 [GitHub](https://github.com/hansaneesewwandi)
- 💼 [LinkedIn](https://www.linkedin.com/in/hansanee-sewwandi-se/)
- 🌐 [Portfolio](https://hansaneesewwandi.github.io/)

---

### ⭐ GlobeTrek Adventures

*Developed as a Software Engineering academic project to demonstrate practical full-stack web development skills.*

**Thank you for exploring GlobeTrek Adventures! 🌍**
