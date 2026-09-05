<?php
require_once 'auth_check.php';
require_once '../includes/db.php';
$action = $_GET['action'] ?? '';

if ($action == 'list') {
    $stmt = $pdo->query("SELECT * FROM vendors ORDER BY id DESC");
    echo json_encode(['data' => $stmt->fetchAll()]);
}

if ($action == 'save') {
    $id = $_POST['id'] ?? '';
    $v_id = $_POST['Vendor_Id'];
    $name = $_POST['Vendor_Name'];
    $mobile = $_POST['Vendor_Mobile'];
    $email = $_POST['Vendor_Email'];
    $address = $_POST['Vendor_Address'];
    $pan = $_POST['Vendor_Pan'];
    $gst = $_POST['Vendor_GST'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE vendors SET Vendor_Id=?, Vendor_Name=?, Vendor_Mobile=?, Vendor_Email=?, Vendor_Address=?, Vendor_Pan=?, Vendor_GST=? WHERE id=?");
        $stmt->execute([$v_id, $name, $mobile, $email, $address, $pan, $gst, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO vendors (Vendor_Id, Vendor_Name, Vendor_Mobile, Vendor_Email, Vendor_Address, Vendor_Pan, Vendor_GST) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$v_id, $name, $mobile, $email, $address, $pan, $gst]);
    }
    echo json_encode(['status' => 'success']);
}

if ($action == 'delete') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM vendors WHERE id=?");
    $stmt->execute([$id]);
    echo json_encode(['status' => 'success']);
}

if ($action == 'get') {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM vendors WHERE id=?");
    $stmt->execute([$id]);
    echo json_encode($stmt->fetch());
}
?>
