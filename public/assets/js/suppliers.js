// JavaScript for Suppliers CRUD

document.addEventListener('DOMContentLoaded', function() {
    loadSuppliers();

    document.getElementById('addSupplierBtn').onclick = function() {
        clearSupplierForm();
        document.getElementById('supplierModalLabel').textContent = 'Add Supplier';
    };

    document.getElementById('supplierForm').onsubmit = function(e) {
        e.preventDefault();
        saveSupplier();
    };
});

function loadSuppliers() {
    fetch('../api/suppliers.php?action=list')
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector('#suppliersTable tbody');
            tbody.innerHTML = '';
            if (data.success && Array.isArray(data.suppliers)) {
                data.suppliers.forEach(supplier => {
                    let row = `<tr>
                        <td>${supplier.id}</td>
                        <td>${supplier.name}</td>
                        <td>${supplier.contact_name || ''}</td>
                        <td>${supplier.contact_email || ''}</td>
                        <td>${supplier.phone || ''}</td>
                        <td>${supplier.address || ''}</td>
                        <td>
                            <button class='btn btn-sm btn-warning' onclick='editSupplier(${JSON.stringify(supplier)})'>Edit</button>
                            <button class='btn btn-sm btn-danger' onclick='deleteSupplier(${supplier.id})'>Delete</button>
                        </td>
                    </tr>`;
                    tbody.innerHTML += row;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="7" class="text-center">No suppliers found.</td></tr>';
            }
        });
}

function clearSupplierForm() {
    document.getElementById('supplierForm').reset();
    document.getElementById('supplier_id').value = '';
}

function editSupplier(supplier) {
    document.getElementById('supplier_id').value = supplier.id;
    document.getElementById('name').value = supplier.name;
    document.getElementById('contact_name').value = supplier.contact_name || '';
    document.getElementById('contact_email').value = supplier.contact_email || '';
    document.getElementById('phone').value = supplier.phone || '';
    document.getElementById('address').value = supplier.address || '';
    document.getElementById('supplierModalLabel').textContent = 'Edit Supplier';
    var modal = new bootstrap.Modal(document.getElementById('supplierModal'));
    modal.show();
}

function saveSupplier() {
    const form = document.getElementById('supplierForm');
    const formData = new FormData(form);
    fetch('../api/suppliers.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            loadSuppliers();
            var modal = bootstrap.Modal.getInstance(document.getElementById('supplierModal'));
            modal.hide();
        } else {
            alert(data.message || 'Failed to save supplier.');
        }
    });
}

function deleteSupplier(id) {
    if (!confirm('Are you sure you want to delete this supplier?')) return;
    fetch('../api/suppliers.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `delete_id=${id}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            loadSuppliers();
        } else {
            alert(data.message || 'Failed to delete supplier.');
        }
    });
}
