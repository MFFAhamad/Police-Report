<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Submission Success</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
      
        .container {
            margin-top: 100px;

            max-width: 600px;
            margin: auto;
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .alert-note {
            margin-top: 100px;
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
            position: relative;
            padding: .75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
        }
    </style>
</head>
<body>
<?php include 'nav.php';?>

    <div class="container text-center">
        <?php
        session_start();
        if (isset($_SESSION['ref_number'])) {
            echo "<h2 class='mb-4'>Report Submitted Successfully!</h2>";
            echo "<p class='mb-3'>Your reference number is: <strong>" . htmlspecialchars($_SESSION['ref_number']) . "</strong></p>";
            echo "<p class='alert-note'>Please save this reference number to track the status of your report.</p>";
        } else {
            echo "<p>Sorry, there was an error processing your request. Please try again.</p>";
        }
        ?>
    </div>
    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
