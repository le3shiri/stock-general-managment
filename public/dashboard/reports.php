<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}
require_once '../../config/db.php';
$user_role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Inventory Management</title>
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<div class="dashboard-content floating-card p-4 border-0 shadow-lg" style="border-radius:1.2rem; background:rgba(255,255,255,0.90); backdrop-filter:blur(6px);">
  <div class="mb-4">
    <h2 class="fw-bold mb-1" style="letter-spacing:0.01em;">Reports & Analytics</h2>
    <div class="text-muted mb-3" style="font-size:1.08rem;">Visualize your incomes, expenses, profits, and all transactions.</div>
    <div class="divider-soft"></div>
  </div>
  <div class="row mb-4">
    <div class="col-md-4 mb-3">
      <div class="card floating-card p-4 border-0 shadow-lg" style="background:linear-gradient(120deg,#ffe6e6 60%,#fff 100%);border-left:5px solid #ff4d4f;">
        <div class="card-body p-0">
          <h5 class="card-title fw-bold text-danger mb-2">Expenses</h5>
          <p class="card-text fs-2 fw-bold" id="expensesTotal">0</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card floating-card p-4 border-0 shadow-lg" style="background:linear-gradient(120deg,#e6ffe6 60%,#fff 100%);border-left:5px solid #28a745;">
        <div class="card-body p-0">
          <h5 class="card-title fw-bold text-success mb-2">Incomes</h5>
          <p class="card-text fs-2 fw-bold" id="incomesTotal">0</p>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card floating-card p-4 border-0 shadow-lg" style="background:linear-gradient(120deg,#e6f0ff 60%,#fff 100%);border-left:5px solid #2196f3;">
        <div class="card-body p-0">
          <h5 class="card-title fw-bold text-primary mb-2">Net Profit</h5>
          <p class="card-text fs-2 fw-bold" id="netProfit">0</p>
        </div>
      </div>
    </div>
  </div>
  <div class="card p-4 border-0 shadow-lg floating-card mb-4" style="border-radius:1.2rem; background:rgba(255,255,255,0.90); backdrop-filter:blur(6px);">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4 class="fw-bold mb-0">Transactions</h4>
      
    </div>
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0 modern-products-table" id="reportTable" style="border-radius:0.8rem; overflow:hidden; background:#fafdff; min-width:900px;">
        <thead class="table-light" style="border-radius:0.8rem;">
          <tr style="font-size:1.04rem;">
            <th>Type</th>
            <th>Date</th>
                    <th>Party</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody id="reportTableBody" class="fadein-table-rows">
                <tr><td colspan="4" class="text-center">Loading...</td></tr>
            </tbody>
        </table>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/reports.js"></script>
</body>
</html>
