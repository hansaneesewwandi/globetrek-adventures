<?php
require_once 'config.php';
$errors = [];
$next = $_GET['next'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $next = $_POST['next'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email.';
    if ($password === '') $errors[] = 'Password is required.';

    if (!$errors) {
        $stmt = $conn->prepare("SELECT user_id, full_name, email, password, phone, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'user_id' => $user['user_id'],
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'phone' => $user['phone'],
                'role' => $user['role']
            ];
            if ($next) {
                header("Location: " . $next);
                exit;
            }
            redirect_by_role($user['role']);
        } else {
            $errors[] = 'Invalid email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | GlobeTrek Adventures</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="inner-page">
<?php include 'partials/header.php'; ?>

<main class="auth-page">
    <div class="auth-card">
        <h1>Login</h1>
        <p>Login as customer, staff or administrator.</p><br>
        <?php if ($errors): ?>
            <div class="error-list"><?php foreach ($errors as $error) echo '<p>' . e($error) . '</p>'; ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="next" value="<?php echo e($next); ?>">
            <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
            <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
            <button class="btn" type="submit">Login</button>
        </form>
        <br>
        <p>No account? <a class="link-btn" href="register.php">Register here</a></p>
    </div>
</main>

<?php include 'partials/footer.php'; ?>
