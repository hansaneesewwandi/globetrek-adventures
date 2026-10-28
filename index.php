<?php
require_once 'config.php';
$pageTitle = 'Home';
$activePage = 'home';
$headerClass = 'home-header';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlobeTrek Adventures | Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'partials/header.php'; ?>

<section class="home-hero">
    <video src="assets/videos/video1-wonderfulIsland.mp4" class="video-slide active" autoplay muted loop playsinline></video>
    <video src="assets/videos/video2-campingJoy.mp4" class="video-slide" autoplay muted loop playsinline></video>
    <video src="assets/videos/video3-adventureOffRoad.mp4" class="video-slide" autoplay muted loop playsinline></video>
    <video src="assets/videos/video4-roadTrip.mp4" class="video-slide" autoplay muted loop playsinline></video>
    <video src="assets/videos/video5-feelNature.mp4" class="video-slide" autoplay muted loop playsinline></video>

    <div class="hero-content active">
        <h1>Wonderful.<br><span>Island</span></h1>
        <p>Plan your dream Sri Lankan journey with tour packages, transport support, accommodation options and easy online booking.</p>
        <a class="btn" href="packages.php">Explore Packages</a>
        <a class="btn btn-outline" href="register.php">Join Now</a>
    </div>
    <div class="hero-content">
        <h1>Camping.<br><span>Enjoy</span></h1>
        <p>Discover mountains, campsites and peaceful nature experiences with guided travel support from GlobeTrek Adventures.</p>
        <a class="btn" href="packages.php">View Trips</a>
    </div>
    <div class="hero-content">
        <h1>Adventure.<br><span>Off Road</span></h1>
        <p>Choose adventure-focused packages with transport coordination, flexible dates and quick staff confirmation.</p>
        <a class="btn" href="packages.php">Start Adventure</a>
    </div>
    <div class="hero-content">
        <h1>Road Trip.<br><span>Together</span></h1>
        <p>Travel with friends and family through coastal towns, cultural cities and scenic routes across Sri Lanka.</p>
        <a class="btn" href="packages.php">Book a Tour</a>
    </div>
    <div class="hero-content">
        <h1>Feel Nature.<br><span>Relax</span></h1>
        <p>Customize your travel plan with accommodation preferences, transport choices and special requests.</p>
        <a class="btn" href="contact.php">Customize Plan</a>
    </div>

    <div class="slider-navigation">
        <span class="hero-dot active"></span>
        <span class="hero-dot"></span>
        <span class="hero-dot"></span>
        <span class="hero-dot"></span>
        <span class="hero-dot"></span>
    </div>
</section>

<section class="section">
    <div class="section-title">
        <h2>Why Choose GlobeTrek?</h2>
        <p>A simple dynamic travel management system built for customers, staff and administrators.</p>
    </div>
    <div class="grid-3">
        <div class="card"><div class="card-body"><div class="feature-icon">1</div><h3>Easy Booking</h3><p>Customers can browse packages, select travel dates, add optional services and make booking requests online.</p></div></div>
        <div class="card"><div class="card-body"><div class="feature-icon">2</div><h3>Staff Coordination</h3><p>Travel agency staff can confirm bookings, manage packages and reply to customer inquiries from one dashboard.</p></div></div>
        <div class="card"><div class="card-body"><div class="feature-icon">3</div><h3>Admin Reports</h3><p>Administrators can monitor users, sales, packages and booking records to support business decisions.</p></div></div>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
