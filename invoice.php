<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();

$sale_id = $_GET['id'] ?? '';
if (!$sale_id) {
    die("Sale ID is required.");
}

// Fetch Sale Data
$stmt = $pdo->prepare("SELECT * FROM sale WHERE id = ?");
$stmt->execute([$sale_id]);
$sale = $stmt->fetch();

if (!$sale) {
    die("Invoice not found.");
}

// Fetch Customer Data (Optional, if we have more contact info)
$custStmt = $pdo->prepare("SELECT * FROM customers WHERE Customer_Id = ?");
$custStmt->execute([$sale['Customer_Id']]);
$customer = $custStmt->fetch();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice_<?php echo $sale['id']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --text: #1e293b;
            --muted: #64748b;
            --border: #e2e8f0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; color: var(--text); padding: 50px; background: #fff; line-height: 1.5; }
        .invoice-container { max-width: 800px; margin: 0 auto; }
        
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 50px; }
        .logo-section h1 { color: var(--primary); font-size: 2rem; margin-bottom: 5px; }
        .logo-section p { color: var(--muted); font-size: 0.875rem; }
        
        .details-section { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px; }
        .details-box h3 { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--muted); margin-bottom: 10px; }
        .details-box p { font-weight: 600; font-size: 1rem; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { text-align: left; background: #f8fafc; padding: 12px; border-bottom: 2px solid var(--border); font-size: 0.875rem; color: var(--muted); }
        td { padding: 15px 12px; border-bottom: 1px solid var(--border); font-size: 0.9375rem; }
        
        .totals-section { display: flex; justify-content: flex-end; }
        .totals-box { width: 250px; }
        .total-row { display: flex; justify-content: space-between; padding: 10px 0; }
        .total-row.grand-total { border-top: 2px solid var(--border); margin-top: 10px; padding-top: 15px; font-weight: 700; font-size: 1.25rem; color: var(--primary); }
        
        .footer { margin-top: 100px; text-align: center; color: var(--muted); font-size: 0.8125rem; border-top: 1px solid var(--border); padding-top: 20px; }
        
        .btn-print { 
            position: fixed; top: 20px; right: 20px; 
            padding: 10px 20px; background: var(--primary); color: #fff; 
            border: none; border-radius: 5px; cursor: pointer; font-weight: 600;
        }

        @media print {
            .btn-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>
    <button class="btn-print" onclick="window.print()">Print Invoice</button>

    <div class="invoice-container">
        <div class="header">
            <div class="logo-section">
                <h1>InventoryX</h1>
                <p>Advanced Solutions for Modern Business</p>
            </div>
            <div style="text-align: right;">
                <h2 style="font-size: 1.5rem; margin-bottom: 5px;">INVOICE</h2>
                <p style="color: var(--muted);">#INV-<?php echo str_pad($sale['id'], 5, '0', STR_PAD_LEFT); ?></p>
                <p style="color: var(--muted);"><?php echo date('d M Y', strtotime($sale['Sale_Date'])); ?></p>
            </div>
        </div>

        <div class="details-section">
            <div class="details-box">
                <h3>Billed To</h3>
                <p><?php echo $sale['Customer_Name']; ?></p>
                <span style="font-size: 0.875rem; color: var(--muted);">
                    ID: <?php echo $sale['Customer_Id']; ?><br>
                    <?php if ($customer) echo $customer['Customer_Mobile'] . '<br>' . $customer['Customer_Address']; ?>
                </span>
            </div>
            <div class="details-box" style="text-align: right;">
                <h3>Payment Status</h3>
                <p style="color: #10b981;">PAID</p>
                <span style="font-size: 0.875rem; color: var(--muted);">
                    Method: Cash/Online<br>
                    Date: <?php echo date('d M Y', strtotime($sale['Sale_Date'])); ?>
                </span>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Unit Price</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong><?php echo $sale['Product_Name']; ?></strong><br>
                        <small style="color: var(--muted);">HSN: <?php echo $sale['Hsn_Code']; ?></small>
                    </td>
                    <td style="text-align: center;"><?php echo $sale['Product_Units']; ?></td>
                    <td style="text-align: right;">₹<?php echo number_format($sale['Product_Price'], 2); ?></td>
                    <td style="text-align: right;">₹<?php echo number_format($sale['Total_Amount'], 2); ?></td>
                </tr>
            </tbody>
        </table>

        <div class="totals-section">
            <div class="totals-box">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>₹<?php echo number_format($sale['Total_Amount'], 2); ?></span>
                </div>
                <div class="total-row">
                    <span>Tax (0%)</span>
                    <span>₹0.00</span>
                </div>
                <div class="total-row grand-total">
                    <span>Grand Total</span>
                    <span>₹<?php echo number_format($sale['Total_Amount'], 2); ?></span>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for your business!</p>
            <p style="margin-top: 5px;">This is a computer-generated document. No signature required.</p>
        </div>
    </div>
</body>
</html>
