<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags to define character encoding, responsive behavior, and page description -->
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
    <!-- Main header for the job vacancy posting system -->
    <h1 class="header">Job Vacancy Posting System</h1>

    <!-- Navigation bar with links to other sections -->
    <nav>
        <ul class="list">
            <li class="content"><a class="btn" href="index.php">Home</a></li>
            <li class="content"><a class="btn" href="postjobform.php">Post a job vacancy</a></li>
            <li class="content now"><a class="btn" href="searchjobform.php">Search for a job vacancy</a></li>
            <li class="content"><a class="btn" href="about.php">About this assignment</a></li>
        </ul>
    </nav>

    <?php
    // Function to convert date from dd/mm/yyyy to a timestamp format for easier comparison
    function convertToDateTimestamp($date)
    {
        $dateParts = explode('/', $date); // Split the date into day, month, and year
        return strtotime($dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0]); // Convert to timestamp with full year
    }

    // Get all search inputs from the form
    $jobTitle = isset($_GET['title']) ? trim($_GET['title']) : '';  // Job title
    $position = isset($_GET['position']) ? $_GET['position'] : '';  // Job position (Full Time / Part Time)
    $contract = isset($_GET['contract']) ? $_GET['contract'] : '';  // Contract type (On-going / Fixed Term)
    $applicationPost = isset($_GET['accept_application_post']) ? 'Post' : '';  // Application by post
    $applicationEmail = isset($_GET['accept_application_email']) ? 'Email' : '';  // Application by email
    $location = isset($_GET['location']) ? $_GET['location'] : '';  // Job location

    // Check if no criteria are provided and location is set to "..."
    if (empty($jobTitle) && empty($position) && empty($contract) && empty($applicationPost) && empty($applicationEmail) && $location === '...') {
        $displayAll = true;  // If no search criteria are entered, display all jobs
    } else {
        $displayAll = false;  // Otherwise, apply filtering based on criteria
    }

    // Path to the job postings file
    $jobFile = '../../data/jobposts/jobs.txt';

    // Check if the job postings file exists
    if (!file_exists($jobFile)) {
        // Display an error message if the job file is missing
        echo "<div class='search-error-container'>";
        echo "<p class='search-error-message'>Error: Job postings file not found.</p>";
        echo '<a href="searchjobform.php" class="btn-search">Return to Search Page</a><br>';
        echo '<a href="index.php" class="btn-search">Return to Home Page</a>';
        echo "</div>";
        exit;
    }

    // Read the job postings from the file
    $jobs = file($jobFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);  // Load job data from the file
    $foundJobs = [];  // Array to store jobs that match the search criteria
    $expiredJobs = [];  // Array to store expired jobs

    // Filter jobs based on all search inputs or display all if $displayAll is true
    foreach ($jobs as $job) {
        $jobDetails = explode("\t", $job);  // Split each job posting into details

        // Ensure the job entry contains all necessary details (at least 9 elements)
        if (count($jobDetails) < 9) {
            // Skip the job if it doesn't have the required fields
            continue;
        }

        // Convert closing date to timestamp for comparison
        $closingDateTimestamp = convertToDateTimestamp($jobDetails[3]);
        $currentTimestamp = strtotime('today');  // Get current timestamp for today's date

        // If no criteria are entered, display all jobs (skipping the filtering process)
        if ($displayAll) {
            // Categorize expired jobs separately
            if ($closingDateTimestamp < $currentTimestamp) {
                $expiredJobs[] = $jobDetails;
            } else {
                $foundJobs[] = $jobDetails;
            }
            continue;
        }

        // Assume the job matches the criteria until proven otherwise
        $jobMatches = true;

        // Match job title (if provided)
        if (!empty($jobTitle) && stripos($jobDetails[1], $jobTitle) === false) {
            $jobMatches = false;
        }

        // Match position (if provided)
        if (!empty($position) && stripos($jobDetails[4], $position) === false) {
            $jobMatches = false;
        }

        // Match contract (if provided)
        if (!empty($contract) && stripos($jobDetails[5], $contract) === false) {
            $jobMatches = false;
        }

        // Match application method (post) if provided
        if (!empty($applicationPost) && stripos($jobDetails[6], 'Post') === false) {
            $jobMatches = false;
        }

        // Match application method (email) if provided
        if (!empty($applicationEmail) && strpos($jobDetails[7], 'Email') === false) {
            $jobMatches = false;
        }

        // Match location (if provided)
        if (!empty($location) && $location !== '...' && $jobDetails[8] !== $location) {
            $jobMatches = false;
        }

        // If the job matches all criteria, categorize it as found or expired
        if ($jobMatches) {
            if ($closingDateTimestamp < $currentTimestamp) {
                $expiredJobs[] = $jobDetails;  // Add to expired jobs if the closing date has passed
            } else {
                $foundJobs[] = $jobDetails;  // Otherwise, add to found jobs
            }
        }
    }

    // If no jobs match the criteria, display an error message
    if (count($foundJobs) == 0 && count($expiredJobs) == 0) {
        echo "<div class='search-error-container'>";
        echo "<p class='search-error-message'>No job vacancies match your search criteria.</p>";
        echo '<a href="searchjobform.php" class="btn-search">Return to Search Page</a><br>';
        echo '<a href="index.php" class="btn-search">Return to Home Page</a>';
        echo "</div>";
    } elseif (count($foundJobs) == 0 && count($expiredJobs) > 0) {
        // If only expired jobs match the search criteria, display an alert
        echo "<div class='search-error-container'>";
        echo "<p class='search-error-message'>The job you searched has expired.</p>";
        echo '<a href="searchjobform.php" class="btn-search">Return to Search Page</a><br>';
        echo '<a href="index.php" class="btn-search">Return to Home Page</a>';
        echo "</div>";
    } else {
        // Sort jobs by closing date (most future dates first)
        usort($foundJobs, function ($a, $b) {
            return convertToDateTimestamp($b[3]) - convertToDateTimestamp($a[3]);
        });

        // Display the search results
        echo "<h2 class='search-results-title'>Job Vacancy Information</h2>";
        foreach ($foundJobs as $job) {
            // Escape double quotes for display in the description
            $description = htmlspecialchars($job[2], ENT_QUOTES);

            echo "<div class='job-container-search'>";
            echo "<p><strong>Job Title:</strong> {$job[1]}<br>";
            echo "<strong>Description:</strong> “{$description}”<br>";  // Display description with double quotes
            echo "<strong>Closing Date:</strong> {$job[3]}<br>";  // Closing date is now in dd/mm/yyyy format
            echo "<strong>Position:</strong> {$job[5]} - {$job[4]}<br>";
            echo "<strong>Application By:</strong> {$job[6]} {$job[7]}<br>";
            echo "<strong>Location:</strong> {$job[8]}</p><hr>";
            echo '<a href="searchjobform.php" class="btn-search">Return to Search Page</a><br>';
            echo '<a href="index.php" class="btn-search">Return to Home Page</a>';
            echo "</div>";
        }
    }
?>

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

        <!-- Horizontal rule and copyright -->
        <hr>
        <p class="copy-right">Copyright © HUNG JOBSEARCH</p>
    </footer>
</body>

</html>

