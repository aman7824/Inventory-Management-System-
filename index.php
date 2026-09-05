<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// Fetch Stats
$sales_stmt = $pdo->query("SELECT SUM(Total_Amount) as total FROM sale");
$total_sales = $sales_stmt->fetch()['total'] ?? 0;

$purchase_stmt = $pdo->query("SELECT SUM(Total_Amount) as total FROM purchase");
$total_purchases = $purchase_stmt->fetch()['total'] ?? 0;

$profit = $total_sales - $total_purchases;

$stock_stmt = $pdo->query("SELECT SUM(Quantity) as qty, SUM(Quantity * Product_Cost) as value FROM products");
$stock_data = $stock_stmt->fetch();
$total_qty = $stock_data['qty'] ?? 0;
$stock_value = $stock_data['value'] ?? 0;
?>

<div class="stats-grid">
    <div class="header-top">
        <h1 id="page-title">Dashboard Overview</h1>
        <div class="user-info">
            <span class="text-muted"><?php echo date('l, d M Y'); ?></span>
        </div>
    </div>

    <?php
    // Fetch Low Stock Products
    $lowStockStmt = $pdo->query("SELECT * FROM products WHERE Quantity <= Low_Stock_Threshold");
    $lowStockProducts = $lowStockStmt->fetchAll();
    if (count($lowStockProducts) > 0):
    ?>
    <div style="margin-bottom: 2rem;">
        <h2 style="font-size: 1.1rem; margin-bottom: 1rem; color: #ef4444; display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-triangle-exclamation"></i> Critical Inventory Alerts
        </h2>
        <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
            <?php foreach ($lowStockProducts as $lowProd): ?>
                <div class="stat-card" style="border-left: 4px solid #ef4444;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <h3 style="margin-bottom: 0.25rem;"><?php echo $lowProd['Product_Name']; ?></h3>
                            <div class="value" style="color: #ef4444;"><?php echo $lowProd['Quantity']; ?> <small style="font-size: 0.8rem; color: var(--text-muted);">in stock</small></div>
                        </div>
                        <a href="products.php" class="btn btn-sm" style="padding: 0.25rem; background: var(--glass);"><i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 0.5rem;">
                        Threshold: <?php echo $lowProd['Low_Stock_Threshold']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="stat-card">
        <h3>Total Sales</h3>
        <div class="value">₹<?php echo number_format($total_sales, 2); ?></div>
    </div>
    <div class="stat-card">
        <h3>Total Purchases</h3>
        <div class="value">₹<?php echo number_format($total_purchases, 2); ?></div>
    </div>
    <div class="stat-card profit">
        <h3>Estimated Profit</h3>
        <div class="value">₹<?php echo number_format($profit, 2); ?></div>
    </div>
    <div class="stat-card stock">
        <h3>Current Stock Value</h3>
        <div class="value">₹<?php echo number_format($stock_value, 2); ?> (<?php echo $total_qty; ?> units)</div>
    </div>
</div>

<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Recent Sales</h2>
        <a href="sales.php" class="btn btn-primary btn-sm">View All</a>
    </div>
    <table id="recentSalesTable" class="display compact">
        <thead>
            <tr>
                <th>Date</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Units</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT * FROM sale ORDER BY Sale_Date DESC LIMIT 5");
            while ($row = $stmt->fetch()) {
                echo "<tr>
                    <td>{$row['Sale_Date']}</td>
                    <td>{$row['Product_Name']}</td>
                    <td>{$row['Customer_Name']}</td>
                    <td>{$row['Product_Units']}</td>
                    <td>₹" . number_format($row['Total_Amount'], 2) . "</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    document.getElementById('nav-dashboard').classList.add('active');
    document.getElementById('page-title').innerText = 'Dashboard Overview';
</script>

<?php include 'includes/footer.php'; ?>
