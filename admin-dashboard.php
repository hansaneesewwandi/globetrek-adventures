<?php
require_once 'config.php';
require_role('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_staff'])) {
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($password) >= 6) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $role = 'staff';
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $hash, $role);
        if ($stmt->execute()) set_flash('success', 'Staff account created.'); else set_flash('error', 'Could not create staff. Email may exist.');
    } else {
        set_flash('error', 'Please enter valid staff details.');
    }
    header('Location: admin-dashboard.php');
    exit;
}

$usersCount = (int)$conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$bookingsCount = (int)$conn->query("SELECT COUNT(*) AS total FROM bookings")->fetch_assoc()['total'];
$packagesCount = (int)$conn->query("SELECT COUNT(*) AS total FROM packages WHERE status='active'")->fetch_assoc()['total'];
$sales = (float)$conn->query("SELECT COALESCE(SUM(amount),0) AS total FROM payments WHERE status='Paid'")->fetch_assoc()['total'];
$paidBookings = (int)$conn->query("SELECT COUNT(*) AS total FROM bookings WHERE payment_status='Paid'")->fetch_assoc()['total'];
$last24Sales = (float)$conn->query("SELECT COALESCE(SUM(amount),0) AS total FROM payments WHERE status='Paid' AND created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY)")->fetch_assoc()['total'];
$monthSales = (float)$conn->query("SELECT COALESCE(SUM(amount),0) AS total FROM payments WHERE status='Paid' AND YEAR(created_at)=YEAR(CURDATE()) AND MONTH(created_at)=MONTH(CURDATE())")->fetch_assoc()['total'];
$paymentRate = $bookingsCount > 0 ? round(($paidBookings / $bookingsCount) * 100) : 0;
$last24Rate = $sales > 0 ? round(min(100, ($last24Sales / $sales) * 100)) : 0;
$monthRate = $sales > 0 ? round(min(100, ($monthSales / $sales) * 100)) : 0;

$users = $conn->query("SELECT user_id, full_name, email, phone, role, created_at FROM users ORDER BY user_id DESC");
$recentPayments = $conn->query("SELECT p.payment_id, p.amount, p.method, p.created_at, u.full_name, b.booking_id
                                FROM payments p
                                JOIN users u ON p.user_id = u.user_id
                                JOIN bookings b ON p.booking_id = b.booking_id
                                WHERE p.status='Paid'
                                ORDER BY p.payment_id DESC LIMIT 8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | GlobeTrek</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="inner-page">
<?php include 'partials/header.php'; ?>

<section class="page-hero">
    <h1>Admin Dashboard</h1>
    <p>Manage staff accounts, monitor bookings and view a better-looking sales report.</p>
</section>

<section class="section">
    <div class="dashboard-cards compact-cards">
        <div class="stat-card style-orange">
            <span class="stat-icon">👥</span>
            <div class="stat-content">
                <h3>Total Users</h3>
                <strong><?php echo $usersCount; ?></strong>
                <small>Registered system users</small>
            </div>
        </div>
        <div class="stat-card style-purple">
            <span class="stat-icon">🧾</span>
            <div class="stat-content">
                <h3>Total Bookings</h3>
                <strong><?php echo $bookingsCount; ?></strong>
                <small>All booking records</small>
            </div>
        </div>
        <div class="stat-card style-green">
            <span class="stat-icon">📦</span>
            <div class="stat-content">
                <h3>Active Packages</h3>
                <strong><?php echo $packagesCount; ?></strong>
                <small>Packages currently visible</small>
            </div>
        </div>
        <div class="stat-card style-blue">
            <span class="stat-icon">💰</span>
            <div class="stat-content">
                <h3>Total Sales</h3>
                <strong><?php echo money($sales); ?></strong>
                <small>Completed payment value</small>
            </div>
        </div>
    </div>

    <div class="sales-report-grid">
        <div class="sales-report-card accent-orange">
            <div class="sales-header-row">
                <span class="sales-icon-badge">↗</span>
            </div>
            <div class="sales-body-row">
                <div>
                    <h4>Total Sales</h4>
                    <h3><?php echo money($sales); ?></h3>
                    <p>All completed payments</p>
                </div>
                <div class="progress-circle orange" style="--value: <?php echo $paymentRate; ?>;"><span><?php echo $paymentRate; ?>%</span></div>
            </div>
        </div>

        <div class="sales-report-card accent-pink">
            <div class="sales-header-row">
                <span class="sales-icon-badge">⏱</span>
            </div>
            <div class="sales-body-row">
                <div>
                    <h4>Sales (24 Hours)</h4>
                    <h3><?php echo money($last24Sales); ?></h3>
                    <p>Last 24 Hours</p>
                </div>
                <div class="progress-circle purple" style="--value: <?php echo $last24Rate; ?>;"><span><?php echo $last24Rate; ?>%</span></div>
            </div>
        </div>

        <div class="sales-report-card accent-green">
            <div class="sales-header-row">
                <span class="sales-icon-badge">✓</span>
            </div>
            <div class="sales-body-row">
                <div>
                    <h4>Sales This Month</h4>
                    <h3><?php echo money($monthSales); ?></h3>
                    <p>Current Month</p>
                </div>
                <div class="progress-circle green" style="--value: <?php echo $monthRate; ?>;"><span><?php echo $monthRate; ?>%</span></div>
            </div>
        </div>
    </div>

    <div class="table-wrap" style="margin-bottom: 30px;">
        <h2>Recent Paid Payments</h2><br>
        <table>
            <tr><th>Payment ID</th><th>Booking</th><th>Customer</th><th>Method</th><th>Amount</th><th>Date</th></tr>
            <?php if ($recentPayments->num_rows > 0): ?>
                <?php while ($payment = $recentPayments->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $payment['payment_id']; ?></td>
                        <td>#<?php echo $payment['booking_id']; ?></td>
                        <td><?php echo e($payment['full_name']); ?></td>
                        <td><?php echo e($payment['method']); ?></td>
                        <td><?php echo money($payment['amount']); ?></td>
                        <td><?php echo e($payment['created_at']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">No payment records available yet.</td></tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="form-wrap" style="margin-bottom:30px;">
        <h2>Create Staff Account</h2><br>
        <form method="POST">
            <div class="form-grid">
                <div class="form-group"><label>Full Name</label><input name="full_name" required></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
                <div class="form-group"><label>Phone</label><input name="phone"></div>
                <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
            </div>
            <button class="btn" name="create_staff">Create Staff</button>
        </form>
    </div>

    <div class="table-wrap">
        <h2>User Accounts</h2><br>
        <table>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Role</th><th>Created</th></tr>
            <?php while ($u = $users->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $u['user_id']; ?></td>
                    <td><?php echo e($u['full_name']); ?></td>
                    <td><?php echo e($u['email']); ?></td>
                    <td><?php echo e($u['phone']); ?></td>
                    <td><span class="badge"><?php echo e($u['role']); ?></span></td>
                    <td><?php echo e($u['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
</body>
</html>
