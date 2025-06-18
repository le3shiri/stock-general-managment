<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
require_once '../config/db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['username']); // POST field is still named 'username' in the form
    $password = $_POST['password'];

    // Debug: Show email and password POSTed
    // Uncomment for debugging only
    // echo "Email: $email, Password: $password";

    $stmt = $pdo->prepare('SELECT id, name, email, password, role, status FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        if ($user['status'] !== 'active') {
            $error = 'Your account is not active.';
        } elseif (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];
            header('Location: index.php');
            exit();
        } else {
            $error = 'Invalid email or password.';
        }
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory Management</title>
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-card { max-width: 400px; width: 100%; }
    </style>
</head>
<body>
<div class="card login-card p-4 shadow">
    <h3 class="mb-3 text-center">Inventory Login</h3>
    <?php if ($error): ?>
        <div class="alert alert-danger"> <?php echo $error; ?> </div>
    <?php endif; ?>
    <form method="POST" autocomplete="off">
        <div class="mb-3">
            <label for="username" class="form-label">Email</label>
            <input type="email" class="form-control" id="username" name="username" placeholder="Enter your email" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
