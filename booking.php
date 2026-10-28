<?php
require_once 'config.php';
require_login();

if (user_role() !== 'customer') {
    set_flash('error', 'Only customers can make bookings.');
    header('Location: packages.php');
    exit;
}

$packageId = (int)($_GET['package_id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM packages WHERE package_id = ? AND status='active'");
$stmt->bind_param("i", $packageId);
$stmt->execute();
$package = $stmt->get_result()->fetch_assoc();

if (!$package) {
    set_flash('error', 'Please select a valid package.');
    header('Location: packages.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $travelDate = $_POST['travel_date'] ?? '';
    $travellers = (int)($_POST['travellers'] ?? 1);
    $transport = $_POST['transport_option'] ?? 'Not selected';
    $accommodation = $_POST['accommodation_option'] ?? 'Not selected';
    $request = trim($_POST['special_request'] ?? '');

    if (!$travelDate) $errors[] = 'Travel date is required.';
    if ($travellers < 1) $errors[] = 'Travellers must be at least 1.';

    $transportCost = ($transport === 'Private Van') ? 15000 : (($transport === 'Car with Driver') ? 10000 : 0);
    $accommodationCost = ($accommodation === 'Hotel') ? 18000 : (($accommodation === 'Guest House') ? 9000 : 0);
    $total = ($package['price'] * $travellers) + $transportCost + $accommodationCost;

    if (!$errors) {
        $userId = current_user()['user_id'];
        $stmt = $conn->prepare("INSERT INTO bookings (user_id, package_id, travel_date, travellers, transport_option, accommodation_option, special_request, total_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisisssd", $userId, $packageId, $travelDate, $travellers, $transport, $accommodation, $request, $total);
        if ($stmt->execute()) {
            $bookingId = $stmt->insert_id;
            set_flash('success', 'Booking saved. Please complete payment.');
            header('Location: payment.php?booking_id=' . $bookingId);
            exit;
        } else {
            $errors[] = 'Booking failed. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Package | GlobeTrek Adventures</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="inner-page">
<?php include 'partials/header.php'; ?>

<section class="page-hero">
    <h1>Book Package</h1>
    <p><?php echo e($package['title']); ?> - <?php echo money($package['price']); ?> per traveller</p>
</section>

<section class="section">
    <div class="form-wrap">
        <?php if ($errors): ?><div class="error-list"><?php foreach ($errors as $error) echo '<p>' . e($error) . '</p>'; ?></div><?php endif; ?>
        <form id="bookingForm" method="POST">
            <div class="form-grid">
                <div class="form-group"><label>Travel Date</label><input type="date" name="travel_date" min="<?php echo date('Y-m-d'); ?>" required></div>
                <div class="form-group"><label>Number of Travellers</label><input id="travellers" type="number" name="travellers" min="1" value="1" required></div>
                <div class="form-group"><label>Transport Option</label><select name="transport_option"><option>Not selected</option><option>Private Van</option><option>Car with Driver</option></select></div>
                <div class="form-group"><label>Accommodation Option</label><select name="accommodation_option"><option>Not selected</option><option>Hotel</option><option>Guest House</option></select></div>
            </div>
            <div class="form-group"><label>Special Request / Custom Travel Plan</label><textarea name="special_request" placeholder="Mention food preferences, room type, pickup location or any custom plan details"></textarea></div>
            <button class="btn" type="submit">Save Booking</button>
        </form>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
