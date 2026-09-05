<?php include 'includes/header.php'; ?>

<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Product Catalog</h2>
        <button class="btn btn-primary" onclick="openProductModal()">
            <i class="fas fa-plus"></i> Add Product
        </button>
    </div>

    <table id="productsTable" class="display compact">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Cost Price</th>
                <th>Selling Price</th>
                <th>Stock</th>
                <th>Alert Threshold</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="productsTableBody">
            <!-- AJAX loaded -->
        </tbody>
    </table>
</div>

<!-- Modal -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <h3 id="modalTitle">Add New Product</h3>
        <hr style="border: 0.5px solid var(--border); margin: 1rem 0;">
        <form id="productForm">
            <input type="hidden" name="id" id="prod_internal_id">
            <div class="stats-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Product Id</label>
                    <input type="text" name="Product_Id" id="Product_Id" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="Product_Name" id="Product_Name" class="form-control" required>
                </div>
            </div>
            <div class="stats-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>HSN Code</label>
                    <input type="text" name="Hsn_Code" id="Hsn_Code" class="form-control">
                </div>
                <div class="form-group">
                    <label>Product Code</label>
                    <input type="text" name="Product_Code" id="Product_Code" class="form-control">
                </div>
            </div>
            <div class="stats-grid" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Cost Price</label>
                    <input type="number" step="0.01" name="Product_Cost" id="Product_Cost" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Selling Price</label>
                    <input type="number" step="0.01" name="Selling_Price" id="Selling_Price" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Stock Qty</label>
                    <input type="number" name="Quantity" id="Quantity" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Low Stock Alert Threshold</label>
                <input type="number" name="Low_Stock_Threshold" id="Low_Stock_Threshold" class="form-control" placeholder="Default is 5">
                <small style="color: var(--text-muted);">You will be alerted when stock falls below this number.</small>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem;">
                <button type="button" class="btn btn-secondary" onclick="closeProductModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Product</button>
            </div>
        </form>
    </div>
</div>

<style>
    .badge-alert {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
</style>

<script>
    function openProductModal() {
        $('#modalTitle').text('Add New Product');
        $('#productForm')[0].reset();
        $('#prod_internal_id').val('');
        $('#productModal').show();
    }

    function closeProductModal() {
        $('#productModal').hide();
    }

    function loadProducts() {
        $.get('api/products_handler.php?action=list', function(data) {
            let res = JSON.parse(data);
            let html = '';
            res.data.forEach(p => {
                let isLow = parseInt(p.Quantity) <= parseInt(p.Low_Stock_Threshold || 5);
                let stockDisplay = isLow ? `<span class="badge-alert"><i class="fas fa-triangle-exclamation"></i> ${p.Quantity}</span>` : p.Quantity;
                
                html += `<tr>
                    <td>${p.Product_Id}</td>
                    <td>${p.Product_Name}</td>
                    <td>₹${parseFloat(p.Product_Cost).toFixed(2)}</td>
                    <td>₹${parseFloat(p.Selling_Price).toFixed(2)}</td>
                    <td>${stockDisplay}</td>
                    <td>${p.Low_Stock_Threshold || 5}</td>
                    <td>
                        <button class="btn btn-sm" onclick="editProduct(${p.id})"><i class="fas fa-edit" style="color: var(--primary);"></i></button>
                        <button class="btn btn-sm" onclick="deleteProduct(${p.id})"><i class="fas fa-trash" style="color: #ef4444;"></i></button>
                    </td>
                </tr>`;
            });
            $('#productsTableBody').html(html);
            if (!$.fn.DataTable.isDataTable('#productsTable')) {
                $('#productsTable').DataTable({ "order": [[0, "desc"]] });
            }
        });
    }

    function editProduct(id) {
        $.get('api/products_handler.php?action=get', { id: id }, function(data) {
            let p = JSON.parse(data);
            $('#prod_internal_id').val(p.id);
            $('#Product_Id').val(p.Product_Id);
            $('#Product_Name').val(p.Product_Name);
            $('#Hsn_Code').val(p.Hsn_Code);
            $('#Product_Code').val(p.Product_Code);
            $('#Product_Cost').val(p.Product_Cost);
            $('#Selling_Price').val(p.Selling_Price);
            $('#Quantity').val(p.Quantity);
            $('#Low_Stock_Threshold').val(p.Low_Stock_Threshold);
            $('#modalTitle').text('Edit Product');
            $('#productModal').show();
        });
    }

    function deleteProduct(id) {
        if(confirm('Are you sure you want to delete this product?')) {
            $.post('api/products_handler.php?action=delete', { id: id }, function() {
                loadProducts();
            });
        }
    }

    $('#productForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'api/products_handler.php?action=save',
            type: 'POST',
            data: $(this).serialize(),
            success: function() {
                closeProductModal();
                loadProducts();
            }
        });
    });

    $(document).ready(function() {
        loadProducts();
    });

    document.getElementById('nav-products').classList.add('active');
    document.getElementById('page-title').innerText = 'Product Management';
</script>

<?php include 'includes/footer.php'; ?>
