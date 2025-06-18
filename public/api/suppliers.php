<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}
require_once '../../config/db.php';
header('Content-Type: application/json');
$action = $_GET['action'] ?? '';

// List suppliers
if ($action === 'list') {
    $stmt = $pdo->query('SELECT * FROM suppliers ORDER BY id DESC');
    $suppliers = $stmt->fetchAll();
    echo json_encode(['success' => true, 'suppliers' => $suppliers]);
    exit();
}
// Add or update supplier
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['supplier_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $contact_name = $_POST['contact_name'] ?? '';
    $contact_email = $_POST['contact_email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    if (isset($_POST['delete_id'])) {
        // Delete supplier
        $stmt = $pdo->prepare('DELETE FROM suppliers WHERE id = ?');
        $stmt->execute([$_POST['delete_id']]);
        echo json_encode(['success' => true]);
        exit();
    }
    if ($id) {
        // Update
        $stmt = $pdo->prepare('UPDATE suppliers SET name=?, contact_name=?, contact_email=?, phone=?, address=? WHERE id=?');
        $stmt->execute([$name, $contact_name, $contact_email, $phone, $address, $id]);
        echo json_encode(['success' => true]);
    } else {
        // Insert
        $stmt = $pdo->prepare('INSERT INTO suppliers (name, contact_name, contact_email, phone, address) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$name, $contact_name, $contact_email, $phone, $address]);
        echo json_encode(['success' => true]);
    }
    exit();
}
echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>
