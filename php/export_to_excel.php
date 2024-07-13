<?php
require_once 'db_connection.php'; // Include your database connection script
require_once 'vendor/autoload.php'; // Include PhpSpreadsheet library autoload

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Fetch data from database
$sql = "SELECT * FROM your_table"; // Adjust SQL query as per your table structure
$result = $conn->query($sql);

// Populate Excel sheet
if ($result->num_rows > 0) {
    // Set headers
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Email');

    // Data rows
    $row = 2;
    while ($data = $result->fetch_assoc()) {
        $sheet->setCellValue('A' . $row, $data['id']);
        $sheet->setCellValue('B' . $row, $data['name']);
        $sheet->setCellValue('C' . $row, $data['email']);
        $row++;
    }

    // Save Excel file
    $writer = new Xlsx($spreadsheet);
    $filename = 'exported_data.xlsx';
    $writer->save($filename);

    // Download file
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
} else {
    echo 'No data available';
}

$conn->close();
?>
