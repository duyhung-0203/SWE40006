<?php
$errors = [];  // Array to store error messages
$success_message = "";  // Variable to store success message

// Initialize variables to avoid undefined variable errors before form submission
$id = $title = $description = $closing = $position = $contract = $accept_application_post = $accept_application_email = $location = '';

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and process form data
    $id = trim($_POST['id']);  // Sanitize the ID
    $title = trim($_POST['title']);  // Sanitize the title
    $description = trim($_POST['description']);  // Sanitize the description
    $closing = trim($_POST['closing']);  // Sanitize the closing date
    $position = isset($_POST['position']) ? $_POST['position'] : '';  // Retrieve position value if set
    $contract = isset($_POST['contract']) ? $_POST['contract'] : '';  // Retrieve contract type
    $accept_application_post = isset($_POST['accept_application_post']) ? $_POST['accept_application_post'] : '';  // Application by post
    $accept_application_email = isset($_POST['accept_application_email']) ? $_POST['accept_application_email'] : '';  // Application by email
    
    // Handle the "Application by" checkboxes
    $applicationBy = [];
    if (isset($_POST['accept_application_post'])) {
        $applicationBy[] = 'Post';  // Add "Post" to the application methods
    }
    if (isset($_POST['accept_application_email'])) {
        $applicationBy[] = 'Email';  // Add "Email" to the application methods
    }

    // Validate input fields
    if (empty($id)) {
        $errors[] = "Position ID is required.";  // Error if ID is empty
    } elseif (!preg_match("/^PID\d{4}$/", $id)) {
        $errors[] = "Position ID must start with 'PID' followed by 4 digits.";  // Validate format
    } elseif (check_position_id_exist($id)) {
        $errors[] = "Position ID already exists.";  // Check for duplicate ID
    }

    if (empty($title)) {
        $errors[] = "Title is required.";  // Error if title is empty
    } elseif (!preg_match("/^[A-Za-z0-9\s,.!]{1,20}$/", $title)) {
        $errors[] = "Title can only contain a maximum of 20 alphanumeric characters including spaces, comma, period, and exclamation point.";  // Title validation
    }

    if (empty($description)) {
        $errors[] = "Description is required.";  // Error if description is empty
    } elseif (strlen($description) > 250) {
        $errors[] = "Description can only contain a maximum of 250 characters.";  // Description length validation
    }

    if (empty($closing)) {
        $errors[] = "Closing Date is required.";  // Error if closing date is empty
    } elseif (!validate_date_format($closing)) {
        $errors[] = "Closing Date must be in dd/mm/yy format or The closing date is not a server date.";  // Validate date format
    }

    if (empty($position)) {
        $errors[] = "Position is required.";  // Error if position is not selected
    }

    if (empty($contract)) {
        $errors[] = "Contract is required.";  // Error if contract type is not selected
    }

    if (empty($accept_application_post) && empty($accept_application_email)) {
        $errors[] = "At least one Accept Application option (Post or Email) must be selected.";  // Error if neither application method is selected
    }

    if ($location == "...") {
        $errors[] = "Location is required.";  // Error if location is not selected
    }

    // If no errors, proceed to save data
    if (empty($errors)) {
        // Create the directory if it doesn't exist
        $directory = "../../data/jobposts";
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);  // Create directory with permissions if it doesn't exist
        }

        // Save data to jobs.txt file
        $data = "$id\t$title\t$description\t$closing\t$position\t$contract\t$accept_application_post\t$accept_application_email\t$location\n";
        file_put_contents("$directory/jobs.txt", $data, FILE_APPEND | LOCK_EX);  // Append the data to the file

        // Display success message
        $success_message = "Job vacancy saved successfully!";

        // Reset form values
        $id = $title = $description = $closing = $position = $contract = $accept_application_post = $accept_application_email = $location = '';
    }
}

// Function to check if Position ID already exists
function check_position_id_exist($id)
{
    $directory = "../../data/jobposts";  // Directory path for job posts
    $file_path = "$directory/jobs.txt";  // File path for jobs
    if (file_exists($file_path)) {
        $lines = file($file_path, FILE_IGNORE_NEW_LINES);  // Read lines from the file
        foreach ($lines as $line) {
            $data = explode("\t", $line);  // Split the data by tabs
            if ($data[0] == $id) {
                return true;  // If ID exists, return true
            }
        }
    }
    return false;  // Return false if ID does not exist
}

// Function to validate date format
function validate_date_format($date)
{
    $d = DateTime::createFromFormat('d/m/y', $date);  // Create DateTime object from date
    return $d && $d->format('d/m/y') == $date;  // Validate if format matches
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags for character set, responsiveness, and description -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="description" content="Web Application Development :: Assignment 1">
    <meta name="keywords" content="Web,programming">
    <meta name="author" author="Do Duy Hung">

    <!-- Link to external stylesheet -->
    <link rel="stylesheet" href="styles/styles.css">
    <title>Duy Hung Post Job</title> <!-- Page title -->
</head>

<body>
    <!-- Header for Job Vacancy Posting System -->
    <h1 class="header">Job Vacancy Posting System</h1>
    
    <!-- Navigation bar with links to other pages -->
    <nav>
        <ul class="list">
            <li class="content"><a class="btn" href="index.php">Home</a></li>
            <li class="content now"><a class="btn" href="postjobform.php">Post a job vacancy</a></li>
            <li class="content"><a class="btn" href="searchjobform.php">Search for a job vacancy</a></li>
            <li class="content"><a class="btn" href="about.php">About this assignment</a></li>
        </ul>
    </nav>

    <!-- Display error messages if there are validation errors -->
    <?php if (!empty($errors)): ?>
        <div class="error-message required">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo '<p class="error-message format">' . $error . '</p>'; ?></li>
                <?php endforeach; ?>
            </ul>

            <!-- Form to retain data and go back to post job form -->
            <form action="postjobform.php" method="post">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <input type="hidden" name="title" value="<?php echo htmlspecialchars($title); ?>">
                <input type="hidden" name="description" value="<?php echo htmlspecialchars($description); ?>">
                <input type="hidden" name="closing" value="<?php echo htmlspecialchars($closing); ?>">
                <input type="hidden" name="position" value="<?php echo htmlspecialchars($position); ?>">
                <input type="hidden" name="contract" value="<?php echo htmlspecialchars($contract); ?>">
                <input type="hidden" name="accept_application_post"
                    value="<?php echo htmlspecialchars($accept_application_post); ?>">
                <input type="hidden" name="accept_application_email"
                    value="<?php echo htmlspecialchars($accept_application_email); ?>">
                <input type="hidden" name="location" value="<?php echo htmlspecialchars($location); ?>">
                <input type="submit" value="Return to Post Job Vacancy Page" class="btn"> <!-- Button to return to the form -->
            </form>
            <p><a class="btn-reset" href="index.php">Return to Home Page</a></p> <!-- Button to return to home page -->
        </div>

    <!-- Display success message if the job was successfully posted -->
    <?php elseif (!empty($success_message)): ?>
        <div class="success-message">
            <?php echo '<p class="sucess-message">' . $success_message . '</p>'; ?> <!-- Display success message -->
            <p><a href="index.php">Return to Home Page</a></p> <!-- Button to return to home page -->
        </div>
    <?php endif; ?>

    <!-- Footer section -->
    <footer>
        <div class="box_footer">
            <!-- Quick links section -->
            <div class="box">
                <div class="footer_properties">
                    <h3>Quick links</h3>
                </div>
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="postjobform.php">Jobs Posted</a>
                <a href="searchjobform.php">Job Searched</a>
            </div>

            <!-- Contact section -->
            <div class="box">
                <div class="footer_properties">
                    <h3>Contact us</h3>
                </div>
                <a href="#">FaceBook</a>
                <a href="#">Instagram</a>
                <a href="#">Youtube</a>
            </div>

            <!-- Address section -->
            <div class="box">
                <div class="footer_properties">
                    <h3>Address</h3>
                </div>
                <address>80 Duy Tan, Cau Giay, Ha Noi</address>
                <address>02 Duong Khue, Mai Dich, Cau Giay, Hanoi</address>
            </div>
        </div>
        <hr>
        <p class="copy-right">Copyright © HUNG JOBSEARCH</p> <!-- Footer copyright -->
    </footer>
</body>

</html>

