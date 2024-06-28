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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>  

  <center><h1>Signup Form</h1></center>
  <center><p><small>It's quick, simple & easy!</small></p></center>
  <br><br><br><br><br><br>
  <div class = "signup">
    <form action="signup2.php"  method="post" enctype="multipart/form-data">
      <?php 
      if(isset($error)) {
        foreach($error as $error) {
            echo '<span class="error-msg">' . $error . '</span>';
        };
      };
      ?>
      <lebel> Full Name: </lebel>
      <input type="text" placeholder="Enter your first name" name="firstName" required>
      <lebel> Email: </lebel>
      <input type="text" placeholder="Enter your email address" name="email" required>
      <lebel> Contact No: </lebel>
      <input type="text" placeholder="Enter your contact number" name="contactNo" required>
      <lebel> New Password: </lebel>
      <input type="text" placeholder="Enter your password" name="password" required>
      <lebel> Confirm Password: </lebel>
      <input type="text" placeholder="Enter your password again" name="rePassword" required>
      <br>
      <lebel> Gender: </lebel>
      <input type = "radio" name = "gender" value="male">Male
      <input type = "radio" name = "gender" value="female">Female
      <br>
      <lebel> Last Completed Degree: </lebel>
      <input type="text" placeholder="Last Completed Degree name" name="lastCompletedDegree" required>

      <button type="submit">Sign Up</button>
      <center><p> Already registerd? <a href="login.php"> Go to Login page! </a></p></center>
      <br>
    </form>
  </div>
</body>
</html>
