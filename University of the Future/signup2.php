<?php 
  @include 'connectDatabase.php';

  if (isset($_POST['submit'])) {

    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
    $password = md5($_POST['password']);
    $rePassword = md5($_POST['rePassword']);
    $gender = $_POST['gender'];
    $lastCompletedDegree = mysqli_real_escape_string($conn, $_POST['lastCompletedDegree']);

    $select = "SELECT * FROM userdetails WHERE email='$email'";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'user already exists';
    }
    else {
        if($password != $rePassword) {
            $error[] = 'password not marched!';
        }
        else {
            $sql= "INSERT INTO signup  VALUES ('', '$fullname','$email', '$contactNo', '$password', '$rePassword', '$gender', '$lastCompletedDegree')";
            mysqli_query($conn, $sql);
            header('location:login.php');
            
            if(!mysqli_query($conn,$sql)) {
                echo '<h1>Error 9999; Check your information & try again later.</h1>';
                echo '<a href="index.html"> <input type="Back to homepage"/></a>';
            }
            else {
                echo '<h1>Successfully Registerd. Go to login?</h1>';
                echo '<a href="index.html">No, go back to homepage!</a>';
                echo '<br>';
                echo '<a href="login.php">Lets login first!</a>';
            }
            mysqli_close($var);
        }
    }
}

?>