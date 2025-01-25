<?php
require 'db.php';

$db = new Database();
$conn = $db->getConnection(); 


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $reportId = $_POST['report_id']; // The ID of the report to update
    $newStatus = $_POST['status']; // The new status

    // Update the report status in the database
    $stmt = $conn->prepare("UPDATE report SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $reportId);
    $stmt->execute();
    $stmt->close();
}

// Get the filter status from a GET request if set, or default to "Pending"
$filterStatus = isset($_GET['filter_status']) ? $_GET['filter_status'] : 'Pending';

// Fetch reports from the database with the filter applied
$stmt = $conn->prepare("SELECT * FROM report WHERE status = ? ORDER BY id DESC");
$stmt->bind_param("s", $filterStatus);
$stmt->execute();
$reports = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// List of possible statuses
$statuses = [
    "Pending",
    "Reviewed",
    "Police Book Checked",
    "Village Visit",
    "Address Verified"
];
?>
<!DOCTYPE html>
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

<div class="container mt-5">
    <h2>Update Report Status</h2>
    
    <!-- Filter Dropdown -->
    <form action="update_report.php" method="get">
        <select name="filter_status" onchange="this.form.submit()">
            <?php foreach ($statuses as $status): ?>
                <option value="<?= $status ?>" <?= $status === $filterStatus ? 'selected' : '' ?>>
                    <?= $status ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Status Update Form -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report): ?>
                <tr>
                    <td><?= htmlspecialchars($report['id']) ?></td>
                    <td><?= htmlspecialchars($report['name']) ?></td>
                    <td><?= htmlspecialchars($report['status']) ?></td>
                    <td>
                        <form action="update_report.php" method="post">
                            <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                            <select name="status">
                                <?php foreach ($statuses as $status): ?>
                                    <option value="<?= $status ?>" <?= $status === $report['status'] ? 'selected' : '' ?>>
                                        <?= $status ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-primary">Update</button>
                            <a href="report_detail.php?report_id=<?= $report['id'] ?>" class="btn btn-info">View Details</a>

                        </form>

                        
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>