<?php
require_once 'config.php';
require_role(['staff','admin']);

$id = (int)($_GET['id'] ?? 0);
$package = null;
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM packages WHERE package_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $package = $stmt->get_result()->fetch_assoc();
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $destination = trim($_POST['destination']);
    $activity = trim($_POST['activity']);
    $days = (int)$_POST['days'];
    $price = (float)$_POST['price'];
    $image = trim($_POST['image']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];

    if ($title === '' || $destination === '' || $activity === '' || $description === '') $errors[] = 'All text fields are required.';
    if ($days < 1) $errors[] = 'Days must be at least 1.';
    if ($price <= 0) $errors[] = 'Price must be greater than 0.';

    if (!$errors) {
        if ($id) {
            $stmt = $conn->prepare("UPDATE packages SET title=?, destination=?, activity=?, days=?, price=?, image=?, description=?, status=? WHERE package_id=?");
            $stmt->bind_param("sssidsssi", $title, $destination, $activity, $days, $price, $image, $description, $status, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO packages (title, destination, activity, days, price, image, description, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssidsss", $title, $destination, $activity, $days, $price, $image, $description, $status);
        }
        if ($stmt->execute()) {
            set_flash('success', 'Package saved successfully.');
            header('Location: staff-dashboard.php');
            exit;
        } else {
            $errors[] = 'Could not save package.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Package | GlobeTrek</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="inner-page">
<?php include 'partials/header.php'; ?>
<section class="page-hero"><h1><?php echo $id ? 'Edit Package' : 'Add Package'; ?></h1><p>Staff can add or update travel package details.</p></section>
<section class="section">
    <div class="form-wrap">
        <?php if ($errors): ?><div class="error-list"><?php foreach ($errors as $error) echo '<p>' . e($error) . '</p>'; ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group"><label>Title</label><input name="title" value="<?php echo e($package['title'] ?? ''); ?>" required></div>
            <div class="form-grid">
                <div class="form-group"><label>Destination</label><input name="destination" value="<?php echo e($package['destination'] ?? ''); ?>" required></div>
                <div class="form-group"><label>Activity</label><input name="activity" value="<?php echo e($package['activity'] ?? ''); ?>" required></div>
                <div class="form-group"><label>Days</label><input type="number" min="1" name="days" value="<?php echo e($package['days'] ?? ''); ?>" required></div>
                <div class="form-group"><label>Price</label><input type="number" min="1" step="0.01" name="price" value="<?php echo e($package['price'] ?? ''); ?>" required></div>
            </div>
            <div class="form-group"><label>Image Path</label><input name="image" value="<?php echo e($package['image'] ?? 'assets/images/nature.svg'); ?>" required></div>
            <div class="form-group"><label>Description</label><textarea name="description" required><?php echo e($package['description'] ?? ''); ?></textarea></div>
            <div class="form-group"><label>Status</label><select name="status"><option <?php echo (($package['status'] ?? '')==='active')?'selected':''; ?>>active</option><option <?php echo (($package['status'] ?? '')==='inactive')?'selected':''; ?>>inactive</option></select></div>
            <button class="btn" type="submit">Save Package</button>
        </form>
    </div>
</section>
<?php include 'partials/footer.php'; ?>
