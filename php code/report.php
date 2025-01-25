<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Police Report Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'nav.php';?>
    <div class="container mt-5">
        <h2>Police Report Form</h2>
        <form action="submit_report.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="nic">NIC:</label>
                <input type="text" class="form-control" id="nic" name="nic" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="id_front">ID (Front):</label>
                <input type="file" class="form-control-file" id="id_front" name="id_front" required>
            </div>
            <div class="form-group">
                <label for="id_back">ID (Back):</label>
                <input type="file" class="form-control-file" id="id_back" name="id_back" required>
            </div>
            <div class="form-group">
                <label for="person_image">Image of Person:</label>
                <input type="file" class="form-control-file" id="person_image" name="person_image" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit Report</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>