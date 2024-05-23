<?php
    include("db.php");
    $id=$_GET["id"];
    $sql="DELETE FROM exercises WHERE id='$id'";
    $result=mysqli_query($conn,$sql);
    if($result){
        header("location:allexercises.php");
    }else{
        echo "Not Deleted";
    }
?>