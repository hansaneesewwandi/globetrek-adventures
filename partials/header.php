<?php
$activePage = $activePage ?? '';
$headerClass = $headerClass ?? '';
?>
<header class="site-header <?php echo e($headerClass); ?>">
    <a href="index.php" class="brand"><span>&#127757;Globe</span>Trek</a>
    <button class="menu-btn" type="button" aria-label="Open menu">☰</button>
    <nav class="nav-links">
        <a class="<?php echo $activePage === 'home' ? 'active' : ''; ?>" href="index.php">Home</a>
        <a class="<?php echo $activePage === 'about' ? 'active' : ''; ?>" href="about.php">About</a>
        <a class="<?php echo $activePage === 'packages' ? 'active' : ''; ?>" href="packages.php">Packages</a>
        <a class="<?php echo $activePage === 'contact' ? 'active' : ''; ?>" href="contact.php">Contact</a>
        <?php if (is_logged_in()): ?>
            <?php if (user_role() === 'admin'): ?>
                <a href="admin-dashboard.php">Admin</a>
            <?php elseif (user_role() === 'staff'): ?>
                <a href="staff-dashboard.php">Staff</a>
            <?php else: ?>
                <a href="customer-dashboard.php">Dashboard</a>
            <?php endif; ?>
            <a href="logout.php" class="nav-cta">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php" class="nav-cta">Register</a>
        <?php endif; ?>
    </nav>
</header>
<?php $flash = get_flash(); ?>
<?php if ($flash): ?>
    <div class="flash flash-<?php echo e($flash['type']); ?>">
        <?php echo e($flash['message']); ?>
    </div>
<?php endif; ?>
