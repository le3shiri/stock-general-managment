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

// List products
if ($action === 'list') {
    $stmt = $pdo->query('SELECT p.*, s.name AS supplier_name FROM products p LEFT JOIN suppliers s ON p.supplier_id = s.id');
    $products = $stmt->fetchAll();
    echo json_encode($products);
    exit();
}
// List suppliers for dropdown
if ($action === 'suppliers') {
    $stmt = $pdo->query('SELECT id, name FROM suppliers');
    echo json_encode($stmt->fetchAll());
    exit();
}
// Add or update product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['product_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $sku = $_POST['sku'] ?? '';
    $supplier_id = $_POST['supplier_id'] ?? null;
    $stock = $_POST['stock'] ?? 0;
    $price = $_POST['price'] ?? 0;
    $min_stock = $_POST['min_stock'] ?? 0;
    if (isset($_POST['delete_id'])) {
        // Delete product
        $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
        $stmt->execute([$_POST['delete_id']]);
        echo json_encode(['success' => true]);
        exit();
    }
    if ($id) {
        // Update
        $stmt = $pdo->prepare('UPDATE products SET name=?, sku=?, supplier_id=?, stock=?, price=?, min_stock=? WHERE id=?');
        $stmt->execute([$name, $sku, $supplier_id ?: null, $stock, $price, $min_stock, $id]);
        echo json_encode(['success' => true]);
    } else {
        // Insert
        $stmt = $pdo->prepare('INSERT INTO products (name, sku, supplier_id, stock, price, min_stock) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$name, $sku, $supplier_id ?: null, $stock, $price, $min_stock]);
        echo json_encode(['success' => true]);
    }
    exit();
}
echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>
