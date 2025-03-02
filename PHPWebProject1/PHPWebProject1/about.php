<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags for page setup -->
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
    <!-- Main header for the Job Vacancy Posting System -->
    <h1 class="header">Job Vacancy Posting System</h1>

    <!-- Navigation bar for the website -->
    <nav>
        <ul class="list">
            <li class="content"><a class="btn" href="index.php">Home</a></li>
            <li class="content"><a class="btn" href="postjobform.php">Post a job vacancy</a></li>
            <li class="content"><a class="btn" href="searchjobform.php">Search for a job vacancy</a></li>
            <li class="content now"><a class="btn" href="about.php">About this assignment</a></li>
        </ul>
    </nav>

    <!-- Information section that answers the assignment requirements -->
    <div class="information">
        <!-- Row for answering the first set of assignment questions -->
        <div class="row">
            <div class="task">
                Req 1: List your answers in bullet point for each question. The requirements are as follows:
                
                <!-- Question 1 -->
                <div class="question">
                    1. What is the PHP version installed in mercury? (Use PHP function to generate this answer)
                </div>
                <!-- Answer using PHP's built-in version function -->
                <div class="answer">
                    <?php
                    echo "The version of PHP installed on Mercury is: ";
                    echo phpversion(); // Display PHP version
                    ?>
                </div>

                <!-- Question 2 -->
                <div class="question">
                    2. What tasks you have not attempted or not completed?
                </div>
                <div class="answer">
                    I have completed all the tasks. I think I have done well. <!-- Your answer for this task -->
                </div>

                <!-- Question 3 -->
                <div class="question">
                    3. What special features have you done, or attempted, in creating the site that we should know
                    about?
                </div>
                <div class="answer">
                    I have done all the tasks as required. I have also added a footer to the website. I have also added
                    a hover effect to the buttons in the navigation bar. <!-- Listing the features you've implemented -->
                </div>
            </div>
        </div>

        <!-- Row for answering the second set of assignment questions -->
        <div class="row">
            <div class="task">
                Req 2: Provide a screen shot for the following
                <!-- Question 1 -->
                <div class="question">
                    1. What discussion points did you participate on in the unit's discussion board for Assignment 1? If you did not participate, state your reason.
                </div>
                <div class="answer">
                    I did not have any exchanges or questions with anyone on the discussion board for Assignment 1.
                    Because I find Assignment 1 not too difficult and the requirements are still manageable for me, I
                    don't see the need for discussion at this point. Perhaps for Assignment 2, I will consider using it.
                </div>
                
                <!-- Image for the discussion board -->
                <div class="image">
                    <img src="images/assign1.png" alt="Discussion Board"> <!-- Screenshot of your discussion board -->
                </div>
            </div>
        </div>
    </div>

    <!-- Footer section -->
    <footer>
        <div class="box_footer">
            <!-- Quick links section in the footer -->
            <div class="box">
                <div class="footer_properties">
                    <h3>Quick links</h3>
                </div>
                <a href="index.php"><i class="fa-solid fa-house"> Home</i></a>
                <a href="about.php"><i class="fa-regular fa-user"> About</i></a>
                <a href="postjobform.php"><i class="fa-solid fa-suitcase"> Jobs Posted</i></a>
                <a href="searchjobform.php"><i class="fa-solid fa-file-lines"> Job Searched</i></a>
            </div>

            <!-- Contact information section in the footer -->
            <div class="box">
                <div class="footer_properties">
                    <h3>Contact us</h3>
                </div>
                <a href="#"><i class="fa-brands fa-facebook"> FaceBook</i></a>
                <a href="#"><i class="fa-brands fa-instagram"> Instagram</i></a>
                <a href="#"><i class="fa-brands fa-youtube"> Youtube</i></a>
            </div>

            <!-- Address section in the footer -->
            <div class="box">
                <div class="footer_properties">
                    <h3>Address</h3>
                </div>
                <address><i class="fa-solid fa-map-pin"> 80 Duy Tan, Cau Giay, Ha Noi</i></address>
                <address><i class="fa-solid fa-map-pin"> 02 Duong Khue, Mai Dich, Cau Giay, Hanoi</i></address>
            </div>
        </div>

        <!-- Footer bottom with copyright -->
        <hr>
        <p class="copy-right">Copyright © HUNG JOBSEARCH</p>
    </footer>
</body>

</html>
