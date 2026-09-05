<?php include 'includes/header.php'; ?>

<div class="content-card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Customer List</h2>
        <button class="btn btn-primary" onclick="openModal()">
            <i class="fas fa-plus"></i> Add Customer
        </button>
    </div>

    <table id="customersTable" class="display compact">
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Address</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Modal -->
<div id="customerModal" class="modal">
    <div class="modal-content">
        <h2 id="modalTitle" style="margin-bottom: 1.5rem;">Add New Customer</h2>
        <form id="customerForm">
            <input type="hidden" name="id" id="cus_internal_id">
            <div class="form-group">
                <label>Customer ID</label>
                <input type="text" name="Customer_Id" id="Customer_Id" class="form-control" required placeholder="CUS-001">
            </div>
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="Customer_Name" id="Customer_Name" class="form-control" required>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label>Mobile</label>
                    <input type="text" name="Customer_Mobile" id="Customer_Mobile" class="form-control">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="Customer_Email" id="Customer_Email" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="Customer_Address" id="Customer_Address" class="form-control" rows="3"></textarea>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Customer</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('nav-customers').classList.add('active');
    document.getElementById('page-title').innerText = 'Customer Management';

    function openModal() {
        document.getElementById('modalTitle').innerText = 'Add New Customer';
        document.getElementById('customerForm').reset();
        document.getElementById('cus_internal_id').value = '';
        document.getElementById('customerModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('customerModal').style.display = 'none';
    }

    // Modal click outside to close
    window.onclick = function(event) {
        if (event.target == document.getElementById('customerModal')) closeModal();
    }
</script>

<?php include 'includes/footer.php'; ?>
