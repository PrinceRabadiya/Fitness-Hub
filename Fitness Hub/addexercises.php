<?php
include("db.php");
session_start();
if (empty($_SESSION["adminemail"])) {
    header("location:index.php");
}
$id = $_GET["id"];
$select = "SELECT * FROM coursedetails1 WHERE id=$id";
$result = mysqli_query($conn, $select);
$row = mysqli_fetch_assoc($result);
$coursename = $row["coursename"];
$coursetype = $row["coursetype"];

if(isset($_POST["Submit"])){
    $exename=$_POST["exercisesname"];
    $exetime=$_POST["exercisestime"];
    $exename=$_POST["exercisesname"];
    $filename = $_FILES["exercisesgraphic"]["name"];
    $tempname = $_FILES["exercisesgraphic"]["tmp_name"];
    $folder="exercises/".$filename;
    if(empty($exename) || empty($exetime)){
        $error="Enter All Details!";
    }else{
        move_uploaded_file($tempname,$folder);
        $insert = "INSERT INTO exercises (_coursename,_courseid,_coursetype,exercises_name,exercises_time,exercises_video) VALUES('$coursename','$id','$coursetype','$exename','$exetime','$folder')"; 
        mysqli_query($conn,$insert);
        header("location:allexercises.php");
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
                    <span class="text">Add Exercise</span>
                </div>
            </div>
            <p style="color: red;"><?php
                                    if (isset($error)) {
                                        echo $error;
                                    }
                                    ?></p>
            <br>
            <form class="row g-3" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data">
                <div class="col-md-6">
                    <label for="inputZip" class="form-label">Course Name</label>
                    <input class="form-control" type="text" value="<?php echo $coursename; ?>" aria-label="Disabled input example" disabled readonly>
                </div>
                <div class="col-md-6">
                    <label for="inputZip" class="form-label">Gender</label>
                    <input class="form-control" type="text" value="<?php echo $coursetype; ?>" aria-label="Disabled input example" disabled readonly>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Exercise Name</label>
                    <input type="text" name="exercisesname" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Exercise Time</label>
                    <input type="text" name="exercisestime" class="form-control" id="exampleInputPassword1" autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Exercise Graphic</label>
                    <input name="exercisesgraphic" class="form-control" type="file" id="formFile" autocomplete="off">
                </div>
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