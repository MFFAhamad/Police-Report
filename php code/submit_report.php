<?php
require 'db.php';
session_start();
  function generateUniqueFilename($extension) {
    return rand(99999, 999999) . '.' . $extension;
}
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define the file target
    $targetUrl = "http://127.0.0.1:5000/upload";

    // Prepare file data from the form for uploading
    $fileData = [
        'id_image' => new CURLFile($_FILES['id_front']['tmp_name'], $_FILES['id_front']['type'], $_FILES['id_front']['name']),
        'person_image' => new CURLFile($_FILES['person_image']['tmp_name'], $_FILES['person_image']['type'], $_FILES['person_image']['name'])
    ];

    // Initialize cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $targetUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fileData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the POST request
    $response = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    // Check for errors and process the response
    if ($error) {
        echo "cURL Error: " . $error;
    } else {
        // Assuming the Flask app returns a JSON response with a 'recognized' key
        $responseData = json_decode($response, true);
        
        // Redirect based on the recognition result
        if (isset($responseData['recognized']) && $responseData['recognized'] === true) {
            $targetDir = "uploads/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
        
            $images = ['id_front', 'person_image'];
            $imagePaths = [];
        
            foreach ($images as $image) {
                if (isset($_FILES[$image]) && $_FILES[$image]['error'] == 0) {
                    $fileTmpPath = $_FILES[$image]['tmp_name'];
                    $fileName = $_FILES[$image]['name'];
                    $fileType = $_FILES[$image]['type'];
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                        echo "Unsupported file type.";
                        exit;
                    }
                    $newFileName = generateUniqueFilename($extension);
                    $newFilePath = $targetDir . $newFileName;
                    if (move_uploaded_file($fileTmpPath, $newFilePath)) {
                        $imagePaths[$image] = $newFilePath;
                    } else {
                        echo "There was an error moving the uploaded file.";
                        exit;
                    }
                }
            }
        
            // Use the Database class to insert the form data
            $db = new Database();
            $refNumber = rand(99999, 999999);
            $success = $db->insertReport($refNumber,$_POST['name'], $_POST['nic'], $_POST['address'], $_POST['email'], $imagePaths['id_front'], $imagePaths['person_image']);
        
            if ($success) {
              


                $_SESSION['ref_number'] = $refNumber;
                header('Location: report_success.php');

                echo "Report submitted successfully.";
            } else {
                echo "Error submitting the report.";
            }
        } else {
            // Not a POST request
            echo "Invalid request.";
        }
            exit();
       
    }
} else {
    // Not a POST request, redirect to the form/report page
    header('Location: report.php');
    exit();
}




?>



