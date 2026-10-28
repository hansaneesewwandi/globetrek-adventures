<?php
require_once 'config.php';
require_login();

$bookingId = (int)($_GET['booking_id'] ?? 0);
$userId = current_user()['user_id'];

$stmt = $conn->prepare("SELECT b.*, p.title FROM bookings b JOIN packages p ON b.package_id = p.package_id WHERE b.booking_id = ? AND b.user_id = ?");
$stmt->bind_param("ii", $bookingId, $userId);
$stmt->execute();
$booking = $stmt->get_result()->fetch_assoc();

if (!$booking) {
    set_flash('error', 'Booking not found.');
    header('Location: customer-dashboard.php');
    exit;
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method = $_POST['method'] ?? 'Card';
    $cardName = trim($_POST['card_name'] ?? '');
    $cardNumber = preg_replace('/\D/', '', $_POST['card_number'] ?? '');
    $last4 = substr($cardNumber, -4);

    if ($method === 'Card') {
        if ($cardName === '') $errors[] = 'Card holder name is required.';
        if (strlen($cardNumber) < 12) $errors[] = 'Enter a valid card number.';
    }

    if (!$errors) {
        $amount = (float)$booking['total_amount'];
        $stmt = $conn->prepare("INSERT INTO payments (booking_id, user_id, amount, method, card_name, card_last4, status) VALUES (?, ?, ?, ?, ?, ?, 'Paid')");
        $stmt->bind_param("iidsss", $bookingId, $userId, $amount, $method, $cardName, $last4);
        if ($stmt->execute()) {
            $update = $conn->prepare("UPDATE bookings SET payment_status='Paid' WHERE booking_id=?");
            $update->bind_param("i", $bookingId);
            $update->execute();
            set_flash('success', 'Payment completed successfully. Staff will confirm your booking soon.');
            header('Location: customer-dashboard.php');
            exit;
        } else {
            $errors[] = 'Payment failed. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | GlobeTrek Adventures</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="inner-page">
<?php include 'partials/header.php'; ?>

<section class="page-hero">
    <h1>Secure Payment</h1>
    <p>This is a demo payment page for assignment purposes.</p>
</section>

<section class="section">
    <div class="form-wrap">
        <h2><?php echo e($booking['title']); ?></h2>
        <p><strong>Total Amount:</strong> <?php echo money($booking['total_amount']); ?></p><br>
        <?php if ($errors): ?><div class="error-list"><?php foreach ($errors as $error) echo '<p>' . e($error) . '</p>'; ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-group"><label>Payment Method</label><select name="method"><option>Card</option><option>Bank Transfer</option><option>Cash at Office</option></select></div>
            <div class="form-group"><label>Card Holder Name</label><input type="text" name="card_name" placeholder="Demo name"></div>
            <div class="form-group"><label>Card Number</label><input type="text" name="card_number" placeholder="4111 1111 1111 1111"></div>
            <button class="btn" type="submit">Pay Now</button>
        </form>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
