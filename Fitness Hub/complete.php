<?php
    include("db.php");
    session_start();
    if (!isset($_SESSION["email"])) {
        header("location:./login/login.php");
    }
    $id=$_GET["id"];
    $select="SELECT * FROM exercises WHERE _courseid='$id'";
    $result=mysqli_query($conn,$select);
    $row=mysqli_fetch_assoc($result);
    $coursename=$row["_coursename"];
    $courseid=$row["_courseid"];
    $coursetype=$row["_coursetype"];
    $select1="SELECT * FROM coursedetails1 WHERE id='$courseid'";
    $result1=mysqli_query($conn,$select1);
    $row1=mysqli_fetch_assoc($result1);
    $coursetime=$row1["coursetime"];
    $username=$_SESSION["username"];
    $email=$_SESSION["email"];
    $select2="SELECT * FROM score WHERE courseid_='$courseid' AND email_= '$email'";
    $result2=mysqli_query($conn,$select2);
    $row2=mysqli_fetch_assoc($result2);
    if(empty($row2["days_"])){
        $days=1;
        $insert="INSERT INTO score(days_,courseid_,coursename_,coursetype_,coursetime_,username_,email_) VALUES('$days','$courseid','$coursename','$coursetype','$coursetime','$username','$email')";
        mysqli_query($conn,$insert);
    }else{
    $days_cal=$row2["days_"];
    $totaltime=$row2["coursetime_"];
        if($days_cal == $totaltime){
            $msg="You Complete Your Course";
        }else{
            $days=$row2["days_"]+1;
            $update="UPDATE score SET days_='$days' WHERE courseid_='$courseid' AND email_= '$email'";
            mysqli_query($conn,$update);
        }
    }

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a319ab9648.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="complete.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>

    <div class="header">
        
        <p class="heading">Congratulations 🎉</p>
        <p class="text"><?php
        if(isset($days_cal)){
            $display_days=$days_cal+1;
        }
        if(isset($msg)){
                echo $msg;
        }else{
            if(isset($display_days)){
                echo "You have Complete your Day  $display_days of $coursename";
            }else{
                echo "You have Complete your Day 1 of $coursename";
            }
        }
        ?>
            </p>
        <a href="index.php"><button type="button" class="btn btn-dark">Submit</button></a>
    </div>


<script src="complete.js"></script>
</body>
</html>