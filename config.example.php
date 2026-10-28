<?php
// GlobeTrek Adventures - Database connection and common helper functions
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$DB_HOST = "localhost";
$DB_USER = "YOUR_DB_USER";
$DB_PASS = "YOUR_DB_PASSWORD";
$DB_NAME = "globetrek_db";

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

function e($value) {
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function money($amount) {
    return "LKR " . number_format((float)$amount, 2);
}

function is_logged_in() {
    return isset($_SESSION['user']);
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function user_role() {
    return $_SESSION['user']['role'] ?? 'guest';
}

function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php?next=" . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
}

function require_role($roles) {
    require_login();
    if (!in_array(user_role(), (array)$roles)) {
        header("Location: index.php");
        exit;
    }
}

function set_flash($type, $message) {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash() {
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function redirect_by_role($role) {
    if ($role === 'admin') {
        header("Location: admin-dashboard.php");
    } elseif ($role === 'staff') {
        header("Location: staff-dashboard.php");
    } else {
        header("Location: customer-dashboard.php");
    }
    exit;
}
?>
