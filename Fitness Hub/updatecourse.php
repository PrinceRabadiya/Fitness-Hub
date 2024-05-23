<?php
include("db.php");
session_start();
if (empty($_SESSION["adminemail"])) {
    header("location:index.php");
}
$id=$_GET["id"];
$select="SELECT * FROM coursedetails1 WHERE id='$id'";
$result=mysqli_query($conn,$select);
while($row=mysqli_fetch_assoc($result)){
    $name=$row["coursename"];
    $details=$row["coursedetail"];
    $type=$row["coursetype"];
    $time=$row["coursetime"];
    $bgimg=$row["bgimage"];
}
if (isset($_POST["Submit"])) {
    $coursename = $_POST["name"];
    $coursedetails = $_POST["details"];
    $coursetime = $_POST["time"];
    $gender = $_POST["gender"];
    $filename = $_FILES["bgimage"]["name"];
    $tempname = $_FILES["bgimage"]["tmp_name"];
    $folder="pics/".$filename;
    if (empty($coursename) || empty($coursetime) || empty($coursedetails) || empty($gender)) {
        $error = "Enter All Details";
    } else {
        move_uploaded_file($tempname,$folder);
        if(empty($filename)){
            $sql = "UPDATE coursedetails1 SET coursename='$coursename',coursedetail='$coursedetails',coursetype='$gender',coursetime='$coursetime' WHERE id=$id";
            $sqlexe="UPDATE exercises SET _coursename='$coursename',_coursetype='$gender' WHERE _courseid='$id'";
            $sqlmembers="UPDATE ourmembers SET course_name='$coursename',course_type='$gender',course_time='$coursetime' WHERE course_id='$id'";
            $sqlscore="UPDATE score SET coursename_='$coursename',coursetype_='$gender',coursetime_='$coursetime' WHERE courseid_='$id'";
        }else{
            $sql = "UPDATE coursedetails1 SET coursename='$coursename',coursedetail='$coursedetails',coursetype='$gender',coursetime='$coursetime',bgimage='$folder' WHERE id=$id";
            $sqlexe="UPDATE exercises SET _coursename='$coursename',_coursetype='$gender' WHERE _courseid='$id'";
            $sqlmembers="UPDATE ourmembers SET course_name='$coursename',course_type='$gender',course_time='$coursetime' WHERE course_id='$id'";
            $sqlscore="UPDATE score SET coursename_='$coursename',coursetype_='$gender',coursetime_='$coursetime' WHERE courseid_='$id'";
        }
        
        mysqli_query($conn, $sql);
        mysqli_query($conn, $sqlexe);
        mysqli_query($conn, $sqlmembers);
        mysqli_query($conn, $sqlscore);
        header("location:allcourse.php");
    }
}
?>



<!DOCTYPE html>
<!-- Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="admin.css">

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Admin Dashboard Panel</title>
</head>

<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <img src="images/logo.png" alt="">
            </div>

            <span class="logo_name">Fitness Hub.</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Dahsboard</span>
                    </a></li>
                <li><a href="addcourse.php">
                        <i class="uil uil-files-landscapes"></i>
                        <span class="link-name">Add Course</span>
                    </a></li>
                <li><a href="allcourse.php">
                        <i class="uil uil-thumbs-up"></i>
                        <span class="link-name">All Courses</span>
                    </a></li>
                <li><a href="ourmembers.php">
                        <i class="uil uil-comments"></i>
                        <span class="link-name">Our Members</span>
                    </a></li>
                    <li><a href="allexercises.php">
                        <i class="uil uil-share"></i>
                        <span class="link-name">All Exercises</span>
                    </a></li>
            </ul>

            <ul class="logout-mode">
                <li><a href="./login/logout.php">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Logout</span>
                    </a></li>

                <!-- <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                        <span class="link-name">Dark Mode</span>
                    </a>

                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li> -->
            </ul>
        </div>
    </nav>

    <section class="dashboard">

        <!--<img src="images/profile.jpg" alt="">-->
        </div>

        <div style="margin-top: -100px;" class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Add Course</span>
                </div>
            </div>
            <p style="color: red;"><?php
                                    if (isset($error)) {
                                        echo $error;
                                    }
                                    ?></p>
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Course Name</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" autocomplete="off" value="<?php
                        echo $name;
                    ?>" require>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Course Details</label>
                    <input type="text" name="details" class="form-control" id="exampleInputEmail1" autocomplete="off" value="<?php
                        echo $details;
                    ?>" require>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Course Compelete Time</label>
                    <input type="text" name="time" class="form-control" id="exampleInputEmail1" autocomplete="off" value="<?php
                        echo $time;
                    ?>" require>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">BG Image</label>
                    <input class="form-control" type="file"  name="bgimage" id="formFile" value="<?php
                        echo $bgimg;
                    ?>">
                </div>
                <br>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" value="male" id="flexRadioDefault1" <?php 
                        if($type=="male"){
                            echo "checked";
                        }
                    ?>>
                    <label class="form-check-label" for="flexRadioDefault1">
                        Male
                    </label>
                </div>
                <br>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" value="female" id="flexRadioDefault1" <?php 
                        if($type=="female"){
                            echo "checked";
                        }
                    ?>>
                    <label class="form-check-label" for="flexRadioDefault1">
                        Female
                    </label>
                </div>
                <br>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" value="both" id="flexRadioDefault2" <?php 
                        if($type=="both "){
                            echo "checked";
                        }
                    ?>>
                    <label class="form-check-label" for="flexRadioDefault2">
                        Both
                    </label>
                </div>
                <br>
                <input type="submit" name="Submit" value="Submit" class="btn btn-primary">
            </form>
        </div>
    </section>

    <script>
        const body = document.querySelector("body"),
            modeToggle = body.querySelector(".mode-toggle");
        sidebar = body.querySelector("nav");
        sidebarToggle = body.querySelector(".sidebar-toggle");

        let getMode = localStorage.getItem("mode");
        if (getMode && getMode === "dark") {
            body.classList.toggle("dark");
        }

        let getStatus = localStorage.getItem("status");
        if (getStatus && getStatus === "close") {
            sidebar.classList.toggle("close");
        }

        modeToggle.addEventListener("click", () => {
            body.classList.toggle("dark");
            if (body.classList.contains("dark")) {
                localStorage.setItem("mode", "dark");
            } else {
                localStorage.setItem("mode", "light");
            }
        });

        sidebarToggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
            if (sidebar.classList.contains("close")) {
                localStorage.setItem("status", "close");
            } else {
                localStorage.setItem("status", "open");
            }
        })
    </script>
</body>

</html>