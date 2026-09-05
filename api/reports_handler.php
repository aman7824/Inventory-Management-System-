<?php
require_once 'auth_check.php';
require_once '../includes/db.php';

$action = $_GET['action'] ?? '';

if ($action == 'get_summary') {
    $start = $_GET['start'] ?? date('Y-m-01');
    $end = $_GET['end'] ?? date('Y-m-d');

    // Sales Summary
    $salesStmt = $pdo->prepare("SELECT COUNT(*) as count, SUM(Total_Amount) as total FROM sale WHERE Sale_Date BETWEEN ? AND ?");
    $salesStmt->execute([$start, $end]);
    $salesData = $salesStmt->fetch();

    // Purchases Summary
    $purchStmt = $pdo->prepare("SELECT COUNT(*) as count, SUM(Total_Amount) as total FROM purchase WHERE Purchase_Date BETWEEN ? AND ?");
    $purchStmt->execute([$start, $end]);
    $purchData = $purchStmt->fetch();

    // Specific Product Sales Performance
    $perfStmt = $pdo->prepare("
        SELECT Product_Name, SUM(Product_Units) as units, SUM(Total_Amount) as revenue 
        FROM sale 
        WHERE Sale_Date BETWEEN ? AND ? 
        GROUP BY Product_Name 
        ORDER BY revenue DESC 
        LIMIT 5
    ");
    $perfStmt->execute([$start, $end]);
    $topProducts = $perfStmt->fetchAll();

    echo json_encode([
        'sales' => [
            'count' => $salesData['count'] ?: 0,
            'total' => $salesData['total'] ?: 0
        ],
        'purchases' => [
            'count' => $purchData['count'] ?: 0,
            'total' => $purchData['total'] ?: 0
        ],
        'top_products' => $topProducts
    ]);
}
