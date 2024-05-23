<?php
include("db.php");
session_start();
if (!isset($_SESSION["email"])) {
    header("location:./login/login.php");
}
$select = "SELECT * FROM coursedetails1 WHERE coursetype='female'";
$result = mysqli_query($conn, $select);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>men course</title>
    <link rel="stylesheet" href="./men.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/a319ab9648.js" crossorigin="anonymous"></script>


</head>

<body>
    <!-- partial:index.partial.html -->

    <div  class="container">

        <div class="img">
            <img src="./assets/images/women.jpg" id="girlimg"></img>
        </div>
        <div id="cont">
        <a href="index.php"><i style="margin-left: 45px;margin-top: 35px;" class="fa-solid fa-arrow-left fa-xl"></i></a>
            <div class="titlecont">
                <div class="title1">
                    Welcome
                </div>
                <div class="title2">
                    How can we help you?
                </div>
            </div>
            <div class="group">
            <?php
            while ($row = mysqli_fetch_assoc($result)){
                ?>
<article class="card">
                <img class="card__background" src="<?php echo $row["bgimage"]; ?>" alt="Photo of Cartagena's cathedral at the background and some colonial style houses" width="1920" height="2193" />
                <div class="card__content | flow">
                    <div class="card__content--container | flow">
                        <h2 class="card__title"><?php echo $row["coursename"]; ?></h2>
                        <p class="card__description">
                        <?php echo $row["coursedetail"]; ?>
                        </p>
                        <p class="card__description">
                            Time: <?php echo $row["coursetime"]; ?> Days
                        </p>
                        <p class="card__description">
                            Gender: <?php echo $row["coursetype"]; ?>
                        </p>
                        <a href="joinnow.php<?php echo "?id=$row[id]"; ?>" id="link">
                            <div id="arrow"><i class="fa-solid fa-arrow-right fa-xs"></i></div>
                        </a>
                    </div>
                </div>
            </article>
                <?php
            }
            ?>
            
            </div>
        </div>
        <!-- partial -->
    </div>
    <script src="../dist/women.js"></script>
</body>

</html>