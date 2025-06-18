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

if ($action === 'summary') {
    // Expenses (orders)
    $expenses = $pdo->query('SELECT SUM(total) FROM orders')->fetchColumn() ?: 0;
    // Incomes (sales)
    $incomes = $pdo->query('SELECT SUM(total) FROM sales')->fetchColumn() ?: 0;
    $net_profit = $incomes - $expenses;
    echo json_encode([
        'success' => true,
        'expenses' => $expenses,
        'incomes' => $incomes,
        'net_profit' => $net_profit
    ]);
    exit();
}

if ($action === 'transactions') {
    // Expenses (orders)
    $orders = $pdo->query('SELECT id, created_at, total, supplier_id FROM orders')->fetchAll();
    // Incomes (sales)
    $sales = $pdo->query('SELECT id, created_at, total, customer_name FROM sales')->fetchAll();
    $transactions = [];
    foreach ($orders as $o) {
        $transactions[] = [
            'type' => 'Expense',
            'date' => $o['created_at'],
            'party' => 'Supplier #' . $o['supplier_id'],
            'amount' => $o['total']
        ];
    }
    foreach ($sales as $s) {
        $transactions[] = [
            'type' => 'Income',
            'date' => $s['created_at'],
            'party' => $s['customer_name'],
            'amount' => $s['total']
        ];
    }
    // Sort by date desc
    usort($transactions, function($a, $b) { return strcmp($b['date'], $a['date']); });
    echo json_encode(['success' => true, 'transactions' => $transactions]);
    exit();
}

if ($action === 'dashboard_stats') {
    $total_products = $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn();
    $total_orders = $pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn();
    $low_stock = $pdo->query('SELECT COUNT(*) FROM products WHERE stock < 10')->fetchColumn();
    echo json_encode([
        'success' => true,
        'total_products' => (int)$total_products,
        'total_orders' => (int)$total_orders,
        'low_stock' => (int)$low_stock
    ]);
    exit();
}
echo json_encode(['success' => false, 'message' => 'Invalid action']);
