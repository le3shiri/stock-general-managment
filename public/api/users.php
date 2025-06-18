<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit();
}
require_once '../../config/db.php';
header('Content-Type: application/json');
$action = $_GET['action'] ?? ($_POST['action'] ?? '');

if ($action === 'list') {
    $stmt = $pdo->query('SELECT id, name, email, role, status FROM users');
    $users = $stmt->fetchAll();
    echo json_encode(['success' => true, 'users' => $users]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add or Edit
    $id = $_POST['userId'] ?? '';
    $name = trim($_POST['userName'] ?? '');
    $email = trim($_POST['userEmail'] ?? '');
    $role = $_POST['userRole'] ?? 'manager';
    $status = $_POST['userStatus'] ?? 'active';
    $password = $_POST['userPassword'] ?? '';
    if ($action === 'delete') {
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$_POST['id']]);
        echo json_encode(['success' => true]);
        exit();
    }
    if ($action === 'reset_password') {
        $newpass = password_hash('123456', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->execute([$newpass, $_POST['id']]);
        echo json_encode(['success' => true, 'message' => 'Password reset to 123456.']);
        exit();
    }
    if (!$name || !$email || !$role || !$status || (!$id && !$password)) {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        exit();
    }
    if ($id) {
        // Edit
        $stmt = $pdo->prepare('UPDATE users SET name=?, email=?, role=?, status=? WHERE id=?');
        $stmt->execute([$name, $email, $role, $status, $id]);
        echo json_encode(['success' => true]);
        exit();
    } else {
        // Add
        $stmt = $pdo->prepare('INSERT INTO users (name, email, role, status, password) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$name, $email, $role, $status, password_hash($password, PASSWORD_DEFAULT)]);
        echo json_encode(['success' => true]);
        exit();
    }
}

echo json_encode(['success' => false, 'message' => 'Invalid action']);
