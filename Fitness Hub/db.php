<?php
$db_server="localhost";
$db_name= "fitness";
$db_password="";
$db_user="root";
$conn="";


try{
    $conn=mysqli_connect($db_server,
    $db_user,
    $db_password,
    $db_name);
}catch(mysqli_sql_exception){
    echo "DC";
}
if($conn){
    // echo "C";
}
?>