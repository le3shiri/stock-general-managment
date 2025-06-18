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
    <title>Users - Inventory Management</title>
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<div class="dashboard-content">
    <div class="mb-4">
      <h2 class="fw-bold mb-1" style="letter-spacing:0.01em;">User Management</h2>
      <div class="text-muted mb-3" style="font-size:1.08rem;">View, add, edit, or remove users in your system.</div>
      <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
        <button class="btn btn-primary btn-lg px-4 py-2 fw-bold shadow-sm" id="addUserBtn">
          <i class="bi bi-plus-circle me-2"></i> Add User
        </button>
      </div>
      <div class="divider-soft"></div>
    </div>
    <div class="card p-4 border-0 shadow-lg floating-card" style="border-radius:1.2rem; background:rgba(255,255,255,0.90); backdrop-filter:blur(6px);">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 modern-products-table" id="usersTable" style="border-radius:0.8rem; overflow:hidden; background:#fafdff; min-width:900px;">
            <thead class="table-light" style="border-radius:0.8rem;">
                <tr style="font-size:1.04rem;">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="usersTableBody" class="fadein-table-rows">
                <tr><td colspan="6" class="text-center">Loading...</td></tr>
            </tbody>
        </table>
      </div>
    </div>
    <!-- User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="userForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="userId" id="userId">
                    <div class="mb-3">
                        <label for="userName" class="form-label">Name</label>
                        <input type="text" class="form-control" name="userName" id="userName" required>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" name="userEmail" id="userEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">Role</label>
                        <select class="form-select" name="userRole" id="userRole" required>
                            <option value="admin">Admin</option>
                            <option value="manager">Manager</option>
                            <option value="supplier">Supplier</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="userStatus" class="form-label">Status</label>
                        <select class="form-select" name="userStatus" id="userStatus" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="userPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" name="userPassword" id="userPassword" minlength="6">
                        <div class="form-text">Required for new users. Leave blank to keep current password.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/users.js"></script>
</body>
</html>
