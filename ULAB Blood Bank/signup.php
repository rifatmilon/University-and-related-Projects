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

$firstName = $_POST["firstName"]; 
$surname = $_POST["surname"];
$email = $_POST["email"];
$contactNo = $_POST["contactNo"];
$bloodgroup = $_POST['bloodgroup'];
$password = $_POST["password"];
$rePassword = $_POST["rePassword"];
$gender = $_POST ["gender"];

$select = "SELECT * FROM userdetails WHERE email='$email'";

$result = mysqli_query($var, $select);

if (mysqli_num_rows($result)) {
    $error[] = 'user already exists';
}
else {
    if($password != $rePassword) {
        $error[] = 'password not marched!';
    }
    else {
        $sql= "INSERT INTO userdetails  VALUES ('', '$firstName','$surname','$email', '$contactNo', '$bloodgroup', '$password', '$gender')";

        if(!mysqli_query($var,$sql)) {
            echo '<h1>Error 9999; Check your information & try again later.</h1>';
            echo '<a href="home.html"> <input type="Back to homepage"/></a>';
        }
        else {
            echo '<h1>Successfully Registerd. Go to login?</h1>';
            echo '<a href="home.html">No, go back to homepage!</a>';
            echo '<br>';
            echo '<a href="loginfile.php">Lets login first!</a>';
        }
        mysqli_close($var);
    }
}

if(isset($error)) {
    foreach($error as $error) {
        echo '<span class="error-msg">' . $error . '</span>';
    }
}


?>