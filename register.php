<?php
require_once 'config.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($fullName === '') $errors[] = 'Full name is required.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
    if (strlen($password) < 6) $errors[] = 'Password must have at least 6 characters.';
    if ($password !== $confirm) $errors[] = 'Passwords do not match.';

    if (!$errors) {
        $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            $errors[] = 'Email already exists. Please login.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $role = 'customer';
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, phone, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fullName, $email, $hash, $phone, $role);
            if ($stmt->execute()) {
                set_flash('success', 'Registration successful. Please login.');
                header('Location: login.php');
                exit;
            } else {
                $errors[] = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | GlobeTrek Adventures</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="inner-page">
<?php include 'partials/header.php'; ?>

<main class="auth-page">
    <div class="auth-card">
        <h1>Create Account</h1>
        <p>Register as a customer to book and manage your travel plans.</p><br>
        <?php if ($errors): ?>
            <div class="error-list"><?php foreach ($errors as $error) echo '<p>' . e($error) . '</p>'; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group"><label>Full Name</label><input type="text" name="full_name" value="<?php echo e($_POST['full_name'] ?? ''); ?>" required></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" value="<?php echo e($_POST['email'] ?? ''); ?>" required></div>
            <div class="form-group"><label>Phone</label><input type="text" name="phone" value="<?php echo e($_POST['phone'] ?? ''); ?>"></div>
            <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
            <div class="form-group"><label>Confirm Password</label><input type="password" name="confirm_password" required></div>
            <button class="btn" type="submit">Register</button>
        </form>
        <br><p>Already have an account? <a class="link-btn" href="login.php">Login here</a></p>
    </div>
</main>

<?php include 'partials/footer.php'; ?>
