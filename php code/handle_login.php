<?php
session_start();

// Hardcoded credentials for demonstration purposes
$correctUsername = 'admin';
$correctPassword = 'admin';

// Get the username and password from POST request
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Check credentials
if ($username === $correctUsername && $password === $correctPassword) {
    // Credentials are correct, redirect to update_report.php
    $_SESSION['loggedin'] = true;
    header('Location: update_report.php');
    exit;
} else {
    // Credentials are incorrect, redirect to the login page with an error
    $_SESSION['error'] = 'Incorrect username or password.';
    header('Location: login.php');
    exit;
}
?>
