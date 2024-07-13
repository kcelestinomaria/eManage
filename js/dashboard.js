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

function updateTotalUsers(totalUsers) {
    document.getElementById('totalUsers').textContent = `Total Users: ${totalUsers}`;
    // Add more update functions for other metrics
}

// Initialize and update charts using Chart.js
