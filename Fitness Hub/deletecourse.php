<?php
    include("db.php");
    $name=$_GET["name"];
    $sql="DELETE FROM coursedetails1 WHERE coursename='$name'";
    $result=mysqli_query($conn,$sql);
    if($result){
        header("location:allcourse.php");
    }else{
        echo "Not Deleted";
    }
?>