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
    <title>Products - Inventory Management</title>
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<div class="dashboard-content">
    <div class="mb-4">
      <h2 class="fw-bold mb-1" style="letter-spacing:0.01em;">Product Management</h2>
      <div class="text-muted mb-3" style="font-size:1.08rem;">View, add, edit, or remove products from your inventory.</div>
      <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
        <button class="btn btn-primary btn-lg px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#productModal" id="addProductBtn">
          <i class="bi bi-plus-circle me-2"></i> Add Product
        </button>
        <div class="ms-auto d-flex gap-2 flex-wrap">
          <button class="btn btn-outline-secondary btn-lg" title="Export CSV"><i class="bi bi-download"></i></button>
        </div>
      </div>
      <div class="divider-soft"></div>
    </div>
    <div class="card p-4 border-0 shadow-lg floating-card" style="border-radius:1.2rem; background:rgba(255,255,255,0.90); backdrop-filter:blur(6px);">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 modern-products-table" id="productsTable" style="border-radius:0.8rem; overflow:hidden; background:#fafdff; min-width:900px;">
            <thead class="table-light" style="border-radius:0.8rem;">
                <tr style="font-size:1.04rem;">
                    <th>ID</th>
                    <th>Name</th>
                    <th>SKU</th>
                    <th>Supplier</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Min Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="fadein-table-rows">
                <!-- Product rows will be loaded here via JS -->
            </tbody>
        </table>
      </div>
    </div>
</div>
<!-- Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="productForm">
        <div class="modal-header">
          <h5 class="modal-title" id="productModalLabel">Add Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="product_id" name="product_id">
          <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="sku" class="form-label">SKU</label>
            <input type="text" class="form-control" id="sku" name="sku" required>
          </div>
          <div class="mb-3">
            <label for="supplier_id" class="form-label">Supplier</label>
            <select class="form-select" id="supplier_id" name="supplier_id"></select>
          </div>
          <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" id="stock" name="stock" required min="0">
          </div>
          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" required min="0">
          </div>
          <div class="mb-3">
            <label for="min_stock" class="form-label">Min Stock</label>
            <input type="number" class="form-control" id="min_stock" name="min_stock" required min="0">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/products.js"></script>
</body>
</html>
