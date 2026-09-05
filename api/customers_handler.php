<?php
require_once 'auth_check.php';
require_once '../includes/db.php';

$action = $_GET['action'] ?? '';

if ($action == 'list') {
    $stmt = $pdo->query("SELECT * FROM customers ORDER BY id DESC");
    echo json_encode(['data' => $stmt->fetchAll()]);
}

if ($action == 'save') {
    $id = $_POST['id'] ?? '';
    $cus_id = $_POST['Customer_Id'];
    $name = $_POST['Customer_Name'];
    $mobile = $_POST['Customer_Mobile'];
    $email = $_POST['Customer_Email'];
    $address = $_POST['Customer_Address'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE customers SET Customer_Id=?, Customer_Name=?, Customer_Mobile=?, Customer_Email=?, Customer_Address=? WHERE id=?");
        $stmt->execute([$cus_id, $name, $mobile, $email, $address, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO customers (Customer_Id, Customer_Name, Customer_Mobile, Customer_Email, Customer_Address) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$cus_id, $name, $mobile, $email, $address]);
    }
    echo json_encode(['status' => 'success']);
}

if ($action == 'delete') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM customers WHERE id=?");
    $stmt->execute([$id]);
    echo json_encode(['status' => 'success']);
}

if ($action == 'get') {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM customers WHERE id=?");
    $stmt->execute([$id]);
    echo json_encode($stmt->fetch());
}
?>
