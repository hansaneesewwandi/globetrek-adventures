<?php
require_once 'config.php';
$pageTitle = 'About';
$activePage = 'about';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | GlobeTrek Adventures</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="inner-page">
<?php include 'partials/header.php'; ?>

<section class="page-hero">
    <h1>About GlobeTrek Adventures</h1>
    <p>GlobeTrek Adventures is a Negombo based travel and tourism company that helps travellers plan, book and manage memorable trips.</p>
</section>

<section class="section">
    <div class="grid-3">
        <div class="card"><div class="card-body"><h3>Company Profile</h3><p>We provide travel packages, accommodation guidance, transport coordination and destination support for local and international travellers.</p></div></div>
        <div class="card"><div class="card-body"><h3>Our Mission</h3><p>Our mission is to make travel planning simple, enjoyable and reliable through a user-friendly online platform.</p></div></div>
        <div class="card"><div class="card-body"><h3>Our Services</h3><p>Tour packages, custom travel plans, hotel coordination, transport support, travel inquiries and booking management.</p></div></div>
    </div>
</section>

<section class="section" style="padding-top:0;">
    <div class="section-title">
        <h2>System Users</h2>
        <p>The web application is designed for three user roles.</p>
    </div>
    <div class="grid-3">
        <div class="card"><div class="card-body"><h3>Customers</h3><p>Browse packages, register, login, book tours, make payments, view booking history and submit inquiries.</p></div></div>
        <div class="card"><div class="card-body"><h3>Staff</h3><p>Manage bookings, update packages, coordinate travel services and reply to customer inquiries.</p></div></div>
        <div class="card"><div class="card-body"><h3>Administrators</h3><p>Manage staff accounts, oversee bookings, view reports and monitor secure data handling.</p></div></div>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
