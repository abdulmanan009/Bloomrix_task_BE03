<?php

// Session must be started on every page that uses sessions
session_start();

// If no session data, redirect back to form
// This prevents direct access to this page
if (!isset($_SESSION['name'])) {
    header("Location: index.php");
    exit();
}

// Read data from session
$name   = $_SESSION['name'];
$email  = $_SESSION['email'];
$age    = $_SESSION['age'];
$city   = $_SESSION['city'];
$gender = $_SESSION['gender'];

// Read file info if uploaded
$fileName = isset($_SESSION['file_name']) ? $_SESSION['file_name'] : "No file uploaded";
$fileSize = isset($_SESSION['file_size']) ? $_SESSION['file_size'] . " bytes" : "";

// Clear session data after reading
session_destroy();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Successful</title>
</head>
<body>

    <h1>Registration Successful!</h1>
    <p>Thank you <strong><?php echo $name; ?></strong>, your form has been submitted.</p>

    <h2>Your Submitted Information:</h2>
    <p>Name: <?php echo $name; ?></p>
    <p>Email: <?php echo $email; ?></p>
    <p>Age: <?php echo $age; ?></p>
    <p>City: <?php echo $city; ?></p>
    <p>Gender: <?php echo $gender; ?></p>
    <p>Uploaded File: <?php echo $fileName; ?> <?php echo $fileSize; ?></p>

    <br>
    <a href="index.php">Go Back to Form</a>

</body>
</html>
