<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
require_once '../config/db.php';
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$username = isset($_SESSION['name']) ? $_SESSION['name'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Dashboard</title>
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'dashboard/header.php'; ?>
<?php include 'dashboard/sidebar.php'; ?>
<div class="dashboard-content" style="backdrop-filter: blur(6px); background: rgba(243,246,251,0.82); min-height:100vh; border-radius:1.5rem; box-shadow:0 8px 32px rgba(0,0,0,0.10); padding-bottom:2rem;">

    <div class="d-flex align-items-center mb-4 p-4" style="border-radius:1rem; background:rgba(255,255,255,0.85); box-shadow:0 2px 16px rgba(0,123,255,0.06);">
      <div class="me-4">
        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($username); ?>&background=007bff&color=fff&size=72" alt="Avatar" class="rounded-circle shadow" width="72" height="72">
      </div>
      <div>
        <h2 class="fw-bold mb-1" style="letter-spacing:0.02em;">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
        <div class="text-muted mb-2" style="font-size:1.12rem;">Role: <?php echo htmlspecialchars(ucfirst($user_role)); ?></div>
        <div class="text-primary" style="font-size:1.1rem; font-weight:500;">Empower your inventory. Control your business.</div>
      </div>
    </div>
    <!-- Stat Cards -->
    <div class="row g-4 mb-4 card-group">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center h-100 stat-card position-relative overflow-hidden">
          <div class="card-body py-4">
            <div class="mb-2">
              <span class="stat-icon-gradient"><i class="bi bi-box-seam"></i></span>
            </div>
            <h6 class="fw-semibold">Total Products</h6>
            <div class="display-6 fw-bold" id="totalProducts">0</div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center h-100 stat-card position-relative overflow-hidden">
          <div class="card-body py-4">
            <div class="mb-2">
              <span class="stat-icon-gradient-green"><i class="bi bi-cart-check"></i></span>
            </div>
            <h6 class="fw-semibold">Total Orders</h6>
            <div class="display-6 fw-bold" id="totalOrders">0</div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center h-100 stat-card position-relative overflow-hidden">
          <div class="card-body py-4">
            <div class="mb-2">
              <span class="stat-icon-gradient-yellow"><i class="bi bi-exclamation-triangle"></i></span>
            </div>
            <h6 class="fw-semibold">Low Stock Alerts</h6>
            <div class="display-6 fw-bold" id="lowStock">0</div>
          </div>
        </div>
      </div>
    </div>
    <!-- Quick Links / Actions -->
    <div class="row mb-4">

      <div class="col-12">
        <div class="quick-links-card">
          <div class="quick-links-title">Quick Actions</div>
          <div class="quick-links-actions">
            <a href="dashboard/products.php" class="btn btn-primary btn-lg">
              <i class="bi bi-plus-circle"></i> Add Product
            </a>
            <a href="dashboard/suppliers.php" class="btn btn-secondary btn-lg">
              <i class="bi bi-person-plus"></i> Add Supplier
            </a>
            <a href="dashboard/orders.php" class="btn btn-success btn-lg">
              <i class="bi bi-cart-plus"></i> New Order
            </a>
            <a href="dashboard/reports.php" class="btn btn-info btn-lg text-white">
              <i class="bi bi-bar-chart"></i> View Reports
            </a>
          </div>
        </div>
      </div>
    </div>
 
    </div>
    <footer class="text-center text-muted mt-5 mb-2 small" style="opacity:.85;">
      &copy; <?php echo date('Y'); ?> Inventory Management System. Crafted with <span style="color:#e25555;">&hearts;</span>.
    </footer>
</div>
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/dashboard.js"></script>
</body>
</html>
