// dashboard.js
document.addEventListener('DOMContentLoaded', function() {
    fetchDashboardData();
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
    // Replace with actual endpoint or PHP script for exporting to PDF
    window.location.href = 'export_to_pdf.php';
}

function exportToExcel() {
    // Replace with actual endpoint or PHP script for exporting to Excel
    window.location.href = 'export_to_excel.php';
}

function updateTotalUsers(totalUsers) {
    document.getElementById('totalUsers').textContent = `Total Users: ${totalUsers}`;
    // Add more update functions for other metrics
}

// Initialize and update charts using Chart.js

// Fetch dashboard data when page loads
document.addEventListener('DOMContentLoaded', function() {
    fetchDashboardData();
});