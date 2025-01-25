<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track Police Report</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'nav.php';?>

    <div class="container mt-5">
        <h2>Track Your Police Report</h2>
        <p>Enter your reference number to check the status of your report.</p>
        <form action="view_report.php" method="post">
            <div class="form-group">
                <label for="reportId">Reference Number:</label>
                <input type="text" class="form-control" id="reportId" name="reportId" placeholder="Enter your reference number" required>
            </div>
            <button type="submit" class="btn btn-primary">Track Report</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
