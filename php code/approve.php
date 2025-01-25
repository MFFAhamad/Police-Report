<?php
require 'db.php'; // Your database class that handles connections

// Initialize the Database
$db = new Database();
$conn = $db->getConnection();

// Fetch only those reports with 'Address Verified' status
$stmt = $conn->prepare("SELECT * FROM report WHERE status = 'Address Verified'");
$stmt->execute();
$reports = $stmt->get_result();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Report Status</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>
<body>
<?php include 'adminnav.php';?>
<?php
$message = '';
$messageType = 'danger'; // Default to 'danger' for errors

if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $message = 'Police report generated successfully';
            $messageType = 'success'; // Change type for success messages
            break;
   
    }
}
?>


<?php if ($message): ?>
    <div class="alert alert-<?php echo $messageType; ?>" role="alert">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>


<body>
<div class="container report-container">
    <h2>Address Verified Reports</h2>
    <?php while($report = $reports->fetch_assoc()): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($report['name']) ?></h5>
                <p class="card-text"><?= htmlspecialchars($report['address']) ?></p>
                <div>
                    <img src="<?= htmlspecialchars($report['id_image_path']) ?>" alt="ID Image" class="image">
                    <?php if ($report['id_back']): ?>
                        <img src="<?= htmlspecialchars($report['id_back']) ?>" alt="ID Back" class="image">
                    <?php endif; ?>
                </div>
                <form action="police_report.php" method="post">
                    <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                    <button type="submit" class="btn btn-primary">Generate Police Report</button>
                </form>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
