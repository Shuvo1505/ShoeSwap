<?php
//Database credential, You can modify according to your project
$host="localhost";
$username="root";
$password="";
$dbname = "shoeswap";

//creating Connection
$conn=mysqli_connect($host,$username,$password,$dbname);

$database="ShowSwap";

if(!$conn){
    die("<br>Connection Failed!");
}
?>
