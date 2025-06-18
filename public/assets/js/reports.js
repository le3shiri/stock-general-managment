// Reports & Analytics JS
// Fetch and display expenses, incomes, net profit, and support printing

document.addEventListener('DOMContentLoaded', function() {
    loadReportSummary();
    loadReportTable();

});

function loadReportSummary() {
    fetch('../api/reports.php?action=summary')
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('expensesTotal').textContent = data.expenses;
                document.getElementById('incomesTotal').textContent = data.incomes;
                document.getElementById('netProfit').textContent = data.net_profit;
            }
        });
}

function loadReportTable() {
    fetch('../api/reports.php?action=transactions')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('reportTableBody');
            tbody.innerHTML = '';
            if (data.success && Array.isArray(data.transactions)) {
                data.transactions.forEach(tx => {
                    let row = `<tr>
                        <td>${tx.type}</td>
                        <td>${tx.date}</td>
                        <td>${tx.party}</td>
                        <td>${(tx.amount !== undefined && tx.amount !== null && tx.amount !== '') ? tx.amount : 0}</td>
                    </tr>`;
                    tbody.innerHTML += row;
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="4" class="text-center">No data found.</td></tr>';
            }
        });
}
