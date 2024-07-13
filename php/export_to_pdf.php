<?php
require_once 'db_connection.php'; // Include your database connection script
require_once 'vendor/autoload.php'; // Include TCPDF or FPDF library autoload

use TCPDF\TCPDF;

// Initialize PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Exported Data to PDF');

// Add a page
$pdf->AddPage();

// Fetch data from database
$sql = "SELECT * FROM your_table"; // Adjust SQL query as per your table structure
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Table header
    $html = '<table border="1">';
    $html .= '<thead><tr><th>ID</th><th>Name</th><th>Email</th></tr></thead>';
    $html .= '<tbody>';

    // Data rows
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $row['id'] . '</td>';
        $html .= '<td>' . $row['name'] . '</td>';
        $html .= '<td>' . $row['email'] . '</td>';
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    // Output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // Close and output PDF document
    $pdf->Output('exported_data.pdf', 'D'); // D: download the file directly
} else {
    echo 'No data available';
}

$conn->close();
?>
