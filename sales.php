<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

$products = $pdo->query("SELECT * FROM products WHERE Quantity > 0")->fetchAll();
$customers = $pdo->query("SELECT * FROM customers")->fetchAll();
$vendors = $pdo->query("SELECT * FROM vendors")->fetchAll();
?>

<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Sales</h2>
        <button class="btn btn-primary" onclick="$('#saleModal').css('display', 'flex')">
            <i class="fas fa-plus"></i> New Sale
        </button>
    </div>

    <table id="salesTable" class="display compact">
        <thead>
            <tr>
                <th>Date</th>
                <th>Product</th>
                <th>Customer</th>
                <th>Units</th>
                <th>Total Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal -->
<div id="saleModal" class="modal">
    <div class="modal-content" style="max-width: 800px;">
        <h2 style="margin-bottom: 1.5rem;">Record New Sale</h2>
        <form id="saleForm">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Product</label>
                    <select name="Product_Id" id="s_p_select" class="form-control" required onchange="updateSaleProdFields()">
                        <option value="">-- Select Product --</option>
                        <?php foreach($products as $p): ?>
                            <option value="<?= $p['Product_Id'] ?>" data-name="<?= $p['Product_Name'] ?>" data-hsn="<?= $p['Hsn_Code'] ?>" data-price="<?= $p['Selling_Price'] ?>" data-stock="<?= $p['Quantity'] ?>">
                                <?= $p['Product_Name'] ?> (Stock: <?= $p['Quantity'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="Product_Name" id="s_p_name_hidden">
                    <input type="hidden" name="Hsn_Code" id="s_p_hsn_hidden">
                </div>
                <div class="form-group">
                    <label>Customer</label>
                    <select name="Customer_Id" id="s_c_select" class="form-control" required onchange="updateSaleCustomerFields()">
                        <option value="">-- Select Customer --</option>
                        <?php foreach($customers as $c): ?>
                            <option value="<?= $c['Customer_Id'] ?>" data-name="<?= $c['Customer_Name'] ?>">
                                <?= $c['Customer_Name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="Customer_Name" id="s_c_name_hidden">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                 <div class="form-group">
                    <label>Origin Vendor (Tracking)</label>
                    <select name="Vendor_Id" class="form-control">
                        <option value="">-- Optional --</option>
                        <?php foreach($vendors as $v): ?>
                            <option value="<?= $v['Vendor_Id'] ?>"><?= $v['Vendor_Name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Sale Date</label>
                    <input type="date" name="Sale_Date" class="form-control" required value="<?= date('Y-m-d') ?>">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Units</label>
                    <input type="number" name="Product_Units" id="s_units" class="form-control" required oninput="calcSaleTotal()">
                </div>
                <div class="form-group">
                    <label>Price per Unit</label>
                    <input type="number" step="0.01" name="Product_Price" id="s_price" class="form-control" required oninput="calcSaleTotal()">
                </div>
                <div class="form-group">
                    <label>Total Amount</label>
                    <input type="number" step="0.01" name="Total_Amount" id="s_total" class="form-control" readonly>
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>IGST (%)</label>
                    <input type="number" step="0.01" name="IGST" id="s_igst" class="form-control" value="0" oninput="calcSaleTotal()">
                </div>
                <div class="form-group">
                    <label>CGST (%)</label>
                    <input type="number" step="0.01" name="CGST" id="s_cgst" class="form-control" value="0" oninput="calcSaleTotal()">
                </div>
                <div class="form-group">
                    <label>SGST (%)</label>
                    <input type="number" step="0.01" name="SGST" id="s_sgst" class="form-control" value="0" oninput="calcSaleTotal()">
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem;">
                <button type="button" class="btn btn-secondary" onclick="$('#saleModal').hide()">Cancel</button>
                <button type="submit" class="btn btn-primary">Complete Sale</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('nav-sales').classList.add('active');
    document.getElementById('page-title').innerText = 'Sales Management';

    function updateSaleProdFields() {
        let opt = $('#s_p_select option:selected');
        $('#s_p_name_hidden').val(opt.data('name'));
        $('#s_p_hsn_hidden').val(opt.data('hsn'));
        $('#s_price').val(opt.data('price'));
        calcSaleTotal();
    }

    function updateSaleCustomerFields() {
        let opt = $('#s_c_select option:selected');
        $('#s_c_name_hidden').val(opt.data('name'));
    }

    function calcSaleTotal() {
        let units = parseFloat($('#s_units').val()) || 0;
        let price = parseFloat($('#s_price').val()) || 0;
        let igst = parseFloat($('#s_igst').val()) || 0;
        let cgst = parseFloat($('#s_cgst').val()) || 0;
        let sgst = parseFloat($('#s_sgst').val()) || 0;

        let base = units * price;
        let tax = (igst + cgst + sgst) / 100 * base;
        $('#s_total').val((base + tax).toFixed(2));
    }
</script>

<?php include 'includes/footer.php'; ?>
