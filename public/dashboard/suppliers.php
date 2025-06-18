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
    <title>Suppliers - Inventory Management</title>
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<div class="dashboard-content">
    <div class="mb-4">
      <h2 class="fw-bold mb-1" style="letter-spacing:0.01em;">Supplier Management</h2>
      <div class="text-muted mb-3" style="font-size:1.08rem;">View, add, edit, or remove suppliers for your inventory.</div>
      <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
        <button class="btn btn-primary btn-lg px-4 py-2 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#supplierModal" id="addSupplierBtn">
          <i class="bi bi-plus-circle me-2"></i> Add Supplier
        </button>
      </div>
      <div class="divider-soft"></div>
    </div>
    <div class="card p-4 border-0 shadow-lg floating-card" style="border-radius:1.2rem; background:rgba(255,255,255,0.90); backdrop-filter:blur(6px);">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 modern-products-table" id="suppliersTable" style="border-radius:0.8rem; overflow:hidden; background:#fafdff; min-width:900px;">
            <thead class="table-light" style="border-radius:0.8rem;">
                <tr style="font-size:1.04rem;">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact Name</th>
                    <th>Contact Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="fadein-table-rows">
                <!-- Supplier rows will be loaded here via JS -->
            </tbody>
        </table>
      </div>
    </div>
</div>
<!-- Supplier Modal -->
<div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
<!-- Modal uses modern style via CSS -->
      <form id="supplierForm">
        <div class="modal-header">
          <h5 class="modal-title" id="supplierModalLabel">Add Supplier</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="supplier_id" name="supplier_id">
          <div class="mb-3">
            <label for="name" class="form-label">Supplier Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="contact_name" class="form-label">Contact Name</label>
            <input type="text" class="form-control" id="contact_name" name="contact_name">
          </div>
          <div class="mb-3">
            <label for="contact_email" class="form-label">Contact Email</label>
            <input type="email" class="form-control" id="contact_email" name="contact_email">
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone">
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address">
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
<script src="../assets/js/suppliers.js"></script>
</body>
</html>
