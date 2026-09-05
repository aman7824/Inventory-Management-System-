<?php
require_once 'auth_check.php';
require_once '../includes/db.php';
$action = $_GET['action'] ?? '';

if ($action == 'list_purchases') {
    $stmt = $pdo->query("SELECT * FROM purchase ORDER BY id DESC");
    echo json_encode(['data' => $stmt->fetchAll()]);
}

if ($action == 'list_sales') {
    $stmt = $pdo->query("SELECT * FROM sale ORDER BY id DESC");
    echo json_encode(['data' => $stmt->fetchAll()]);
}

if ($action == 'save_purchase') {
    $p_name = $_POST['Product_Name'];
    $p_code = $_POST['Product_Code'];
    $hsn = $_POST['Hsn_Code'];
    $v_id = $_POST['Vendor_Id'];
    $v_name = $_POST['Vendor_Name'];
    $date = $_POST['Purchase_Date'];
    $units = $_POST['Purchase_Units'];
    $cost = $_POST['Purchase_Cost'];
    $igst = $_POST['IGST'] ?? 0;
    $cgst = $_POST['CGST'] ?? 0;
    $sgst = $_POST['SGST'] ?? 0;
    $total = $_POST['Total_Amount'];

    try {
        $pdo->beginTransaction();

        // 1. Insert Purchase Record
        $stmt = $pdo->prepare("INSERT INTO purchase (Hsn_Code, Product_Name, Product_Code, Vendor_Id, Vendor_Name, Purchase_Date, Purchase_Units, Purchase_Cost, IGST, CGST, SGST, Total_Amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$hsn, $p_name, $p_code, $v_id, $v_name, $date, $units, $cost, $igst, $cgst, $sgst, $total]);

        // 2. Update Product Stock and Cost
        $stmt = $pdo->prepare("UPDATE products SET Quantity = Quantity + ?, Product_Cost = ? WHERE Product_Code = ?");
        $stmt->execute([$units, $cost, $p_code]);

        $pdo->commit();
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

if ($action == 'save_sale') {
    $p_id = $_POST['Product_Id'];
    $c_id = $_POST['Customer_Id'];
    $c_name = $_POST['Customer_Name'];
    $v_id = $_POST['Vendor_Id'] ?? '';
    $hsn = $_POST['Hsn_Code'] ?? '';
    $p_name = $_POST['Product_Name'] ?? '';
    $date = $_POST['Sale_Date'];
    $units = $_POST['Product_Units'];
    $price = $_POST['Product_Price'];
    $igst = $_POST['IGST'] ?? 0;
    $cgst = $_POST['CGST'] ?? 0;
    $sgst = $_POST['SGST'] ?? 0;
    $total = $_POST['Total_Amount'];

    try {
        $pdo->beginTransaction();

        // 1. Check Stock
        $stmt = $pdo->prepare("SELECT Quantity, Product_Name, Hsn_Code FROM products WHERE Product_Id = ?");
        $stmt->execute([$p_id]);
        $product = $stmt->fetch();

        if (!$product || $product['Quantity'] < $units) {
             throw new Exception("Insufficient stock or product not found.");
        }

        // Use product table details if not provided
        $p_name = $p_name ?: $product['Product_Name'];
        $hsn = $hsn ?: $product['Hsn_Code'];

        // 2. Insert Sale Record
        $stmt = $pdo->prepare("INSERT INTO sale (Product_Id, Customer_Id, Customer_Name, Vendor_Id, Hsn_Code, Product_Name, Sale_Date, Product_Units, Product_Price, IGST, CGST, SGST, Total_Amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$p_id, $c_id, $c_name, $v_id, $hsn, $p_name, $date, $units, $price, $igst, $cgst, $sgst, $total]);

        // 3. Update Product Stock
        $stmt = $pdo->prepare("UPDATE products SET Quantity = Quantity - ? WHERE Product_Id = ?");
        $stmt->execute([$units, $p_id]);

        $pdo->commit();
        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
