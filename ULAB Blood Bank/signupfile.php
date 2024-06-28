<?php 
  @include 'configfile.php';

  if (isset($_POST['submit'])) {

    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $surname = mysqli_real_escape_string($conn, $_POST['surname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
    $bloodgroup = mysqli_real_escape_string($conn, $_POST['bloodgroup']);
    $password = md5($_POST['password']);
    $rePassword = md5($_POST['rePassword']);
    $gender = $_POST['gender'];

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
            $sql= "INSERT INTO userdetails  VALUES ('', '$firstName','$surname','$email', '$contactNo', '$bloodgroup', '$password', '$gender')";
            mysqli_query($conn, $sql);
            header('location:loginfile.php');
            
            if(!mysqli_query($conn,$sql)) {
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
    <form action="signup.php"  method="post" enctype="multipart/form-data">
      <?php 
      if(isset($error)) {
        foreach($error as $error) {
            echo '<span class="error-msg">' . $error . '</span>';
        };
      };
      ?>
      <lebel> First Name: </lebel>
      <input type="text" placeholder="Enter your first name" name="firstName" required>
      <lebel> Surname: </lebel>
      <input type="text" placeholder="Enter your surname" name="surname" required>
      <lebel> Email: </lebel>
      <input type="text" placeholder="Enter your email address" name="email" required>
      <lebel> Contact No: </lebel>
      <input type="text" placeholder="Enter your contact number" name="contactNo" required>
      <lebel> Blood Group: </lebel>
      <input type="text" placeholder="Enter your blood group" name="bloodgroup" required>
      <lebel> New Password: </lebel>
      <input type="text" placeholder="Enter your password" name="password" required>
      <lebel> Re-enter Password: </lebel>
      <input type="text" placeholder="Enter your password" name="rePassword" required>
      <br>
      <lebel> Gender: </lebel>
      <input type = "radio" name = "gender" value="male">Male
      <input type = "radio" name = "gender" value="female">Female
      <br>
      <button type="submit">Sign Up</button>
      <center><p> Already registerd? <a href="loginfile.php"> Go to Login page! </a></p></center>
      <br>
    </form>
  </div>
</body>
</html>
