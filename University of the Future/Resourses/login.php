<?php
$servername = "localhost";
$database = "ulabbloodbank";
$username = "root";
$password = "";
 
$var = mysqli_connect($servername, $username, $password, $database);
 
if (!$var) {
 
    die("Connection failed: " . mysqli_connect_error());
 
}

echo "Connected successfully";
echo '    Successfully logged in! Redirecting to hompage..'; 
echo '  <a href="home.html">OK</a>';
?>
