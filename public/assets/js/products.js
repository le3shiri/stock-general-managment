// JavaScript for Products CRUD

document.addEventListener('DOMContentLoaded', function() {
    loadProducts();
    loadSuppliers();

    document.getElementById('addProductBtn').onclick = function() {
        clearProductForm();
        document.getElementById('productModalLabel').textContent = 'Add Product';
    };

    document.getElementById('productForm').onsubmit = function(e) {
        e.preventDefault();
        saveProduct();
    };
});

function loadProducts() {
    fetch('../api/inventory.php?action=list')
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector('#productsTable tbody');
            tbody.innerHTML = '';
            data.forEach(product => {
                let row = `<tr>
                    <td>${product.id}</td>
                    <td>${product.name}</td>
                    <td>${product.sku}</td>
                    <td>${product.supplier_name || ''}</td>
                    <td>${product.stock}</td>
                    <td>${product.price}</td>
                    <td>${product.min_stock}</td>
                    <td>
                        <button class='btn btn-sm btn-warning' onclick='editProduct(${JSON.stringify(product)})'>Edit</button>
                        <button class='btn btn-sm btn-danger' onclick='deleteProduct(${product.id})'>Delete</button>
                    </td>
                </tr>`;
                tbody.innerHTML += row;
            });
        });
}

function loadSuppliers() {
    fetch('../api/inventory.php?action=suppliers')
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('supplier_id');
            select.innerHTML = '<option value="">Select Supplier</option>';
            data.forEach(supplier => {
                select.innerHTML += `<option value="${supplier.id}">${supplier.name}</option>`;
            });
        });
}

function clearProductForm() {
    document.getElementById('productForm').reset();
    document.getElementById('product_id').value = '';
}

function editProduct(product) {
    document.getElementById('product_id').value = product.id;
    document.getElementById('name').value = product.name;
    document.getElementById('sku').value = product.sku;
    document.getElementById('supplier_id').value = product.supplier_id || '';
    document.getElementById('stock').value = product.stock;
    document.getElementById('price').value = product.price;
    document.getElementById('min_stock').value = product.min_stock;
    document.getElementById('productModalLabel').textContent = 'Edit Product';
    var modal = new bootstrap.Modal(document.getElementById('productModal'));
    modal.show();
}

function saveProduct() {
    const form = document.getElementById('productForm');
    const formData = new FormData(form);
    fetch('../api/inventory.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            loadProducts();
            var modal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
            modal.hide();
        } else {
            alert(data.message || 'Failed to save product.');
        }
    });
}

function deleteProduct(id) {
    if (!confirm('Are you sure you want to delete this product?')) return;
    fetch('../api/inventory.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `delete_id=${id}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            loadProducts();
        } else {
            alert(data.message || 'Failed to delete product.');
        }
    });
}
