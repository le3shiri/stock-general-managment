<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}
require_once '../../config/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($_GET['action'] ?? '') === 'view' && isset($_GET['id'])) {
    $order_id = intval($_GET['id']);
    $orderStmt = $pdo->prepare('SELECT o.*, s.name AS supplier_name FROM orders o LEFT JOIN suppliers s ON o.supplier_id = s.id WHERE o.id = ?');
    $orderStmt->execute([$order_id]);
    $order = $orderStmt->fetch();
    $itemsStmt = $pdo->prepare('SELECT oi.*, p.name AS product_name, p.price FROM order_items oi LEFT JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?');
    $itemsStmt->execute([$order_id]);
    $items = $itemsStmt->fetchAll();
    echo json_encode(['success' => true, 'order' => $order, 'items' => $items]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete' && isset($_POST['id'])) {
    $order_id = intval($_POST['id']);
    try {
        $pdo->beginTransaction();
        $pdo->prepare('DELETE FROM order_items WHERE order_id = ?')->execute([$order_id]);
        $pdo->prepare('DELETE FROM orders WHERE id = ?')->execute([$order_id]);
        $pdo->commit();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($_GET['action'] ?? '') === 'list') {
    $stmt = $pdo->query('SELECT o.id, o.created_at, o.status, o.total, s.name AS supplier_name FROM orders o LEFT JOIN suppliers s ON o.supplier_id = s.id ORDER BY o.id DESC');
    $orders = $stmt->fetchAll();
    echo json_encode(['success' => true, 'orders' => $orders]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplier_id = $_POST['supplier_id'] ?? '';
    $order_date = $_POST['order_date'] ?? date('Y-m-d');
    $product_ids = $_POST['product_id'] ?? [];
    $quantities = $_POST['quantity'] ?? [];
    $user_id = $_SESSION['user_id'];

    if (!$supplier_id || empty($product_ids) || empty($quantities) || count($product_ids) !== count($quantities)) {
        echo json_encode(['success' => false, 'message' => 'Invalid order data.']);
        exit();
    }

    try {
        $pdo->beginTransaction();
        // Insert order
        $stmt = $pdo->prepare('INSERT INTO orders (supplier_id, user_id, created_at, status) VALUES (?, ?, ?, ?)');
        $stmt->execute([$supplier_id, $user_id, $order_date, 'pending']);
        $order_id = $pdo->lastInsertId();

        // Insert order items
        $itemStmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)');
        $total = 0;
        // Prepare to fetch product price
        $priceStmt = $pdo->prepare('SELECT price FROM products WHERE id = ?');
        for ($i = 0; $i < count($product_ids); $i++) {
            $itemStmt->execute([$order_id, $product_ids[$i], $quantities[$i]]);
            $priceStmt->execute([$product_ids[$i]]);
            $price = $priceStmt->fetchColumn();
            $total += ($price * $quantities[$i]);
        }
        // Update order total
        $updateTotalStmt = $pdo->prepare('UPDATE orders SET total = ? WHERE id = ?');
        $updateTotalStmt->execute([$total, $order_id]);
        $pdo->commit();
        echo json_encode(['success' => true, 'order_id' => $order_id]);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Failed to save order: ' . $e->getMessage()]);
    }
    exit();
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
