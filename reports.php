<?php include 'includes/header.php'; ?>

<div class="header-top">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <h1 id="page-title">Business Reports</h1>
    </div>
    <div class="header-actions">
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            <input type="date" id="startDate" class="form-control" value="<?php echo date('Y-m-01'); ?>">
            <span class="text-muted">to</span>
            <input type="date" id="endDate" class="form-control" value="<?php echo date('Y-m-d'); ?>">
            <button class="btn btn-primary" onclick="generateReport()"><i class="fas fa-sync"></i> Update</button>
        </div>
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Sales Revenue</h3>
        <div class="value" id="totalSales" style="color: var(--secondary);">₹0.00</div>
        <small class="text-muted" id="salesCount">0 Transactions</small>
    </div>
    <div class="stat-card">
        <h3>Stock Purchase Cost</h3>
        <div class="value" id="totalPurchases" style="color: var(--danger);">₹0.00</div>
        <small class="text-muted" id="purchCount">0 Transactions</small>
    </div>
    <div class="stat-card">
        <h3>Estimated Gross Profit</h3>
        <div class="value" id="estProfit" style="color: var(--primary);">₹0.00</div>
        <small class="text-muted">Revenue - Purchase Cost</small>
    </div>
</div>

<div class="stats-grid" style="grid-template-columns: 2fr 1fr;">
    <div class="content-card">
        <h3 style="margin-bottom: 1.5rem;">Top Selling Products</h3>
        <table class="dataTable" id="topProductsTable">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Units Sold</th>
                    <th>Revenue Generated</th>
                </tr>
            </thead>
            <tbody id="topProductsBody">
                <!-- AJAX -->
            </tbody>
        </table>
    </div>
    
    <div class="content-card">
        <h3 style="margin-bottom: 1.5rem;">Quick Export</h3>
        <p class="text-muted" style="font-size: 0.875rem; margin-bottom: 1.5rem;">Generate a printable summary of your financial data for the selected period.</p>
        <button class="btn btn-secondary" style="width: 100%; justify-content: center; margin-bottom: 1rem;" onclick="window.print()">
            <i class="fas fa-file-pdf"></i> Save as PDF
        </button>
        <button class="btn btn-secondary" style="width: 100%; justify-content: center;" onclick="alert('Export to Excel coming soon!')">
            <i class="fas fa-file-excel"></i> Export to Excel
        </button>
    </div>
</div>

<script>
    function generateReport() {
        const start = $('#startDate').val();
        const end = $('#endDate').val();

        $.get('api/reports_handler.php?action=get_summary', { start: start, end: end }, function(data) {
            const res = JSON.parse(data);
            
            // Update Summary Cards
            $('#totalSales').text('₹' + parseFloat(res.sales.total).toLocaleString('en-IN', {minimumFractionDigits: 2}));
            $('#salesCount').text(res.sales.count + ' Transactions');
            
            $('#totalPurchases').text('₹' + parseFloat(res.purchases.total).toLocaleString('en-IN', {minimumFractionDigits: 2}));
            $('#purchCount').text(res.purchases.count + ' Transactions');
            
            const profit = parseFloat(res.sales.total) - parseFloat(res.purchases.total);
            $('#estProfit').text('₹' + profit.toLocaleString('en-IN', {minimumFractionDigits: 2}));

            // Update Top Products Table
            let html = '';
            if (res.top_products.length > 0) {
                res.top_products.forEach(p => {
                    html += `<tr>
                        <td>${p.Product_Name}</td>
                        <td>${p.units}</td>
                        <td>₹${parseFloat(p.revenue).toFixed(2)}</td>
                    </tr>`;
                });
            } else {
                html = '<tr><td colspan="3" class="text-center">No transactions in this period</td></tr>';
            }
            $('#topProductsBody').html(html);
        });
    }

    $(document).ready(function() {
        generateReport();
        document.getElementById('page-title').innerText = 'Financial Reports';
    });
</script>

<style>
    @media print {
        .sidebar, .header-actions, .nav-links, .icon-btn { display: none !important; }
        .main-content { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
        .content-card { border: none !important; box-shadow: none !important; }
    }
</style>

<?php include 'includes/footer.php'; ?>
