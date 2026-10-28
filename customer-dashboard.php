<?php
require_once 'config.php';
require_role('customer');
$userId = current_user()['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_booking'])) {
    $bookingId = (int)$_POST['booking_id'];
    $stmt = $conn->prepare("UPDATE bookings SET status='Cancelled' WHERE booking_id=? AND user_id=? AND status='Pending'");
    $stmt->bind_param("ii", $bookingId, $userId);
    $stmt->execute();
    set_flash('info', 'Booking cancellation request updated.');
    header('Location: customer-dashboard.php');
    exit;
}

$statsStmt = $conn->prepare("SELECT
    COUNT(*) AS total_bookings,
    SUM(CASE WHEN payment_status='Paid' THEN 1 ELSE 0 END) AS paid_bookings,
    SUM(CASE WHEN payment_status='Unpaid' AND status <> 'Cancelled' THEN 1 ELSE 0 END) AS unpaid_bookings,
    SUM(CASE WHEN status='Confirmed' THEN 1 ELSE 0 END) AS confirmed_bookings
    FROM bookings WHERE user_id=?");
$statsStmt->bind_param("i", $userId);
$statsStmt->execute();
$stats = $statsStmt->get_result()->fetch_assoc();

$stmt = $conn->prepare("SELECT b.*, p.title, p.destination FROM bookings b JOIN packages p ON b.package_id = p.package_id WHERE b.user_id=? ORDER BY b.booking_id DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$bookings = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard | GlobeTrek</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="inner-page">
<?php include 'partials/header.php'; ?>

<section class="page-hero">
    <h1>Customer Dashboard</h1>
    <p>Welcome, <?php echo e(current_user()['full_name']); ?>. Manage your package bookings and payments.</p>
</section>

<section class="section">
    <div class="dashboard-cards compact-cards">
        <div class="stat-card style-orange">
            <span class="stat-icon">✈</span>
            <div class="stat-content">
                <h3>My Bookings</h3>
                <strong><?php echo (int)($stats['total_bookings'] ?? 0); ?></strong>
                <small>Total package bookings</small>
            </div>
        </div>
        <div class="stat-card style-purple">
            <span class="stat-icon">✔</span>
            <div class="stat-content">
                <h3>Paid</h3>
                <strong><?php echo (int)($stats['paid_bookings'] ?? 0); ?></strong>
                <small>Completed payments</small>
            </div>
        </div>
        <div class="stat-card style-green">
            <span class="stat-icon">⏳</span>
            <div class="stat-content">
                <h3>Unpaid</h3>
                <strong><?php echo (int)($stats['unpaid_bookings'] ?? 0); ?></strong>
                <small>Waiting for payment</small>
            </div>
        </div>
        <div class="stat-card style-blue">
            <span class="stat-icon">★</span>
            <div class="stat-content">
                <h3>Confirmed</h3>
                <strong><?php echo (int)($stats['confirmed_bookings'] ?? 0); ?></strong>
                <small>Confirmed by staff</small>
            </div>
        </div>
    </div>

    <div class="table-wrap">
        <h2>My Bookings</h2><br>
        <table>
            <tr><th>ID</th><th>Package</th><th>Date</th><th>Travellers</th><th>Total</th><th>Status</th><th>Payment</th><th>Action</th></tr>
            <?php while ($row = $bookings->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo $row['booking_id']; ?></td>
                    <td><?php echo e($row['title']); ?><br><small><?php echo e($row['destination']); ?></small></td>
                    <td><?php echo e($row['travel_date']); ?></td>
                    <td><?php echo e($row['travellers']); ?></td>
                    <td><?php echo money($row['total_amount']); ?></td>
                    <td><span class="badge <?php echo $row['status']==='Cancelled' ? 'red' : ($row['status']==='Confirmed' ? 'green' : 'orange'); ?>"><?php echo e($row['status']); ?></span></td>
                    <td><span class="badge <?php echo $row['payment_status']==='Paid' ? 'green' : 'orange'; ?>"><?php echo e($row['payment_status']); ?></span></td>
                    <td>
                        <div class="action-stack">
                            <?php if ($row['payment_status'] === 'Unpaid' && $row['status'] !== 'Cancelled'): ?>
                                <a class="pay-btn" href="payment.php?booking_id=<?php echo $row['booking_id']; ?>">Pay Now</a>
                            <?php else: ?>
                                <span class="paid-chip"><?php echo $row['payment_status'] === 'Paid' ? 'Payment Done' : 'No Payment'; ?></span>
                            <?php endif; ?>

                            <?php if ($row['status'] === 'Pending'): ?>
                                <form method="POST" onsubmit="return confirm('Cancel this booking?');">
                                    <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                    <button class="small-btn" name="cancel_booking" type="submit">Cancel Booking</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
</body>
</html>
