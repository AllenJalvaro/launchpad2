<?php
require "config.php";

if (empty($_SESSION["email"])) {
    header("Location: login.php");
    exit(); 
}

$userEmail = $_SESSION["email"];


$checkCompanyQuery = "SELECT c.*, s.Student_ID 
                      FROM company_registration c
                      INNER JOIN student_registration s ON c.Student_ID = s.Student_ID
                      WHERE s.Student_email = '$userEmail'";

$resultCompany = mysqli_query($conn, $checkCompanyQuery);

$hasCompany = mysqli_num_rows($resultCompany) > 0;
$companyName = "";
$companyLogo = "";

if ($hasCompany) {
    $row = mysqli_fetch_assoc($resultCompany);
    $companyName = $row["Company_name"];
    $companyLogo = $row["Company_logo"]; 
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Launchpad</title>
		<link rel="icon" href="/launchpad/images/favicon.svg" />
    <link rel="stylesheet" href="css/navbar.css">
    <style>
        form {
            display: flex;
            flex-direction: column;
            width: 300px;
        }

        label {
            margin-bottom: 8px;
        }

        .avatar{
            width: 100px; /* Adjust the size of the avatar container */
            height: 100px;
            border-radius: 50%; /* Make it circular by setting border-radius to 50% */
            overflow: hidden; /* Hide overflow for perfect circle */
            background-color: #3498db; /* Set background color */
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ffffff; /* Set text color */
            font-size: 24px; /* Set text size */
        }
    </style>


</head>
<body>

<aside class="sidebar">
            <header class="sidebar-header">
                <img src="\launchpad\images\logo-text.svg" class="logo-img">
            </header>

            <nav>
                <a href="index.php" >
                <button>
                    <span>
                        <i ><img src="\launchpad\images\home-icon.png" alt="home-logo" class="logo-ic"></i>
                        <span>Home</span>
                    </span>
                </button>
            </a>
            <a href="project-idea-checker.php">
                <button>
                    <span>
                        <i ><img src="\launchpad\images\project-checker-icon.png" alt="home-logo" class="logo-ic"></i>
                        <span>Project Idea Checker</span>
                    </span>
                </button>
    </a>
    <a href="invitations.php">
                <button>
                    <span>
                        <i ><img src="\launchpad\images\invitation-icon.png" alt="home-logo" class="logo-ic"></i>
                        <span>Invitations</span>
                    </span>
                </button>
    </a>
                <p class="divider-company">YOUR COMPANY</p>
                        
                

                <a href="<?php echo $hasCompany ? 'company.php' : 'create-company.php'; ?>">
        <button>
            <span class="<?php echo $hasCompany ? 'btn-company-created' : 'btn-create-company'; ?>">
                <div class="circle-avatar">
                    <?php if ($hasCompany && !empty($companyLogo)): ?>
                        <img src="\launchpad\<?php echo $companyLogo; ?>" alt="Company Logo" class="img-company">
                    <?php else: ?>
                        <img src="\launchpad\images\join-company-icon.png" alt="Join Company Icon">
                    <?php endif; ?>
                </div>
                <span class="create-company-text">
                    <?php echo $hasCompany ? $companyName : 'Create your company'; ?>
                </span>
            </span>
        </button>
    </a>





                <p class="divider-company">COMPANIES YOU'VE JOINED</p>
                <a href="#">
                <button>
                    <span  class="btn-join-company">
                        <i > <div class="circle-avatar">
                            <img src="\launchpad\images\join-company-icon.png" alt="">
                        </div></i>
                        <span class="join-company-text">Join companies</span>
                    </span>
                </button>
                </a>
<a href="#" class="active">
                <button>
                    <span>
                        <img src="logo.png" alt="">
                        <span>Profile</span>
                    </span>
                </button>
</a>
               
            </nav>


        </aside>







    <?php 
        $email = $_SESSION['email'];

        $select_user_info = "SELECT * FROM student_registration WHERE Student_email='$email'";
        $result_user_info = mysqli_query($conn, $select_user_info);
        if ($result_user_info) {
            if (mysqli_num_rows($result_user_info) > 0) {
                $row = mysqli_fetch_assoc($result_user_info);
                $stud_id = $row['Student_ID'];
                $fname = $row['Student_fname'];
                $lname = $row['Student_lname'];
                $course = $row['Course'];
                $year = $row['Year'];
                $block = $row['Block'];
                $contactNo = $row['Student_contactno'];
            }
        }
    ?>  
    <div class="content">
        <header>
            <h1>My Profile</h1>
            <a href="edit_profile.php">Edit Profile</a>
        </header>

        <div class="form-container">

            <div class="avatar" id="initialsAvatar"></div>

            <form action="" method="post">
                <label for="studentid">Student ID:</label>
                <input type="text" id="studentid" name="studentid" value="<?php echo $stud_id?>" required readonly>

                <label for="student_fname">First Name:</label>
                <input type="text" id="student_fname" name="student_fname" value="<?php echo $fname?>" required readonly>

                <label for="student_lname">Last Name:</label>
                <input type="text" id="student_lname" name="student_lname" value="<?php echo $lname?>" required readonly>

                <label for="course">Course:</label>
                <input type="text" id="course" name="course" value="<?php echo $course?>" required readonly> 

                <label for="year">Year:</label>
                <input type="text" id="year" name="year" value="<?php echo $year?>" required readonly>

                <label for="block">Block:</label>
                <input type="text" id="block" name="block" value="<?php echo $block?>" required readonly>

                <label for="student_contactno">Contact Number:</label>
                <input type="tel" id="student_contactno" name="student_contactno" value="<?php echo $contactNo?>" required readonly> 

            </form>
        </div>
        <a href="logout.php">
                    <button>
                        <span>
                            <i ><img src="\launchpad\images\logout-icon.png" alt="logout-icon" class="logo-ic"></i>
                            <span style="color: red">LOG OUT</span>
                        </span>
                    </button>
                </a>
    </div>
        
    <script>
        // JavaScript to set the initials
        document.addEventListener("DOMContentLoaded", function() {
            const firstName = "<?php echo $fname?>"; // Replace with actual first name
            const lastName = "<?php echo $lname?>"; // Replace with actual last name

            const initials = getInitials(firstName, lastName);
            document.getElementById("initialsAvatar").innerText = initials;
        });

        // Function to get initials from first and last names
        function getInitials(firstName, lastName) {
            return (
                (firstName ? firstName[0].toUpperCase() : "") +
                (lastName ? lastName[0].toUpperCase() : "")
            );
        }
    </script>
</body>
</html>