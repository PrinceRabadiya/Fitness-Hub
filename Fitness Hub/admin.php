<?php
include("db.php");
session_start();
if (empty($_SESSION["adminemail"])) {
    header("location:index.php");
}
$select = "SELECT * FROM userdetails";
$result = mysqli_query($conn, $select);
// if(mysqli_num_rows($result)>0){
//     $row=mysqli_fetch_array($result);
// }
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
  

        <div style="margin-top: -100px;" class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
                </div>

                <div class="activity">
                    <div class="title">
                        <i class="uil uil-clock-three"></i>
                        <span class="text">Recent USers</span>
                    </div>
                </div>

            </div>
            <table  class="table">
                <thead>
                    <tr>
                        <th  scope="col">Id</th>
                        <th  scope="col">User_Name</th>
                        <th  scope="col">User_Email</th>
                        <th  scope="col">Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <th class="td1" scope="row"><?php
                                            echo $row["id"];
                                            ?></th>
                            <td class="td1"><?php
                                echo $row["username"];
                                ?></td>
                            <td class="td1"><?php
                                echo $row["email"];
                                ?></td>
                            <td class="td1">@<?php
                                    echo $row["type"];
                                    ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
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