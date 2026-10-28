<?php
require_once 'config.php';
require_role(['staff','admin']);
$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $stmt = $conn->prepare("UPDATE packages SET status='inactive' WHERE package_id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    set_flash('info', 'Package marked as inactive.');
}
header('Location: staff-dashboard.php');
exit;
?>
