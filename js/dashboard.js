document.addEventListener('DOMContentLoaded', function() {
    fetchDashboardData();
    initCharts();
});

function fetchDashboardData() {
    fetch('dashboard_data.php')
        .then(response => response.json())
        .then(data => {
            updateTotalUsers(data.total_users);
            // Update other metrics and charts
        })
        .catch(error => console.error('Error fetching dashboard data:', error));
}

function exportToPDF() {
    window.location.href = 'export_to_pdf.php';
}

function exportToExcel() {
    window.location.href = 'export_to_excel.php';
}

function updateTotalUsers(totalUsers) {
    document.getElementById('totalUsers').textContent = `Total Users: ${totalUsers}`;
    // Add more update functions for other metrics
}

function initCharts() {
    const ctx = document.getElementById('userChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Users',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
