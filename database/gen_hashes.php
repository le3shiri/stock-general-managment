<?php
// Run this ONCE to add initial users: admin, manager, supplier
require_once '../config/db.php';

$users = [
    ['username' => 'admin', 'password' => 'Admin@123', 'role' => 'admin', 'email' => 'admin@example.com'],
    ['username' => 'manager', 'password' => 'Manager@123', 'role' => 'manager', 'email' => 'manager@example.com'],
    ['username' => 'supplier', 'password' => 'Supplier@123', 'role' => 'supplier', 'email' => 'supplier@example.com'],
];

foreach ($users as $user) {
    $hash = password_hash($user['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT IGNORE INTO users (username, password, role, email) VALUES (?, ?, ?, ?)');
    $stmt->execute([$user['username'], $hash, $user['role'], $user['email']]);
    echo "User {$user['username']} created.<br>";
}
echo "Done. You can now log in with these users.";
?>
