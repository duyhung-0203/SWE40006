<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags to define character encoding, responsive behavior, and basic description -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Web Application Development :: Assignment 1">
    <meta name="keywords" content="Web,programming">
    <meta name="author" content="author" author="Do Duy Hung">

    <!-- Link to external CSS stylesheet -->
    <link rel="stylesheet" href="styles/styles.css">
    <title>Duy Hung Post Job</title> <!-- Title of the webpage -->
    <!-- Mercury link: https://mercury.swin.edu.au/cos30020/s104182779/assign1/ -->
</head>

<body>
    <!-- Main heading of the page -->
    <h1 class="header">Job Vacancy Posting System</h1>

    <!-- Navigation bar -->
    <nav>
    <ul class="list">
        <!-- Links to different sections of the system -->
        <li class="content now"><a class="btn" href="index.php">Home</a></li>
        <li class="content"><a class="btn" href="postjobform.php">Post a job vacancy</a></li>
        <li class="content"><a class="btn" href="searchjobform.php">Search for a job vacancy</a></li>
        <li class="content"><a class="btn" href="about.php">About this assignment</a></li>
    </ul>
    </nav>

    <!-- Section for displaying user information -->
    <div class="information">
        <div class="row">
            <div class="name">
                <p>Name: </p>
            </div>
            <div class="infor-name">
                <p>Duy Hung Do</p> <!-- User's name -->
            </div>
        </div>

        <div class="row">
            <div class="name">
                <p>Student ID: </p>
            </div>
            <div class="infor-name">
                <p>104182779</p> <!-- Student ID -->
            </div>
        </div>

        <div class="row">
            <div class="name">
                <p>Email </p>
            </div>
            <div class="infor-name">
                <!-- Email link for user -->
                <p class="mail"><a href="mailto:104182779@student.swin.edu.au">104182779@student.swin.edu.au</a></p>
            </div>
        </div>

        <!-- Declaration statement for assignment integrity -->
        <div class="row">
            <p class="para">I declare that this assignment is my individual work. I have not worked collaboratively, nor
                have I copied from any other student's work or from any other source</p>
        </div>

        <!-- Placeholder div for content push effect (if necessary) -->
        <div class="push">
        </div>

    </div>

    <!-- Footer section -->
    <footer>
        <div class="box_footer">
            <!-- Quick links section -->
            <div class="box">
                <div class="footer_properties">
                    <h3>Quick links</h3>
                </div>
                <a href="index.php"><i class="fa-solid fa-house"> Home</i></a>
                <a href="about.php"><i class="fa-regular fa-user"> About</i></a>
                <a href="postjobform.php"><i class="fa-solid fa-suitcase"> Jobs Posted</i></a>
                <a href="searchjobform.php"><i class="fa-solid fa-file-lines"> Job Searched</i></a>
            </div>

            <!-- Contact us section with social media links -->
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
