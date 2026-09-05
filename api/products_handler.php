<?php
require_once 'auth_check.php';
require_once '../includes/db.php';
$action = $_GET['action'] ?? '';

if ($action == 'list') {
    $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
    echo json_encode(['data' => $stmt->fetchAll()]);
}

if ($action == 'save') {
    $id = $_POST['id'] ?? '';
    $p_id = $_POST['Product_Id'];
    $hsn = $_POST['Hsn_Code'];
    $p_code = $_POST['Product_Code'];
    $name = $_POST['Product_Name'];
    $cost = $_POST['Product_Cost'];
    $price = $_POST['Selling_Price'];
    $qty = $_POST['Quantity'];
    $threshold = $_POST['Low_Stock_Threshold'] ?? 5;

    if ($id) {
        $stmt = $pdo->prepare("UPDATE products SET Product_Id=?, Hsn_Code=?, Product_Code=?, Product_Name=?, Product_Cost=?, Selling_Price=?, Quantity=?, Low_Stock_Threshold=? WHERE id=?");
        $stmt->execute([$p_id, $hsn, $p_code, $name, $cost, $price, $qty, $threshold, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (Product_Id, Hsn_Code, Product_Code, Product_Name, Product_Cost, Selling_Price, Quantity, Low_Stock_Threshold) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$p_id, $hsn, $p_code, $name, $cost, $price, $qty, $threshold]);
    }
    echo json_encode(['status' => 'success']);
}

if ($action == 'delete') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id=?");
    $stmt->execute([$id]);
    echo json_encode(['status' => 'success']);
}

if ($action == 'get') {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
    $stmt->execute([$id]);
    echo json_encode($stmt->fetch());
}
?>
