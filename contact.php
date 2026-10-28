<?php
require_once 'config.php';
$activePage = 'contact';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $userId = is_logged_in() ? current_user()['user_id'] : null;

    if ($name === '') $errors[] = 'Name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if ($subject === '') $errors[] = 'Subject is required.';
    if ($message === '') $errors[] = 'Message is required.';

    if (!$errors) {
        $stmt = $conn->prepare("INSERT INTO inquiries (user_id, name, email, subject, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $userId, $name, $email, $subject, $message);
        if ($stmt->execute()) {
            set_flash('success', 'Your inquiry has been submitted.');
            header('Location: contact.php');
            exit;
        } else {
            $errors[] = 'Message could not be sent.';
        }
    }
}

$user = current_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | GlobeTrek Adventures</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="inner-page">
<?php include 'partials/header.php'; ?>

<section class="page-hero">
    <h1>Contact Us</h1>
    <p>Send travel inquiries, package questions or custom travel plan requests to the GlobeTrek team.</p>
</section>

<section class="section">
    <div class="form-wrap">
        <?php if ($errors): ?><div class="error-list"><?php foreach ($errors as $error) echo '<p>' . e($error) . '</p>'; ?></div><?php endif; ?>
        <form method="POST">
            <div class="form-grid">
                <div class="form-group"><label>Name</label><input type="text" name="name" value="<?php echo e($user['full_name'] ?? ''); ?>" required></div>
                <div class="form-group"><label>Email</label><input type="email" name="email" value="<?php echo e($user['email'] ?? ''); ?>" required></div>
            </div>
            <div class="form-group"><label>Subject</label><input type="text" name="subject" required></div>
            <div class="form-group"><label>Message</label><textarea name="message" required></textarea></div>
            <button class="btn" type="submit">Submit Inquiry</button>
        </form>
    </div>
</section>

<?php include 'partials/footer.php'; ?>
