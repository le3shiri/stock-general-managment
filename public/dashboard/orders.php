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
    <title>Orders - Inventory Management</title>
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<div class="dashboard-content">
    <div class="mb-4">
      <h2 class="fw-bold mb-1" style="letter-spacing:0.01em;">Order Management</h2>
      <div class="text-muted mb-3" style="font-size:1.08rem;">View, add, edit, or remove orders in your inventory system.</div>
      <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
        <button class="btn btn-primary btn-lg px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#orderModal">
          <i class="bi bi-plus-circle me-2"></i> Add Order
        </button>
      </div>
      <div class="divider-soft"></div>
    </div>
    <div class="card p-4 border-0 shadow-lg floating-card" style="border-radius:1.2rem; background:rgba(255,255,255,0.90); backdrop-filter:blur(6px);">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 modern-products-table" id="ordersTable" style="border-radius:0.8rem; overflow:hidden; background:#fafdff; min-width:900px;">
            <thead class="table-light" style="border-radius:0.8rem;">
                <tr style="font-size:1.04rem;">
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Supplier</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="fadein-table-rows">
                <!-- Orders will be loaded here by JS -->
            </tbody>
        </table>
      </div>
    </div>
    <!-- Order Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form id="orderForm">
            <div class="modal-header">
              <h5 class="modal-title" id="orderModalLabel">Add/Edit Order</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="orderSupplier" class="form-label">Supplier</label>
                  <select class="form-select" id="orderSupplier" name="supplier_id" required>
                    <!-- Supplier options loaded by JS -->
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="orderDate" class="form-label">Order Date</label>
                  <input type="date" class="form-control" id="orderDate" name="order_date" required>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Order Items</label>
                <div id="orderItemsContainer">
                  <!-- Order items rows added by JS -->
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="addOrderItemBtn">Add Item</button>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save Order</button>
            </div>
            <input type="hidden" name="order_id" id="orderId">
          </form>
        </div>
      </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/orders.js"></script>
</body>
</html>
