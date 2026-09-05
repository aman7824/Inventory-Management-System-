<?php 
require_once 'includes/db.php';
include 'includes/header.php'; 

// Fetch Products and Vendors for the form
$products = $pdo->query("SELECT * FROM products")->fetchAll();
$vendors = $pdo->query("SELECT * FROM vendors")->fetchAll();
?>

<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Purchases</h2>
        <button class="btn btn-primary" onclick="$('#purchaseModal').css('display', 'flex')">
            <i class="fas fa-plus"></i> New Purchase
        </button>
    </div>

    <table id="purchasesTable" class="display compact">
        <thead>
            <tr>
                <th>Date</th>
                <th>Product</th>
                <th>Vendor</th>
                <th>Units</th>
                <th>Total Amount</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal -->
<div id="purchaseModal" class="modal">
    <div class="modal-content" style="max-width: 800px;">
        <h2 style="margin-bottom: 1.5rem;">Record New Purchase</h2>
        <form id="purchaseForm">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Select Product</label>
                    <select name="Product_Code" id="p_select" class="form-control" required onchange="updateProdFields()">
                        <option value="">-- Select --</option>
                        <?php foreach($products as $p): ?>
                            <option value="<?= $p['Product_Code'] ?>" data-name="<?= $p['Product_Name'] ?>" data-hsn="<?= $p['Hsn_Code'] ?>">
                                <?= $p['Product_Name'] ?> (<?= $p['Product_Code'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="Product_Name" id="p_name_hidden">
                    <input type="hidden" name="Hsn_Code" id="p_hsn_hidden">
                </div>
                <div class="form-group">
                    <label>Select Vendor</label>
                    <select name="Vendor_Id" id="v_select" class="form-control" required onchange="updateVendorFields()">
                        <option value="">-- Select --</option>
                        <?php foreach($vendors as $v): ?>
                            <option value="<?= $v['Vendor_Id'] ?>" data-name="<?= $v['Vendor_Name'] ?>">
                                <?= $v['Vendor_Name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="Vendor_Name" id="v_name_hidden">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Purchase Date</label>
                    <input type="date" name="Purchase_Date" class="form-control" required value="<?= date('Y-m-d') ?>">
                </div>
                <div class="form-group">
                    <label>Units</label>
                    <input type="number" name="Purchase_Units" id="p_units" class="form-control" required oninput="calcTotal()">
                </div>
                <div class="form-group">
                    <label>Cost per Unit</label>
                    <input type="number" step="0.01" name="Purchase_Cost" id="p_cost" class="form-control" required oninput="calcTotal()">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>IGST (%)</label>
                    <input type="number" step="0.01" name="IGST" id="p_igst" class="form-control" value="0" oninput="calcTotal()">
                </div>
                <div class="form-group">
                    <label>CGST (%)</label>
                    <input type="number" step="0.01" name="CGST" id="p_cgst" class="form-control" value="0" oninput="calcTotal()">
                </div>
                <div class="form-group">
                    <label>SGST (%)</label>
                    <input type="number" step="0.01" name="SGST" id="p_sgst" class="form-control" value="0" oninput="calcTotal()">
                </div>
                <div class="form-group">
                    <label>Total Amount</label>
                    <input type="number" step="0.01" name="Total_Amount" id="p_total" class="form-control" readonly>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem;">
                <button type="button" class="btn btn-secondary" onclick="$('#purchaseModal').hide()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Purchase</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('nav-purchases').classList.add('active');
    document.getElementById('page-title').innerText = 'Purchase Records';

    function updateProdFields() {
        let opt = $('#p_select option:selected');
        $('#p_name_hidden').val(opt.data('name'));
        $('#p_hsn_hidden').val(opt.data('hsn'));
    }

    function updateVendorFields() {
        let opt = $('#v_select option:selected');
        $('#v_name_hidden').val(opt.data('name'));
    }

    function calcTotal() {
        let units = parseFloat($('#p_units').val()) || 0;
        let cost = parseFloat($('#p_cost').val()) || 0;
        let igst = parseFloat($('#p_igst').val()) || 0;
        let cgst = parseFloat($('#p_cgst').val()) || 0;
        let sgst = parseFloat($('#p_sgst').val()) || 0;

        let base = units * cost;
        let tax = (igst + cgst + sgst) / 100 * base;
        $('#p_total').val((base + tax).toFixed(2));
    }
</script>

<?php include 'includes/footer.php'; ?>
