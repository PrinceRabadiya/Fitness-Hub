<?php
include("db.php");
session_start();
if (!isset($_SESSION["email"])) {
    header("location:./login/login.php");
}
$id = $_GET["id"];
$select = "SELECT * FROM exercises WHERE _courseid='$id'";
$result = mysqli_query($conn, $select);
$select1 = "SELECT * FROM coursedetails1 WHERE id='$id'";
$result1 = mysqli_query($conn, $select1);
$row1 = mysqli_fetch_assoc($result1);
$coursename = $row1["coursename"];
$coursedetail = $row1["coursedetail"];
$sql = "SELECT SUM(exercises_time) FROM exercises WHERE _courseid='$id'";
$time = mysqli_query($conn, $sql);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./fullbodyfat.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="exercises.css">
    <script src="https://kit.fontawesome.com/a319ab9648.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="containers">
        <?php
        if (isset($_SESSION["join_popup"])) {
            unset($_SESSION["join_popup"]);
        ?>
            <script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'You join <?php echo $coursename; ?>',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
        <?php
        }
        ?>
        <?php
        if (isset($_SESSION["already_join_popup"])) {
            unset($_SESSION["already_join_popup"]);
        ?>
            <script>
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Welcome Back, <?php echo $coursename; ?>',
                    showConfirmButton: false,
                    timer: 1500
                })
            </script>
        <?php
        }
        ?>
        <div class="img1">
            <a href="index.php" class="exit"><i class="fa-solid fa-circle-xmark fa-2xl" style="color: hsl(46, 100%, 50%);"></i></a>
            <p id="title"><?php echo $coursename; ?></p>
            <p id="desc" style="font-weight: 400;">
                <?php echo $coursedetail; ?>
            </p>
            <div id="execont">
                <div id="totalworkout">
                    <span id="num"><?php echo mysqli_num_rows($result); ?></span> <span id="txt">Workout</span>
                </div>
                <div id="totaltime">
                    <?php
                    while ($t = mysqli_fetch_array($time)) {
                    ?>
                        <span id="num"><?php
                                        if (isset($t["SUM(exercises_time)"])) {
                                            echo $t["SUM(exercises_time)"];
                                        } else {
                                            echo 0;
                                        }
                                        ?></span>
                    <?php
                    }
                    ?> <span id="txt">Sec</span>
                </div>
            </div>
            <?php
            if (mysqli_num_rows($result) == 0) {
            } else {
                echo "<a href='pracexe.php?id=$id'>
                <button type='button' class='btn btn-primary' id='start'>Start</button>
            </a>";
            }
            ?>
        </div>
        <div>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo " <section>
                <div class='container py-3'>
                    <div class='card'>
                        <div class='row'>
                            <div class='col-md-4'>
                                <img src='$row[exercises_video]' class='w-100' >
                            </div>
                            <div class='col-md-8 px-3'>
                                <div class='card-block px-3'>
                                    <h4 class='card-title'>$row[exercises_name]</h4>
                                    <p class='card-text'>$row[exercises_time]s </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>";
            }
            ?>
        </div>
    </div>
</body>

</html>