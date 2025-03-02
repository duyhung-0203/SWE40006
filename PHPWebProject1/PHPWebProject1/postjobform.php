<?php
// Initialize variables to avoid undefined variable errors before form submission
$id = $title = $description = $closing = $position = $contract = $accept_application_post = $accept_application_email = $location = '';

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and process form data here if needed
    // Example for sanitization:
    $id = trim($_POST['id']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $closing = trim($_POST['closing']);
    $position = isset($_POST['position']) ? $_POST['position'] : '';
    $contract = isset($_POST['contract']) ? $_POST['contract'] : '';
    $accept_application_post = isset($_POST['accept_application_post']) ? $_POST['accept_application_post'] : '';
    $accept_application_email = isset($_POST['accept_application_email']) ? $_POST['accept_application_email'] : '';
    $location = isset($_POST['location']) ? $_POST['location'] : '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta information to define character set, responsiveness, and page details -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="description" content="Web Application Development :: Assignment 1">
    <meta name="keywords" content="Web,programming">
    <meta name="author" content="Do Duy Hung">

    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="styles/styles.css">
    <title>Duy Hung Post Job</title> <!-- Webpage title -->
</head>

<body>
    <!-- Main header for the Job Vacancy Posting System -->
    <h1 class="header">Job Vacancy Posting System</h1>

    <!-- Navigation bar linking to different sections of the site -->
    <nav>
        <ul class="list">
            <li class="content"><a class="btn" href="index.php">Home</a></li>
            <li class="content now"><a class="btn" href="postjobform.php">Post a job vacancy</a></li>
            <li class="content"><a class="btn" href="searchjobform.php">Search for a job vacancy</a></li>
            <li class="content"><a class="btn" href="about.php">About this assignment</a></li>
        </ul>
    </nav>

    <!-- Job post form allowing users to submit a new job -->
    <form action="postjobprocess.php" method="post">
        <!-- Input for Position ID -->
        <label for="id" class="label">Position ID</label>
        <input type="text" name="id" id="id" class="input" placeholder="e.g: PID0001"
            value="<?php echo htmlspecialchars($id); ?>">

        <!-- Input for Job Title -->
        <label for="title" class="label">Title</label>
        <input type="text" name="title" id="title" class="input" placeholder="e.g: Data Scientist"
            value="<?php echo htmlspecialchars($title); ?>">

        <!-- Text area for Job Description -->
        <label for="description" class="label">Description</label>
        <textarea name="description" id="description" class="input"
            placeholder="e.g: Describe the position"><?php echo htmlspecialchars($description); ?></textarea>

        <!-- Input for Closing Date -->
        <label for="closing" class="label">Closing Date</label>
        <input type="text" name="closing" id="closing" class="input" placeholder="e.g: dd/mm/yy"
            value="<?php echo htmlspecialchars($closing); ?>">

        <!-- Radio buttons for Job Position (Full Time / Part Time) -->
        <label for="position" class="label">Position</label>
        <input type="radio" name="position" id="position_fulltime" value="Full Time" <?php echo ($position == 'Full Time') ? 'checked' : ''; ?>>Full Time
        <input type="radio" name="position" id="position_parttime" value="Part Time" <?php echo ($position == 'Part Time') ? 'checked' : ''; ?>>Part Time

        <!-- Radio buttons for Contract Type (On-going / Fixed Term) -->
        <label for="contract" class="label">Contract</label>
        <input type="radio" name="contract" id="contract_onetime" value="On-going" <?php echo ($contract == 'On-going') ? 'checked' : ''; ?>>On-going
        <input type="radio" name="contract" id="contract_fixedterm" value="Fixed Term" <?php echo ($contract == 'Fixed Term') ? 'checked' : ''; ?>>Fixed Term

        <!-- Checkboxes for Application Method (Post / Email) -->
        <label for="application_post" class="label">Application by</label>
        <input type="checkbox" name="accept_application_post" value="Post" <?php if ($accept_application_post == 'Post') echo 'checked'; ?>> Post
        <input type="checkbox" name="accept_application_email" value="Email" <?php if ($accept_application_email == 'Email') echo 'checked'; ?>> Email

        <!-- Dropdown list for selecting the job location -->
        <label for="location" class="label">Location</label>
        <select name="location" id="location" class="input">
            <option value="..." <?php echo ($location == '...') ? 'selected' : ''; ?>>...</option>
            <option value="ACT" <?php echo ($location == 'ACT') ? 'selected' : ''; ?>>ACT</option>
            <option value="NSW" <?php echo ($location == 'NSW') ? 'selected' : ''; ?>>NSW</option>
            <option value="NT" <?php echo ($location == 'NT') ? 'selected' : ''; ?>>NT</option>
            <option value="QLD" <?php echo ($location == 'QLD') ? 'selected' : ''; ?>>QLD</option>
            <option value="SA" <?php echo ($location == 'SA') ? 'selected' : ''; ?>>SA</option>
            <option value="TAS" <?php echo ($location == 'TAS') ? 'selected' : ''; ?>>TAS</option>
            <option value="VIC" <?php echo ($location == 'VIC') ? 'selected' : ''; ?>>VIC</option>
            <option value="WA" <?php echo ($location == 'WA') ? 'selected' : ''; ?>>WA</option>
        </select>

        <!-- Submit and Reset buttons -->
        <input type="submit" value="Post" class="btn">
        <input type="reset" value="Reset" class="btn-reset">

        <!-- Note about required fields -->
        <br><br>
        <p class="fields">All fields are required.<a href="index.php">Return to Home Page</a></p>
    </form>

    <!-- Footer section -->
    <footer>
        <div class="box_footer">
            <!-- Quick links in the footer -->
            <div class="box">
                <div class="footer_properties">
                    <h3>Quick links</h3>
                </div>
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="postjobform.php">Jobs Posted</a>
                <a href="searchjobform.php">Job Searched</a>
            </div>

            <!-- Contact section with social media links -->
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
        <p class="copy-right">Copyright © HUNG JOBSEARCH</p>
    </footer>
</body>

</html>
