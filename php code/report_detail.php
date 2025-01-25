<?php
require 'db.php'; // Assuming you have a Database class for handling database connections

// Your logic to retrieve a report ID would go here
// For this example, we're getting it from the query string
if(isset($_GET['report_id']) && is_numeric($_GET['report_id'])) {
    $reportId = intval($_GET['report_id']);

    // Initialize the Database
    $db = new Database();
    $conn = $db->getConnection();

    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM report WHERE id = ?");
    $stmt->bind_param("i", $reportId);
    $stmt->execute();
    $result = $stmt->get_result();
    $report = $result->fetch_assoc();

    if (!$report) {
        die('Report not found.');
    }
} else {
    die('Invalid report ID.');
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        .container {
            margin-top: 20px;
        }
        .image-preview {
            width: 100%;
            max-width: 400px;
            height: auto;
            margin-bottom: 20px;
        }
        .image-container {
    display: flex;
    align-items: center;
    justify-content: flex-start; /* Align items on the left */
    margin: 20px;
}

.image-box {
    margin-right: 10px; /* Reduce space between images */
    text-align: center; /* Center labels under images */
}



label {
    display: block; /* Make labels block level for better control */
    font-size: 14px;
    color: #333;
}
.image-preview {
    width: 400px;
    transition: transform 0.3s ease-in-out;
    cursor: pointer;
    display: block;
    margin-bottom: 5px;
    transform-origin: center center; /* Ensures zoom centers on the image */
}

    </style>
</head>

<script>
document.querySelectorAll('.image-preview').forEach(image => {
    image.style.transform = 'scale(1)'; // Initialize transform property to ensure scaling works.

    image.addEventListener('click', (event) => {
        let currentScale = parseFloat(image.style.transform.replace('scale(', '').replace(')', ''));
        if (currentScale >= 5) { // Reset zoom if scale is 5 or higher.
            image.style.transform = 'scale(1)';
        } else {
            let newScale = currentScale * 1.5; // Increase scale by 50% each click
            image.style.transform = `scale(${newScale})`;
        }
        event.stopPropagation(); // Prevents event bubbling in case there are nested elements
    });
});


    </script>
<body>
<?php include 'adminnav.php';?>
<div class="container">
    <h2>Report Detail</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($report['name']) ?></h5>
            <p class="card-text"><strong>NIC:</strong> <?= htmlspecialchars($report['nic']) ?></p>
            <p class="card-text"><strong>Address:</strong> <?= htmlspecialchars($report['address']) ?></p>
            <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($report['email']) ?></p>
            <p class="card-text"><strong>Status:</strong> <?= htmlspecialchars($report['status']) ?></p>
            <p class="card-text"><strong>Created At:</strong> <?= htmlspecialchars($report['created_at']) ?></p>
            <div class="image-container">
        <div class="image-box">
            <img src="/police/<?= htmlspecialchars($report['id_image_path']) ?>" alt="ID Front" class="image-preview" id="img-id-front">
            <label for="img-id-front">ID Front</label>
        </div>
        <div class="image-box">
            <img src="/police/<?= htmlspecialchars($report['id_back']) ?>" alt="Person Image" class="image-preview" id="img-person">
            <label for="img-person">Person Image</label>
        </div>
    </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
