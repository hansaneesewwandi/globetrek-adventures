<?php
require_once 'config.php';
require_role(['staff','admin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_booking'])) {
    $bookingId = (int)$_POST['booking_id'];
    $status = $_POST['status'];
    $allowed = ['Pending','Confirmed','Cancelled','Completed'];
    if (in_array($status, $allowed)) {
        $stmt = $conn->prepare("UPDATE bookings SET status=? WHERE booking_id=?");
        $stmt->bind_param("si", $status, $bookingId);
        $stmt->execute();
        set_flash('success', 'Booking status updated.');
    }
    header('Location: staff-dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply_inquiry'])) {
    $inquiryId = (int)$_POST['inquiry_id'];
    $reply = trim($_POST['staff_reply']);
    $status = $reply ? 'Replied' : 'Open';
    $stmt = $conn->prepare("UPDATE inquiries SET staff_reply=?, status=? WHERE inquiry_id=?");
    $stmt->bind_param("ssi", $reply, $status, $inquiryId);
    $stmt->execute();
    set_flash('success', 'Inquiry updated.');
    header('Location: staff-dashboard.php');
    exit;
}

$bookings = $conn->query("SELECT b.*, u.full_name, u.email, p.title FROM bookings b JOIN users u ON b.user_id=u.user_id JOIN packages p ON b.package_id=p.package_id ORDER BY b.booking_id DESC");
$inquiries = $conn->query("SELECT * FROM inquiries ORDER BY inquiry_id DESC LIMIT 10");
$packages = $conn->query("SELECT * FROM packages WHERE status='active' ORDER BY package_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard | GlobeTrek</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="inner-page">
<?php include 'partials/header.php'; ?>

<section class="page-hero">
    <h1>Staff Dashboard</h1>
    <p>Confirm bookings, manage packages and reply to customer inquiries.</p>
</section>

<section class="section">
    <div class="table-wrap">
        <h2>Booking Management</h2><br>
        <table>
            <tr><th>ID</th><th>Customer</th><th>Package</th><th>Date</th><th>Total</th><th>Payment</th><th>Status</th><th>Update</th></tr>
            <?php while ($row = $bookings->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo $row['booking_id']; ?></td>
                    <td><?php echo e($row['full_name']); ?><br><small><?php echo e($row['email']); ?></small></td>
                    <td><?php echo e($row['title']); ?></td>
                    <td><?php echo e($row['travel_date']); ?></td>
                    <td><?php echo money($row['total_amount']); ?></td>
                    <td><?php echo e($row['payment_status']); ?></td>
                    <td><?php echo e($row['status']); ?></td>
                    <td>
                        <form class="inline-form" method="POST">
                            <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                            <select name="status">
                                <?php foreach (['Pending','Confirmed','Cancelled','Completed'] as $status): ?>
                                    <option <?php echo $row['status']===$status ? 'selected' : ''; ?>><?php echo $status; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button class="small-btn" name="update_booking">Save</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="table-wrap">
        <h2>Package Management <a class="btn" style="float:right;" href="manage-package.php">Add Package</a></h2><br>
        <table>
            <tr><th>ID</th><th>Title</th><th>Destination</th><th>Price</th><th>Status</th><th>Action</th></tr>
            <?php while ($pkg = $packages->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $pkg['package_id']; ?></td>
                    <td><?php echo e($pkg['title']); ?></td>
                    <td><?php echo e($pkg['destination']); ?></td>
                    <td><?php echo money($pkg['price']); ?></td>
                    <td><?php echo e($pkg['status']); ?></td>
                    <td><a class="link-btn" href="manage-package.php?id=<?php echo $pkg['package_id']; ?>">Edit</a> | <a class="link-btn" onclick="return confirm('Delete this package?');" href="delete-package.php?id=<?php echo $pkg['package_id']; ?>">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <div class="table-wrap">
        <h2>Customer Inquiries</h2><br>
        <table>
            <tr><th>Name</th><th>Subject</th><th>Message</th><th>Status</th><th>Reply</th></tr>
            <?php while ($inq = $inquiries->fetch_assoc()): ?>
                <tr>
                    <td><?php echo e($inq['name']); ?><br><small><?php echo e($inq['email']); ?></small></td>
                    <td><?php echo e($inq['subject']); ?></td>
                    <td><?php echo e($inq['message']); ?></td>
                    <td><?php echo e($inq['status']); ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="inquiry_id" value="<?php echo $inq['inquiry_id']; ?>">
                            <textarea name="staff_reply" placeholder="Write reply"><?php echo e($inq['staff_reply']); ?></textarea>
                            <button class="small-btn" name="reply_inquiry">Save Reply</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
