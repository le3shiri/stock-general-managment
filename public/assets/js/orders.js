// Orders module JS

document.addEventListener('DOMContentLoaded', function() {
    // Intercept order form submit
    const orderForm = document.getElementById('orderForm');
    if (orderForm) {
        orderForm.onsubmit = function(e) {
            e.preventDefault();
            const formData = new FormData(orderForm);
            fetch('../api/orders.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Order saved successfully!');
                    var modal = bootstrap.Modal.getInstance(document.getElementById('orderModal'));
                    modal.hide();
                    orderForm.reset();
                    clearOrderItems();
                    loadOrders(); // Reload orders after saving
                } else {
                    alert(data.message || 'Failed to save order.');
                }
            })
            .catch(() => {
                alert('Error submitting order.');
            });
        }
    }

    // Fetch and display orders
    function loadOrders() {
        fetch('../api/orders.php?action=list')
            .then(res => res.json())
            .then(data => {
                const tbody = document.querySelector('#ordersTable tbody');
                tbody.innerHTML = '';
                if (data.success && Array.isArray(data.orders)) {
                    data.orders.forEach(order => {
                        let row = `<tr>
                            <td>${order.id}</td>
                            <td>${order.created_at || ''}</td>
                            <td>${order.supplier_name || ''}</td>
                            <td>${order.status || ''}</td>
                            <td>${order.total || 0}</td>
                            <td>
                                <button class="btn btn-info btn-sm view-order-btn" data-id="${order.id}">View</button>
                                <button class="btn btn-danger btn-sm delete-order-btn" data-id="${order.id}">Delete</button>
                            </td>
                        </tr>`;
                        tbody.innerHTML += row;
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="6" class="text-center">No orders found.</td></tr>';
                }
                attachOrderActions();
            });
    }
    // Load orders on page load
    loadOrders();

    function attachOrderActions() {
        // View order
        document.querySelectorAll('.view-order-btn').forEach(btn => {
            btn.onclick = function() {
                const orderId = this.getAttribute('data-id');
                fetch(`../api/orders.php?action=view&id=${orderId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showOrderDetailsModal(data.order, data.items);
                        } else {
                            alert('Failed to load order details.');
                        }
                    });
            };
        });
        // Delete order
        document.querySelectorAll('.delete-order-btn').forEach(btn => {
            btn.onclick = function() {
                const orderId = this.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this order?')) {
                    const formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('id', orderId);
                    fetch('../api/orders.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            loadOrders();
                        } else {
                            alert('Failed to delete order.');
                        }
                    });
                }
            };
        });
    }

    // Show order details in a modal (basic implementation)
    function showOrderDetailsModal(order, items) {
        let modal = document.getElementById('orderDetailsModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.id = 'orderDetailsModal';
            modal.tabIndex = -1;
            modal.innerHTML = `
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Order Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="orderDetailsBody"></div>
                </div>
            </div>`;
            document.body.appendChild(modal);
        }
        const body = modal.querySelector('#orderDetailsBody');
        let html = `<strong>Order ID:</strong> ${order.id}<br>
        <strong>Date:</strong> ${order.created_at}<br>
        <strong>Supplier:</strong> ${order.supplier_name}<br>
        <strong>Status:</strong> ${order.status}<br>
        <strong>Total:</strong> ${order.total}<br><br>
        <h6>Items</h6>
        <table class="table table-bordered"><thead><tr><th>Product</th><th>Quantity</th><th>Unit Price</th><th>Subtotal</th></tr></thead><tbody>`;
        items.forEach(item => {
            html += `<tr><td>${item.product_name}</td><td>${item.quantity}</td><td>${item.price}</td><td>${item.quantity * item.price}</td></tr>`;
        });
        html += '</tbody></table>';
        body.innerHTML = html;
        var bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }

    let productsList = [];
    const orderModal = document.getElementById('orderModal');
    if (orderModal) {
        orderModal.addEventListener('show.bs.modal', function() {
            loadSuppliers();
            loadProductsForOrder();
            clearOrderItems();
        });
    }

    // Add item button logic
    const addOrderItemBtn = document.getElementById('addOrderItemBtn');
    if (addOrderItemBtn) {
        addOrderItemBtn.addEventListener('click', function() {
            addOrderItemRow();
        });
    }

    function loadProductsForOrder() {
        fetch('../api/inventory.php?action=list')
            .then(res => res.json())
            .then(data => {
                productsList = data;
            });
    }

    function getSelectedSupplierId() {
        const supplierSelect = document.getElementById('orderSupplier');
        return supplierSelect ? supplierSelect.value : '';
    }

    function getProductsForSupplier(supplierId) {
        return productsList.filter(p => String(p.supplier_id) === String(supplierId));
    }

    function addOrderItemRow() {
        const container = document.getElementById('orderItemsContainer');
        const supplierId = getSelectedSupplierId();
        const products = getProductsForSupplier(supplierId);
        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 align-items-center order-item-row';
        row.innerHTML = `
            <div class="col-md-6">
                <select class="form-select order-product-select" name="product_id[]" required>
                    <option value="">Select Product</option>
                    ${products.map(p => `<option value="${p.id}">${p.name}</option>`).join('')}
                </select>
            </div>
            <div class="col-md-4">
                <input type="number" class="form-control" name="quantity[]" min="1" value="1" required placeholder="Quantity">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-order-item">Remove</button>
            </div>
        `;
        container.appendChild(row);
        // Remove logic
        row.querySelector('.remove-order-item').onclick = function() {
            row.remove();
        };
    }

    // Update all product selects when supplier changes
    const supplierSelect = document.getElementById('orderSupplier');
    if (supplierSelect) {
        supplierSelect.addEventListener('change', function() {
            updateAllOrderProductDropdowns();
        });
    }

    function updateAllOrderProductDropdowns() {
        const supplierId = getSelectedSupplierId();
        const products = getProductsForSupplier(supplierId);
        document.querySelectorAll('.order-product-select').forEach(select => {
            const currentValue = select.value;
            select.innerHTML = '<option value="">Select Product</option>' +
                products.map(p => `<option value="${p.id}">${p.name}</option>`).join('');
            // If current value is not in new list, clear it
            if (!products.some(p => String(p.id) === String(currentValue))) {
                select.value = '';
            } else {
                select.value = currentValue;
            }
        });
    }

    function clearOrderItems() {
        document.getElementById('orderItemsContainer').innerHTML = '';
    }

    function loadSuppliers() {
        fetch('../api/suppliers.php?action=list')
            .then(response => response.json())
            .then(data => {
                const supplierSelect = document.getElementById('orderSupplier');
                supplierSelect.innerHTML = '';
                if (data.success && Array.isArray(data.suppliers)) {
                    data.suppliers.forEach(supplier => {
                        const option = document.createElement('option');
                        option.value = supplier.id;
                        option.textContent = supplier.name;
                        supplierSelect.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No suppliers found';
                    supplierSelect.appendChild(option);
                }
            })
            .catch(() => {
                const supplierSelect = document.getElementById('orderSupplier');
                supplierSelect.innerHTML = '<option value="">Error loading suppliers</option>';
            });
    }
});
