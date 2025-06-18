// Dashboard JS for dynamic features, charts, etc.
document.addEventListener('DOMContentLoaded', function() {
    // Example: Fetch and display dashboard stats
    fetch('/maroua-project/public/api/reports.php?action=dashboard_stats')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('totalProducts').textContent = data.total_products;
                document.getElementById('totalOrders').textContent = data.total_orders;
                document.getElementById('lowStock').textContent = data.low_stock;
            }
        });
});
