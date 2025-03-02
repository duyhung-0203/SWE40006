<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags to define character encoding, responsiveness, and basic page description -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Web Application Development :: Assignment 1">
    <meta name="keywords" content="Web,programming">
    <meta name="author" author="Do Duy Hung">

    <!-- Link to external stylesheet -->
    <link rel="stylesheet" href="styles/styles.css">
    <title>Duy Hung Post Job</title> <!-- Page title -->
</head>

<body>
    <!-- Main heading for the job vacancy posting system -->
    <h1 class="header">Job Vacancy Posting System</h1>

    <!-- Navigation bar linking to other parts of the application -->
    <nav>
        <ul class="list">
            <li class="content"><a class="btn" href="index.php">Home</a></li>
            <li class="content"><a class="btn" href="postjobform.php">Post a job vacancy</a></li>
            <li class="content now"><a class="btn" href="searchjobform.php">Search for a job vacancy</a></li>
            <li class="content"><a class="btn" href="about.php">About this assignment</a></li>
        </ul>
    </nav>

    <!-- Search job form allowing users to search for a job -->
    <form action="searchjobprocess.php" method="get">
        <!-- Input for job title -->
        <label for="title" class="label">Job Title:</label>
        <input type="text" name="title" id="title" class="input" placeholder="e.g: Data Scientist" novalidate> <!-- Placeholder text for the job title -->

        <!-- Radio buttons for Position (Full Time / Part Time) -->
        <label for="position" class="label">Position</label>
        <input type="radio" name="position" id="position_fulltime" value="Full Time"> Full Time
        <input type="radio" name="position" id="position_parttime" value="Part Time"> Part Time

        <!-- Radio buttons for Contract Type (On-going / Fixed Term) -->
        <label for="contract" class="label">Contract</label>
        <input type="radio" name="contract" id="contract_onetime" value="On-going"> On-going
        <input type="radio" name="contract" id="contract_fixedterm" value="Fixed Term"> Fixed Term

        <!-- Checkboxes for Application Method (Post / Email) -->
        <label for="application_post" class="label">Application by</label>
        <input type="checkbox" name="accept_application_post" value="Post"> Post
        <input type="checkbox" name="accept_application_email" value="Email"> Email

        <!-- Dropdown list for selecting the job location -->
        <label for="location" class="label">Location</label>
        <select name="location" id="location" class="input">
            <option value="...">...</option>
            <option value="ACT">ACT</option>
            <option value="NSW">NSW</option>
            <option value="NT">NT</option>
            <option value="QLD">QLD</option>
            <option value="SA">SA</option>
            <option value="TAS">TAS</option>
            <option value="VIC">VIC</option>
            <option value="WA">WA</option>
        </select>

        <!-- Submit and Reset buttons -->
        <input type="submit" value="Search" class="btn"> <!-- Search button -->
        <input type="reset" value="Reset" class="btn-reset"> <!-- Reset form button -->

        <!-- Link to return to home page -->
        <br><br>
        <a href="index.php">Return to Home Page</a>
    </form>

    <!-- Footer section -->
    <footer>
        <div class="box_footer">
            <!-- Quick links in the footer -->
            <div class="box">
                <div class="footer_properties">
                    <h3>Quick links</h3>
                </div>
                <a href="index.php"><i class="fa-solid fa-house"> Home</i></a>
                <a href="about.php"><i class="fa-regular fa-user"> About</i></a>
                <a href="postjobform.php"><i class="fa-solid fa-suitcase"> Jobs Posted</i></a>
                <a href="searchjobform.php"><i class="fa-solid fa-file-lines"> Job Searched</i></a>
            </div>

            <!-- Contact section with social media links -->
            <div class="box">
                <div class="footer_properties">
                    <h3>Contact us</h3>
                </div>
                <a href="#"><i class="fa-brands fa-facebook"> FaceBook</i></a>
                <a href="#"><i class="fa-brands fa-instagram"> Instagram</i></a>
                <a href="#"><i class="fa-brands fa-youtube"> Youtube</i></a>
            </div>

            <!-- Address section -->
            <div class="box">
                <div class="footer_properties">
                    <h3>Address</h3>
                </div>
                <address><i class="fa-solid fa-map-pin"> 80 Duy Tan, Cau Giay, Ha Noi</i></address>
                <address><i class="fa-solid fa-map-pin"> 02 Duong Khue, Mai Dich, Cau Giay, Hanoi</i></address>
            </div>
        </div>
        
        <!-- Footer copyright information -->
        <hr>
        <p class="copy-right">Copyright © HUNG JOBSEARCH</p>
    </footer>

</body>

</html>
