<?php
require_once 'config.php';
$pageTitle = 'Packages';
$activePage = 'packages';
$search = trim($_GET['search'] ?? '');

$sliderPackages = $conn->query("SELECT * FROM packages WHERE status='active' ORDER BY package_id DESC LIMIT 8");

if ($search !== '') {
    $like = "%" . $search . "%";
    $stmt = $conn->prepare("SELECT * FROM packages WHERE status='active' AND (title LIKE ? OR destination LIKE ? OR activity LIKE ?) ORDER BY package_id DESC");
    $stmt->bind_param("sss", $like, $like, $like);
    $stmt->execute();
    $packages = $stmt->get_result();
} else {
    $packages = $conn->query("SELECT * FROM packages WHERE status='active' ORDER BY package_id DESC");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Packages | GlobeTrek Adventures</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="inner-page">
<?php include 'partials/header.php'; ?>

<section class="page-hero">
    <h1>Tour Packages</h1>
    <p>Search destinations, explore travel packages and book your next journey with GlobeTrek Adventures.</p>
</section>

<section class="package-slider-section">
    <div class="section-title">
        <h2>Featured Destinations</h2>
        <p>Use the arrows to view our package highlights.</p>
    </div>
    <div class="slider-box">
        <div class="package-slide">
            <?php while ($pkg = $sliderPackages->fetch_assoc()): ?>
                <div class="slider-item" style="background-image: url('<?php echo e($pkg['image']); ?>');">
                    <div class="slide-content">
                        <div class="name"><?php echo e($pkg['destination']); ?></div>
                        <div class="des"><?php echo e($pkg['title']); ?> - <?php echo money($pkg['price']); ?></div>
                        <a class="btn" href="package-details.php?id=<?php echo $pkg['package_id']; ?>">Explore →</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="slider-buttons">
            <button class="pkg-prev" type="button">‹</button>
            <button class="pkg-next" type="button">›</button>
        </div>
    </div>
</section>

<section class="section">
    <form class="search-box" method="GET" action="packages.php">
        <input type="text" name="search" placeholder="Search by destination, package or activity" value="<?php echo e($search); ?>">
        <button class="btn" type="submit">Search</button>
        <a class="btn" style="background:#071b33;" href="packages.php">Reset</a>
    </form>

    <div class="package-grid">
        <?php if ($packages->num_rows > 0): ?>
            <?php while ($pkg = $packages->fetch_assoc()): ?>
                <div class="card package-card">
                    <img src="<?php echo e($pkg['image']); ?>" alt="<?php echo e($pkg['title']); ?>">
                    <div class="card-body">
                        <h3><?php echo e($pkg['title']); ?></h3>
                        <div class="package-meta">
                            <span><?php echo e($pkg['destination']); ?></span>
                            <span><?php echo e($pkg['days']); ?> days</span>
                        </div>
                        <p><?php echo e(substr($pkg['description'], 0, 110)); ?>...</p>
                        <p class="price"><?php echo money($pkg['price']); ?></p>
                        <a class="btn" href="package-details.php?id=<?php echo $pkg['package_id']; ?>">View Details</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No packages found. Try another search keyword.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
