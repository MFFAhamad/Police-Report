<?php
require 'db.php'; // Adjust the path as necessary

// Initialize the Database
$db = new Database();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reportId'])) {
    $reportId = $_POST['reportId']; // Get the report ID from POST method, ensure you validate and sanitize this

    // Fetch the report status
    $status = $db->getReportStatus($reportId);

    $statuses = [
        "Pending",
        "Reviewed",
        "Police Book Checked",
        "Village Visit",
        "Address Verified"
    ];

    $currentStatusIndex = array_search($status, $statuses);

    // Check if the PDF file exists
    $pdfFilePath = "reports/police_report_" . $reportId . ".pdf";
    $pdfExists = file_exists($pdfFilePath);
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Status</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        .status-step.completed .fa-circle {
            display: none; // Hide the incomplete status icon when the step is completed
        }
        .status-step:not(.completed) .fa-check-circle {
            display: none; // Hide the completed status icon when the step is not completed
        }
        .status-step.completed {
            color: green; // Color for completed steps
        }
        .status-icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
<?php include 'nav.php';?>

<div class="container mt-5">
    <h2 class="mb-4">Report Status</h2>
    <ul class="list-group">
        <?php if (isset($status)): ?>
            <?php foreach ($statuses as $index => $stage): ?>
                <li class="list-group-item status-step <?= $index <= $currentStatusIndex ? 'completed' : '' ?>">
                    <i class="fas fa-check-circle status-icon"></i>
                    <i class="far fa-circle status-icon"></i>
                    <?= htmlspecialchars($stage); ?>
                </li>
            <?php endforeach; ?>
            <?php if ($pdfExists): ?>
                <li class="list-group-item">
                    <a href="<?= htmlspecialchars($pdfFilePath) ?>" class="btn btn-primary" download>Download Police Report</a>
                </li>
            <?php endif; ?>
        <?php else: ?>
            <p>Report not found or invalid report ID.</p>
        <?php endif; ?>
    </ul>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
