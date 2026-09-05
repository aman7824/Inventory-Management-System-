$(document).ready(function() {
    // Recent Sales on Dashboard
    if ($('#recentSalesTable').length) {
        $('#recentSalesTable').DataTable({
            paging: false,
            searching: false,
            info: false,
            ordering: false
        });
    }

    // Customers DataTable
    if ($('#customersTable').length) {
        let customersTable = $('#customersTable').DataTable({
            ajax: 'api/customers_handler.php?action=list',
            columns: [
                { data: 'Customer_Id' },
                { data: 'Customer_Name' },
                { data: 'Customer_Mobile' },
                { data: 'Customer_Email' },
                { data: 'Customer_Address' },
                { data: 'Record_Date' },
                {
                    data: 'id',
                    render: function(data) {
                        return `
                            <button class="btn btn-sm" onclick="editCustomer(${data})" style="color: var(--primary);"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm" onclick="deleteCustomer(${data})" style="color: #ef4444;"><i class="fas fa-trash"></i></button>
                        `;
                    }
                }
            ]
        });

        $('#customerForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'api/customers_handler.php?action=save',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    let res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire('Saved!', 'Customer data has been saved.', 'success');
                        closeModal();
                        customersTable.ajax.reload();
                    }
                }
            });
        });
    }

    // Vendors DataTable
    if ($('#vendorsTable').length) {
        let vendorsTable = $('#vendorsTable').DataTable({
            ajax: 'api/vendors_handler.php?action=list',
            columns: [
                { data: 'Vendor_Id' },
                { data: 'Vendor_Name' },
                { data: 'Vendor_Mobile' },
                { data: 'Vendor_GST' },
                { data: 'Vendor_Email' },
                {
                    data: 'id',
                    render: function(data) {
                        return `
                            <button class="btn btn-sm" onclick="editVendor(${data})" style="color: var(--primary);"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm" onclick="deleteVendor(${data})" style="color: #ef4444;"><i class="fas fa-trash"></i></button>
                        `;
                    }
                }
            ]
        });

        $('#vendorForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'api/vendors_handler.php?action=save',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    let res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire('Saved!', 'Vendor data has been saved.', 'success');
                        closeModal();
                        vendorsTable.ajax.reload();
                    }
                }
            });
        });
    }

    // Products DataTable
    if ($('#productsTable').length) {
        let productsTable = $('#productsTable').DataTable({
            ajax: 'api/products_handler.php?action=list',
            columns: [
                { data: 'Product_Id' },
                { data: 'Product_Name' },
                { 
                    data: 'Product_Cost',
                    render: (data) => "₹"+parseFloat(data).toFixed(2)
                },
                { 
                    data: 'Selling_Price',
                     render: (data) => "₹"+parseFloat(data).toFixed(2)
                },
                { 
                    data: 'Quantity',
                    render: function(data, type, row){
                        let isLow = parseInt(data) <= parseInt(row.Low_Stock_Threshold || 5);
                        let stockDisplay = isLow ? `<span class="badge-alert"><i class="fas fa-triangle-exclamation"></i> ${data}</span>` : data;
                        return(stockDisplay);
                    }
                },
                {
                    data: 'Low_Stock_Threshold',
                    render: (data) => {
                        return(data || 5);
                    }
                },
                {
                    data: 'id',
                    render: function(data) {
                        return `
                            <button class="btn btn-sm" onclick="editProduct(${data})" style="color: var(--primary);"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm" onclick="deleteProduct(${data})" style="color: #ef4444;"><i class="fas fa-trash"></i></button>
                        `;
                    }
                }
            ]
        });

        $('#productForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'api/products_handler.php?action=save',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    let res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire('Saved!', 'Product data has been saved.', 'success');
                        closeProductModal();
                        productsTable.ajax.reload();
                    }
                }
            });
        });
    }

    // Purchase Actions
    if ($('#purchasesTable').length) {
         $('#purchasesTable').DataTable({
            ajax: 'api/transactions_handler.php?action=list_purchases',
            columns: [
                { data: 'Purchase_Date' },
                { data: 'Product_Name' },
                { data: 'Vendor_Name' },
                { data: 'Purchase_Units' },
                { data: 'Total_Amount' }
            ]
        });

        $('#purchaseForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'api/transactions_handler.php?action=save_purchase',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    let res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire('Success!', 'Purchase recorded and stock updated.', 'success');
                        setTimeout(() => location.reload(), 1500);
                    }
                }
            });
        });
    }

    // Sale Actions
    if ($('#salesTable').length) {
        $('#salesTable').DataTable({
            ajax: 'api/transactions_handler.php?action=list_sales',
            columns: [
                { data: 'Sale_Date' },
                { data: 'Product_Name' },
                { data: 'Customer_Name' },
                { data: 'Product_Units' },
                { data: 'Total_Amount' },
                {
                    data: 'id',
                    render: function(data) {
                        return `
                            <a href="invoice.php?id=${data}" target="_blank" class="btn btn-sm" style="color: var(--primary);">
                                <i class="fas fa-print"></i> Invoice
                            </a>
                        `;
                    }
                }
            ]
        });

        $('#saleForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: 'api/transactions_handler.php?action=save_sale',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    let res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire('Success!', 'Sale recorded and stock updated.', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else if (res.status === 'error') {
                        Swal.fire('Error!', res.message, 'error');
                    }
                }
            });
        });
    }
});

// UI Control Handlers
$(document).ready(function() {
    const $sidebar = $('#sidebar');
    const $overlay = $('#sidebarOverlay');
    const $menuToggle = $('#menuToggle');
    const $themeToggle = $('#themeToggle');
    const $themeIcon = $themeToggle.find('i');

    // Sidebar Toggle (Mobile)
    function toggleSidebar() {
        $sidebar.toggleClass('open');
        $overlay.toggleClass('active');
    }

    $menuToggle.on('click', toggleSidebar);
    $overlay.on('click', toggleSidebar);

    // Close sidebar on link click (Mobile)
    $('.nav-links a').on('click', function() {
        if (window.innerWidth <= 768) {
            toggleSidebar();
        }
    });

    // Theme Toggle logic
    function updateThemeUI(theme) {
        if (theme === 'light') {
            $themeIcon.removeClass('fa-moon').addClass('fa-sun');
        } else {
            $themeIcon.removeClass('fa-sun').addClass('fa-moon');
        }
    }

    // Initialize UI based on current theme
    const currentTheme = document.documentElement.getAttribute('data-theme');
    updateThemeUI(currentTheme);

    $themeToggle.on('click', function() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeUI(newTheme);
    });
});

// Helper Functions
function deleteCustomer(id) {
    if (confirm('Are you sure you want to delete this customer?')) {
        $.post('api/customers_handler.php?action=delete', { id: id }, function() {
            $('#customersTable').DataTable().ajax.reload();
        });
    }
}

function editCustomer(id) {
    $.get('api/customers_handler.php?action=get', { id: id }, function(data) {
        let cus = JSON.parse(data);
        $('#cus_internal_id').val(cus.id);
        $('#Customer_Id').val(cus.Customer_Id);
        $('#Customer_Name').val(cus.Customer_Name);
        $('#Customer_Mobile').val(cus.Customer_Mobile);
        $('#Customer_Email').val(cus.Customer_Email);
        $('#Customer_Address').val(cus.Customer_Address);
        $('#modalTitle').innerText = 'Edit Customer';
        $('#customerModal').css('display', 'flex');
    });
}

function deleteVendor(id) {
    if (confirm('Are you sure?')) {
        $.post('api/vendors_handler.php?action=delete', { id: id }, function() {
            $('#vendorsTable').DataTable().ajax.reload();
        });
    }
}
function editVendor(id) {
    $.get('api/vendors_handler.php?action=get', { id: id }, function(data) {
        let v = JSON.parse(data);
        $('#vendor_internal_id').val(v.id);
        $('#Vendor_Id').val(v.Vendor_Id);
        $('#Vendor_Name').val(v.Vendor_Name);
        $('#Vendor_Mobile').val(v.Vendor_Mobile);
        $('#Vendor_Email').val(v.Vendor_Email);
        $('#Vendor_GST').val(v.Vendor_GST);
        $('#vendorModal').css('display', 'flex');
    });
}

function deleteProduct(id) {
    if (confirm('Are you sure?')) {
        $.post('api/products_handler.php?action=delete', { id: id }, function() {
            $('#productsTable').DataTable().ajax.reload();
        });
    }
}
function editProduct(id) {
    $.get('api/products_handler.php?action=get', { id: id }, function(data) {
        let p = JSON.parse(data);
        $('#prod_internal_id').val(p.id);
        $('#Product_Id').val(p.Product_Id);
        $('#Product_Name').val(p.Product_Name);
        $('#Product_Code').val(p.Product_Code);
        $('#Hsn_Code').val(p.Hsn_Code);
        $('#Product_Cost').val(p.Product_Cost);
        $('#Selling_Price').val(p.Selling_Price);
        $('#Quantity').val(p.Quantity);
        $('#productModal').css('display', 'flex');
    });
}
