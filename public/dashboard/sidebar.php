<?php
// Sidebar navigation for all dashboard pages
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>
<?php
$base = (basename(dirname($_SERVER['PHP_SELF'])) == 'dashboard') ? '../' : '';
?>
<div class="sidebar position-fixed d-flex flex-column align-items-center" style="width:220px; height:100vh;">
    <div class="my-3 mb-4">
        <div class="brand-logo d-flex align-items-center justify-content-center mx-auto" style="width:56px; height:56px; border-radius:50%; background:linear-gradient(135deg,#2196f3 60%,#43e97b 100%); box-shadow:0 2px 8px rgba(33,150,243,0.13);">
            <i class="bi bi-box-seam" style="font-size:2rem; color:#fff;"></i>
        </div>
    </div>
    <a href="<?php echo $base; ?>index.php" class="d-flex align-items-center gap-2 <?php if(basename($_SERVER['PHP_SELF'])=='index.php') echo 'active'; ?>">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="<?php echo $base; ?>dashboard/products.php" class="d-flex align-items-center gap-2 <?php if(basename($_SERVER['PHP_SELF'])=='products.php') echo 'active'; ?>">
        <i class="bi bi-box"></i> Products
    </a>
    <a href="<?php echo $base; ?>dashboard/suppliers.php" class="d-flex align-items-center gap-2 <?php if(basename($_SERVER['PHP_SELF'])=='suppliers.php') echo 'active'; ?>">
        <i class="bi bi-truck"></i> Suppliers
    </a>
    <a href="<?php echo $base; ?>dashboard/orders.php" class="d-flex align-items-center gap-2 <?php if(basename($_SERVER['PHP_SELF'])=='orders.php') echo 'active'; ?>">
        <i class="bi bi-receipt"></i> Orders
    </a>
    <a href="<?php echo $base; ?>dashboard/reports.php" class="d-flex align-items-center gap-2 <?php if(basename($_SERVER['PHP_SELF'])=='reports.php') echo 'active'; ?>">
        <i class="bi bi-graph-up"></i> Reports
    </a>
    <?php if ($user_role === 'admin') echo '<a href="' . $base . 'dashboard/users.php" class="d-flex align-items-center gap-2 '.(basename($_SERVER['PHP_SELF'])=='users.php'?'active':'').'"> <i class="bi bi-people"></i> Users</a>'; ?>
</div>
