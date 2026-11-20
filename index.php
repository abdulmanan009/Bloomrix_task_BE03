<?php

// =============================================
// SESSION - Must be started at very top
// =============================================
session_start();

// =============================================
// COOKIE - Read cookie if it exists
// Pre-fill name field if user visited before
// =============================================
$rememberedName = "";

if (isset($_COOKIE['user_name'])) {
    $rememberedName = $_COOKIE['user_name'];
}

// =============================================
// VARIABLES - Set defaults to avoid errors
// =============================================
$name   = "";
$email  = "";
$age    = "";
$city   = "";
$gender = "";
$error  = "";

// =============================================
// POST FORM PROCESSING
// Runs only when form is submitted via POST
// =============================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // -----------------------------------------
    // STEP 1: GET DATA FROM $_POST
    // -----------------------------------------
    $name   = trim($_POST["name"]);
    $email  = trim($_POST["email"]);
    $age    = $_POST["age"];
    $city   = trim($_POST["city"]);
    $gender = $_POST["gender"];

    // -----------------------------------------
    // STEP 2: VALIDATE - Check required fields
    // -----------------------------------------
    if (empty($name) || empty($email) || empty($age) || empty($city) || empty($gender)) {
        $error = "Please fill in all fields.";
    }
    // Check email format using filter_var()
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    }
    // Check age is a valid number
    elseif (!filter_var($age, FILTER_VALIDATE_INT) || $age < 1) {
        $error = "Please enter a valid age.";
    }
    else {

        // -----------------------------------------
        // STEP 3: SANITIZE using htmlspecialchars()
        // Makes dangerous input safe before saving
        // -----------------------------------------
        $name   = htmlspecialchars($name);
        $email  = htmlspecialchars($email);
        $age    = htmlspecialchars($age);
        $city   = htmlspecialchars($city);
        $gender = htmlspecialchars($gender);

        // -----------------------------------------
        // STEP 4: SAVE DATA IN SESSION
        // So we can use it on the next page
        // -----------------------------------------
        $_SESSION['name']   = $name;
        $_SESSION['email']  = $email;
        $_SESSION['age']    = $age;
        $_SESSION['city']   = $city;
        $_SESSION['gender'] = $gender;

        // -----------------------------------------
        // STEP 5: SET A COOKIE
        // Remembers the user name for 1 day
        // 86400 seconds = 1 day
        // -----------------------------------------
        setcookie("user_name", $name, time() + 86400);

        // -----------------------------------------
        // STEP 6: HANDLE FILE UPLOAD ($_FILES)
        // -----------------------------------------
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {

            // Get file details from $_FILES
            $fileName = $_FILES['profile_pic']['name'];
            $fileSize = $_FILES['profile_pic']['size'];
            $fileTmp  = $_FILES['profile_pic']['tmp_name'];

            // Save file info in session
            $_SESSION['file_name'] = htmlspecialchars($fileName);
            $_SESSION['file_size'] = $fileSize;
        }

        // -----------------------------------------
        // STEP 7: REDIRECT using header()
        // Send user to thankyou.php after success
        // Always call exit() after header redirect
        // -----------------------------------------
        header("Location: thankyou.php");
        exit();
    }
}

// =============================================
// GET METHOD - Search form processing
// Data comes from URL: index.php?search=ali
// =============================================
$searchResult = "";

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    // Read from $_GET superglobal
    $searchTerm   = htmlspecialchars(trim($_GET['search']));
    $searchResult = "You searched for: <strong>" . $searchTerm . "</strong>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BE03 - PHP Forms & Superglobals</title>
</head>
<body>

    <h1>BE03 - PHP Forms, HTTP Methods & Superglobals</h1>

    <!-- ============================= -->
    <!-- $_SERVER - Server Information -->
    <!-- ============================= -->
    <h2>1. $_SERVER - Server Information</h2>
    <p>Request Method: <?php echo $_SERVER['REQUEST_METHOD']; ?></p>
    <p>Server Name: <?php echo $_SERVER['SERVER_NAME']; ?></p>
    <p>Current File: <?php echo $_SERVER['PHP_SELF']; ?></p>
    <p>Server Port: <?php echo $_SERVER['SERVER_PORT']; ?></p>
    <p>Server Software: <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>

    <hr>

    <!-- ============================= -->
    <!-- $_ENV - Environment Variable  -->
    <!-- ============================= -->
    <h2>2. $_ENV - Environment Variable</h2>
    <?php
    // $_ENV holds system environment variables
    // getenv() is a safe way to read them
    $phpVersion = phpversion();
    echo "<p>PHP Version: " . $phpVersion . "</p>";
    echo "<p>OS: " . PHP_OS . "</p>";
    echo "<p>Directory Separator: " . DIRECTORY_SEPARATOR . "</p>";
    ?>

    <hr>

    <!-- ============================= -->
    <!-- GET METHOD - Search Form      -->
    <!-- ============================= -->
    <h2>3. GET Method & $_GET</h2>
    <p>GET sends data in the URL. Example: <code>index.php?search=ali</code></p>

    <form method="GET" action="index.php">
        <label>Search Name:</label>
        <input type="text" name="search" placeholder="Type a name...">
        <button type="submit">Search</button>
    </form>

    <?php if ($searchResult != "") { ?>
        <p><?php echo $searchResult; ?></p>
    <?php } ?>

    <hr>

    <!-- ============================= -->
    <!-- $_REQUEST Demo                -->
    <!-- ============================= -->
    <h2>4. $_REQUEST - Works for Both GET and POST</h2>
    <?php
    // $_REQUEST contains data from both $_GET and $_POST
    if (!empty($_REQUEST)) {
        echo "<p>$_REQUEST received these keys:</p><ul>";
        foreach ($_REQUEST as $key => $value) {
            // Only show key names, not values (for privacy)
            echo "<li>" . htmlspecialchars($key) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No request data yet. Submit a form to see $_REQUEST in action.</p>";
    }
    ?>

    <hr>

    <!-- ============================= -->
    <!-- $_COOKIE - Cookie Info        -->
    <!-- ============================= -->
    <h2>5. $_COOKIE - Cookie Information</h2>
    <?php if (isset($_COOKIE['user_name'])) { ?>
        <p>Welcome back! Cookie remembers your name: <strong><?php echo $_COOKIE['user_name']; ?></strong></p>
    <?php } else { ?>
        <p>No cookie saved yet. Submit the registration form first.</p>
    <?php } ?>

    <hr>

    <!-- ============================= -->
    <!-- $_SESSION - Session Info      -->
    <!-- ============================= -->
    <h2>6. $_SESSION - Session Information</h2>
    <?php if (isset($_SESSION['name'])) { ?>
        <p>Session has data for: <strong><?php echo $_SESSION['name']; ?></strong></p>
    <?php } else { ?>
        <p>No session data yet. Submit the registration form first.</p>
    <?php } ?>

    <hr>

    <!-- ============================= -->
    <!-- POST METHOD - Registration    -->
    <!-- ============================= -->
    <h2>7. POST Method - Student Registration Form</h2>
    <p>POST hides data from the URL. Used for sensitive information.</p>

    <!-- Show error if any -->
    <?php if (!empty($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>

    <!--
        enctype="multipart/form-data" is REQUIRED for file uploads
        Without it, $_FILES will not work
    -->
    <form method="POST" action="index.php" enctype="multipart/form-data">

        <label>Name:</label><br>
        <!-- Pre-fill name from cookie if available -->
        <input type="text" name="name" value="<?php echo ($name != "" ? $name : $rememberedName); ?>">
        <br><br>

        <label>Email:</label><br>
        <input type="text" name="email" value="<?php echo $email; ?>">
        <br><br>

        <label>Age:</label><br>
        <input type="number" name="age" value="<?php echo $age; ?>">
        <br><br>

        <label>City:</label><br>
        <input type="text" name="city" value="<?php echo $city; ?>">
        <br><br>

        <label>Gender:</label><br>
        <select name="gender">
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        <br><br>

        <!-- FILE UPLOAD - handled by $_FILES -->
        <label>Profile Picture (optional):</label><br>
        <input type="file" name="profile_pic">
        <br><br>

        <button type="submit">Register</button>

    </form>

    <hr>

    <!-- ============================= -->
    <!-- HTTP RESPONSE CODES INFO      -->
    <!-- ============================= -->
    <h2>8. HTTP Response Codes</h2>
    <p>200 - OK (Page loaded successfully)</p>
    <p>301 - Moved Permanently (Redirect)</p>
    <p>302 - Found (Temporary Redirect - what header() does)</p>
    <p>404 - Not Found (Page does not exist)</p>
    <p>500 - Internal Server Error (PHP error)</p>

</body>
</html>
