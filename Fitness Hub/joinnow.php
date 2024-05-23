<?php
include("db.php");
session_start();
if (!isset($_SESSION["email"])) {
    header("location:./login/login.php");
}
$id = $_GET["id"];
$email=$_SESSION["email"];
$select = "SELECT * FROM coursedetails1 WHERE id=$id";
$result = mysqli_query($conn, $select);
$select1 = "SELECT * FROM ourmembers WHERE course_id='$id' AND email='$email'";
$result1 = mysqli_query($conn, $select1);
if(mysqli_num_rows($result1)>0){
    $row1 = mysqli_fetch_assoc($result1);
    if($row1["email"] == $_SESSION["email"]){
        $_SESSION["already_join_popup"]=true;
        header("location:exercises.php?id=$id");
    }
}
$row = mysqli_fetch_assoc($result);
$coursename = $row["coursename"];
$coursetime = $row["coursetime"];
$coursetype = $row["coursetype"];
$name=$_SESSION["username"];
$email=$_SESSION["email"];

if(isset($_POST["joinnow"])){
    $insert="INSERT INTO ourmembers(username,email,course_id,course_name,course_type,course_time) VALUES('$name','$email','$id','$coursename','$coursetype','$coursetime')";
    mysqli_query($conn,$insert);
    $_SESSION["join_popup"]=true;
    header("location:exercises.php?id=$id");
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="joinnow.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a319ab9648.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>

    <div class="nine">
        <h1>Join Now<span>Fitness Hub.</span></h1>
    </div>
    <a href="index.php"><button style="background-color: #091c21;color: hsl(0, 0%, 100%);" type="button" class="btn btn-info home"><i class="fa-regular fa-circle-xmark fa-lg"></i></button></a>
    <div>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" class="row g-3" style="margin-left: 180px;margin-right: 180px; margin-top: 50px;">
        <div class="col-md-6">
                <label for="inputZip" class="form-label">Username</label>
                <input class="form-control" type="text" value="<?php echo $name; ?>" aria-label="Disabled input example" disabled readonly>
            </div>
            <div class="col-md-6">
                <label for="inputZip" class="form-label">Email</label>
                <input class="form-control" type="text" value="<?php echo $email; ?>" aria-label="Disabled input example" disabled readonly>
            </div>
            <div class="col-md-6">
                <label for="inputZip" class="form-label">Your Course</label>
                <input class="form-control" type="text" value="<?php echo $coursename; ?>" aria-label="Disabled input example" disabled readonly>
            </div>
            <div class="col-md-6">
                <label for="inputZip" class="form-label">Gender</label>
                <input class="form-control" type="text" value="<?php echo $coursetype; ?>" aria-label="Disabled input example" disabled readonly>
            </div>
            <div class="col-md-6">
                <label for="inputZip" class="form-label">Compeletaion Time</label>
                <input class="form-control" type="text" value="<?php echo $coursetime; ?>" aria-label="Disabled input example" disabled readonly>
            </div>
            <div class="col-12">

                <button type="submit" name="joinnow" value="joinnow" class="btn btn-primary">Join Now</button>
            </div>
        </form>
    </div>
</body>

</html>