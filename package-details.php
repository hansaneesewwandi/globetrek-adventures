<?php
require_once 'config.php';
$activePage = 'packages';
$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM packages WHERE package_id = ? AND status='active'");
$stmt->bind_param("i", $id);
$stmt->execute();
$package = $stmt->get_result()->fetch_assoc();

if (!$package) {
    set_flash('error', 'Package not found.');
    header('Location: packages.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($package['title']); ?> | GlobeTrek</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="inner-page">
<?php include 'partials/header.php'; ?>

<section class="page-hero">
    <h1><?php echo e($package['title']); ?></h1>
    <p><?php echo e($package['destination']); ?> | <?php echo e($package['activity']); ?></p>
</section>

<section class="section">
    <div class="package-detail">
        <img class="detail-image" src="<?php echo e($package['image']); ?>" alt="<?php echo e($package['title']); ?>">
        <div class="summary-box">
            <h2><?php echo e($package['title']); ?></h2>
            <p><?php echo e($package['description']); ?></p>
            <br>
            <p><strong>Destination:</strong> <?php echo e($package['destination']); ?></p>
            <p><strong>Activity:</strong> <?php echo e($package['activity']); ?></p>
            <p><strong>Duration:</strong> <?php echo e($package['days']); ?> days</p>
            <p class="price"><?php echo money($package['price']); ?> per traveller</p>
            <br>
            <a class="btn" href="booking.php?package_id=<?php echo $package['package_id']; ?>">Book This Package</a>
        </div>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
