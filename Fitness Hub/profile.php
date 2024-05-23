<?php
include("db.php");
session_start();
if (!isset($_SESSION["email"])) {
    header("location:./login/login.php");
}
$id= $_SESSION["id"];
$email = $_SESSION["email"];
$select = "SELECT * FROM ourmembers WHERE email='$email'";
$result = mysqli_query($conn, $select);
$sql1="SELECT * FROM userdetails WHERE id='$id'";
$result2=mysqli_query($conn,$sql1) ;
$row2=mysqli_fetch_assoc($result2);
$username=$row2["username"];
$email_=$row2["email"];
$password=$row2["password"];


if(!empty($_POST["Update"])){
    $Name=$_POST["username"];
    $Email=$_POST["email"];

    $_SESSION["email"]=$Email;
    $_SESSION["username"]=$username;
    $sql="UPDATE userdetails SET username='$Name', email='$Email'  WHERE id='$id'";
    $sqlscore="UPDATE score SET username_='$Name', email_='$Email'  WHERE email_='$email_'";
    $sqlmembers="UPDATE ourmembers SET username='$Name', email='$Email'  WHERE email='$email_'";
    mysqli_query($conn, $sql);
    mysqli_query($conn, $sqlscore);
    mysqli_query($conn, $sqlmembers);
    header("location:profile.php");
}


if(isset($_POST["Change"])){
    $oldp=$_POST["oldp"];
    $newp=$_POST["newp"];
    $confirmp=$_POST["confirmp"];
    if(password_verify($oldp,$password)){
        if($newp == $confirmp){
            $hase=password_hash($newp,PASSWORD_DEFAULT);
            $sql="UPDATE userdetails SET password='$hase'  WHERE id='$id'";
            mysqli_query($conn, $sql);
            header("location:profile.php");
        }else{
            $err="Password Not Match!";
        }
    }else{
        $err="Wrong Password!";
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>profile</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="profile.css">
    <script src="https://kit.fontawesome.com/a319ab9648.js" crossorigin="anonymous"></script>
</head>

<body>
    <section class="py-5 my-5">
        
        <div class="container">
            <h1 class="mb-5">Account Settings</h1>
            <div class="bg-white shadow rounded-lg d-block d-sm-flex">
                <div class="profile-tab-nav border-right">
                <a style="margin-left: 20px;" href="index.php" class="exit"><i  class="fa-solid fa-circle-xmark fa-2xl" style="color: #333;margin-top: 30px;"></i></a>
                    <div class="p-4">
                        <h4 class="text-center"><?php echo $username; ?></h4>
                    </div>
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="true">
                            <i class="fa fa-home text-center mr-1"></i>
                            Account
                        </a>
                        <a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
                            <i class="fa fa-key text-center mr-1"></i>
                            password
                        </a>
                        <a class="nav-link" id="security-tab" data-toggle="pill" href="#security" role="tab" aria-controls="security" aria-selected="false">
                            <i class="fa fa-user text-center mr-1"></i>
                            your score
                        </a>
                    </div>
                </div>
                <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                        <h3 class="mb-4">Account Settings</h3>
                    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>User Name</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div>
                        <input type="submit" name="Update" value="Update" class="btn btn-primary">
                        </div>
                    </form>
                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                        <h3 class="mb-4">Password Settings</h3>
                        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Old password</label>
                                    <input type="password" name="oldp" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>New password</label>
                                    <input type="password" name="newp" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Confirm new password</label>
                                    <input type="password" name="confirmp" class="form-control">
                                </div>
                            </div>
                        </div>
                        <p style='color: red;margin-top:10px;'><?php 
                        if(isset($err)){
                            echo $err;
                        }
                        ?></p>
                        <div>
                            <input type="submit" name="Change" value="Change" class="btn btn-primary">
                            <button class="btn btn-light">Cancel</button>
                        </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                        <h3 class="mb-4">Your Score</h3>
                        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row g-3">
                                        <div class="col">
                                            <input type="text" class="form-control" placeholder="Course name" name="course"  autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <div> 
                                        <br>
                                        <input type="submit" value="Submit" name="Submit" class="btn btn-primary">
                                        <button  class="btn btn-light">Cancel</button>
                                        <br>
                                    </div>
                                    <br>
                                    <div class="row row-cols-1 row-cols-md-3 g-4">
                                    <!-- <div class='row row-cols-1 row-cols-md-1 g-6'> -->
                                    <?php
                                    if(isset($_POST["Submit"])){
                                        $course=$_POST["course"];
                                        $select1 = "SELECT * FROM score WHERE coursename_='$course' AND email_= '$email_'";
                                        $result1 = mysqli_query($conn, $select1);
                                        if(!mysqli_num_rows($result1)>0){
                                            echo "<p style='color: red;margin-top:10px;'>Enter Your Course Name Perfectly</p>";
                                        }else{
                                            $row=mysqli_fetch_assoc($result1);
                                            $totaltime=$row["coursetime_"];
                                            $days=$row["days_"];
                                        for($i=1;$i<=$totaltime;$i++){
                                            ?>
                                            <br> 
                                            <div class="col">
                                            <div style="margin-top: 30px;" class="card">
                                            <div class='card text-center'>
                                            <h5 class='card-header'><?php echo "day-$i";  ?></h5>
                                            <div class='card-body'>
                                            <h5 class='card-title'><?php echo $row["coursename_"];  ?></h5>
                                            <?php
                                            if($i <= $days){
                                                echo "<i class='fa-regular fa-calendar-check fa-xl' id='icon' style='color: #29a32b;'></i>";
                                            }else{
                                                echo "<i class='fa-solid fa-circle-exclamation fa-xl' style='color: #cd1d1d;'></i>";
                                            }
                                            ?>
                                            </div>
                                            </div>  
                                        </div>
                                        </div>
                                        <?php
                                        }
                                    }
                                    }
                                    ?>
                                                                </form>
                                        <!-- </div> -->
                                </div>
            </div>
    </section>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>