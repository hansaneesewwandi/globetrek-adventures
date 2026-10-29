
# ≡ƒîì GlobeTrek Adventures

A web-based Travel and Tourism Management System developed using PHP, MySQL, HTML, CSS, and JavaScript.

## ≡ƒôî Project Overview

GlobeTrek Adventures provides a platform for customers to explore travel packages, make bookings, and manage their reservations.

The system includes separate functionality for customers, staff, and administrators.

## Γ£¿ Key Features

### Customer
- Account registration and login
- Browse and search travel packages
- View detailed travel package information
- Book travel packages
- Track bookings through a customer dashboard
- Submit contact inquiries

### Staff
- Manage travel packages
- View and manage customer bookings
- Review customer inquiries

### Administrator
- Dashboard with booking and sales statistics
- User management
- Staff account creation
- Travel package and booking monitoring

### Payment
- Demonstration payment workflow
- Payment records and booking status updates

**Note:** Payment processing is simulated. No real payment gateway is integrated.

## ≡ƒ¢á Technologies Used

- Frontend: HTML5, CSS3, JavaScript
- Backend: PHP
- Database: MySQL
- Development Environment: XAMPP
- Version Control: Git and GitHub

## ≡ƒôé Project Structure

- `assets/` - CSS, JavaScript, images, and media
- `partials/` - Shared page components
- `index.php` - Home page
- `packages.php` - Travel packages
- `booking.php` - Booking functionality
- `login.php` - User authentication
- `register.php` - Registration
- `customer-dashboard.php` - Customer dashboard
- `staff-dashboard.php` - Staff dashboard
- `admin-dashboard.php` - Administrator dashboard

## ≡ƒÆ╗ Local Development

1. Install XAMPP.
2. Place the project inside the `htdocs` directory.
3. Start Apache and MySQL.
4. Create the `globetrek_db` database.
5. Import the local database SQL file.
6. Configure a local `config.php` with database connection settings.
7. Open `http://localhost/globetrek-clean/`.

**Note:** Database credentials and the local SQL dump are excluded from this public repository. A sanitized setup example and database schema will be added separately.

## ≡ƒöÉ Security Notes

- Password hashing and verification
- Role-based access to application features
- Prepared statements in database operations
- Local database credentials excluded from version control

This is an educational project and requires further security review before production deployment.

## ≡ƒæ⌐ΓÇì≡ƒÆ╗ Developer

Hansanee Sewwandi

Software Engineering Undergraduate

[GitHub Profile](https://github.com/hansaneesewwandi)

## ðŸ“¸ Project Screenshots

### Homepage

![GlobeTrek Adventures Homepage](docs/screenshots/homepage.png)

### Travel Packages

![GlobeTrek Travel Packages](docs/screenshots/packages.png)

### Booking System

![GlobeTrek Booking System](docs/screenshots/booking.png)

### Customer Dashboard

![GlobeTrek Customer Dashboard](docs/screenshots/customer-dashboard.png)

### Admin Dashboard

![GlobeTrek Admin Dashboard](docs/screenshots/admin-dashboard.png)
