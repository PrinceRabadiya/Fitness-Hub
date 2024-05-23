<?php
include("../db.php");
session_start();
if(isset($_SESSION["email"])){
    header("location:../index.php");
}
    if(isset($_POST["SignUp"])){
        $Name=$_POST["Name"];
        $Email=$_POST["Email"];
        $password=$_POST["password"];
        if(empty($Name) || empty($Email) || empty($password)){
            $error= "Enter All Details";
        }
        $select= "SELECT * FROM userdetails WHERE email='$Email'";
        $result= mysqli_query($conn,$select);
        if(mysqli_num_rows($result)>0){
            $error= "Email Already Exists";
        }else{
            $hase=password_hash($password,PASSWORD_DEFAULT);
            $insert="INSERT INTO userdetails(username,email,password) VALUES('$Name','$Email','$hase')";
            mysqli_query($conn,$insert);
            $_SESSION["username"]=$Name;
            $_SESSION["email"]=$Email;
            $select= "SELECT * FROM userdetails WHERE email='$Email'";
            $result = mysqli_query($conn, $select);
            $row= mysqli_fetch_array($result);
            // $_SESSION["id"]=$row["id"];
            header('location:logout.php');
        }
    }

    if(isset($_POST["SignIn"])){
        $useremail=$_POST["useremail"];
        $userpassword=$_POST["userpassword"];
        $select= "SELECT * FROM userdetails WHERE email='$useremail'";
        $result = mysqli_query($conn, $select);
        if(mysqli_num_rows($result) > 0){
            $row= mysqli_fetch_array($result);
            if(password_verify($userpassword,$row["password"])){
                if($row["type"]=="user"){
                    $_SESSION["username"]=$row["username"];
                    $_SESSION["email"]=$row["email"];
                    $_SESSION["id"]=$row["id"];
                    $_SESSION["popup"]=true;
                    header("location:../index.php");
                }
                if($row["type"]=="admin"){
                    $_SESSION["adminname"]=$row["username"];
                    $_SESSION["adminemail"]=$row["email"];
                    $_SESSION["id"]="hi";
                    header("location:../admin.php");
                }
            }else{
                $error="Wrong Password!";
            }
        }else{
            $error="No User Found!";
        }
    }
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign in & Sign up Form</title>
    <link rel="stylesheet" href="style.css" />
    <script src="https://kit.fontawesome.com/a319ab9648.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <main>
        <div class="box">
        <a style="margin-left: 20px;" href="../index.php" class="exit"><i  class="fa-solid fa-circle-xmark fa-2xl" style="color: #ff8c6b;margin-top: 30px;"></i></a>
            <div class="inner-box">
                <div class="forms-wrap">
<!-- ************************************************************************************************ -->
                    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" autocomplete="off" class="sign-in-form">
                        <div class="logo">
                            <h4>Fitness Hub.</h4>
                        </div>

                        <div class="heading">
                            <h2>Welcome Back</h2>
                            <h6>Not registred yet?</h6>
                            <a href="#" class="toggle">Sign up</a>
                        </div>
                        <p style="color: red;"><?php
                        if(isset($error)){
                            echo $error;
                        }
                        ?></p>
                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" name="useremail" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Email</label>
                            </div>

                            <div class="input-wrap">
                                <input type="password" name="userpassword" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Password</label>
                            </div>

                            <input type="submit" name="SignIn" value="SignIn" class="sign-btn" />

                            <p class="text">
                                Forgotten your password or you login datails?
                                <a href="#">Get help</a> signing in
                            </p>
                        </div>
                    </form>
<!-- ************************************************************************************************ -->
                    <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" autocomplete="off" class="sign-up-form">
                        <div class="logo">
                            <h4>Fitness Hub.</h4>
                        </div>

                        <div class="heading">
                            <h2>Get Started</h2>
                            <h6>Already have an account?</h6>
                            <a href="#" class="toggle">Sign in</a>
                        </div>
                        <p style="color: red;"><?php
                        if(isset($error)){
                            echo $error;
                        }
                        ?></p>
                        <div class="actual-form">
                            <div class="input-wrap">
                                <input type="text" name="Name" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Name</label>
                            </div>

                            <div class="input-wrap">
                                <input type="email" name="Email" class="input-field" autocomplete="off" required />
                                <label>Email</label>
                            </div>

                            <div class="input-wrap">
                                <input type="password" name="password" minlength="4" class="input-field" autocomplete="off" required />
                                <label>Password</label>
                            </div>

                            <input type="submit" name="SignUp" value="SignUp" class="sign-btn" />

                            <p class="text">
                                By signing up, I agree to the
                                <a href="#">Terms of Services</a> and
                                <a href="#">Privacy Policy</a>
                            </p>
                        </div>
                    </form>
<!-- ************************************************************************************************ -->
                </div>

                <div class="carousel">
                    <div class="images-wrapper">
                        <img src="./img/image1.png" class="image img-1 show" alt="" />
                        <img src="./img/image2.png" class="image img-2" alt="" />
                        <img src="./img/image3.png" class="image img-3" alt="" />
                    </div>

                    <div class="text-slider">
                        <div class="text-wrap">
                            <div class="text-group">
                                <h2>Join Now</h2>
                                <h2>Fitness IS EveryThing</h2>
                                <h2>Invite Your Friends</h2>
                            </div>
                        </div>

                        <div class="bullets">
                            <span class="active" data-value="1"></span>
                            <span data-value="2"></span>
                            <span data-value="3"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Javascript file -->

    <script src="app.js"></script>
</body>

</html>