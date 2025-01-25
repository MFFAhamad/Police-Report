<?php
require 'db.php'; // Your Database class file
require 'vendor/autoload.php'; // This will autoload FPDF that was installed via Composer.

// Initialize the Database
$db = new Database();



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['report_id'])) {
    $reportId = $_POST['report_id']; // Sanitize and validate this input

    // Fetch the report data from the database
    $stmt = $db->getConnection()->prepare("SELECT * FROM report WHERE id = ? AND status = 'Address Verified'");
    $stmt->bind_param("i", $reportId);
    $stmt->execute();
    $result = $stmt->get_result();
    $report = $result->fetch_assoc();

    if ($report) {
        // Create instance of FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Police Report', 0, 1, 'C');
        $pdf->Ln(10);

        // Output report details
        $pdf->SetFont('Arial', '', 12);
        foreach ($report as $key => $value) {
            if (!in_array($key, ['id_image_path', 'person_image_path'])) { // Exclude image paths
                $pdf->Cell(50, 10, ucfirst(str_replace('_', ' ', $key)) . ':', 0, 0);
                $pdf->Cell(0, 10, $value, 0, 1);
            }
        }

        // Add a paragraph of text
        $pdf->Ln(10);
        $pdf->MultiCell(0, 10, "This document verifies that the individual named above has been confirmed by the local police department. Details provided in this report are subject to police verification and any discrepancies found could lead to legal actions.");

        // Signature
        $pdf->Ln(10);
        $pdf->Cell(0, 10, 'Officer\'s Signature: ', 0, 1);
        $pdf->Image('sign.jpg', $pdf->GetX(), $pdf->GetY(), 40); // Adjust the path and dimensions

        // Footer note
        $pdf->Ln(20);
        $pdf->Cell(0, 10, 'Please keep this report for your records.', 0, 1, 'C');
        $reportsDirectory = 'reports'; // Make sure this directory exists

        $filename = "police_report_" . $reportId . ".pdf"; // Construct the file name
        $savePath = $reportsDirectory . '/' . $filename;

        // Output the PDF to the browser
        $pdf->Output('F', $savePath);

        header('Location: approve.php?status=success');

        
    } else {
        die("Report with ID $reportId not found or status not 'Address Verified'.");
    }
} else {
    die("Invalid request method or missing report ID.");
}
?> 