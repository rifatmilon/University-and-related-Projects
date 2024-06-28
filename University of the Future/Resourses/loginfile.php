<?php

@include 'configfile.php';

session_start();

if (isset($_POST['submit'])) {

  $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
  $surname = mysqli_real_escape_string($conn, $_POST['surname']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
  $password = md5($_POST['password']);
  $rePassword = md5($_POST['rePassword']);
  $gender = $_POST['gender'];

  $select = "SELECT * FROM userdetails WHERE email='$email' && password='$password'";

  $result = mysqli_query($conn, $select);

  if (mysqli_num_rows($result) > 0) {
      $rows = mysqli_fetch_array($result);

      $_SESSION[$firstName] = $rows[$firstName];
      header('location:alhome.html');
  }
  else {
    $error[] = 'Invalid email or password';
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Login Page</title>
  <link rel="stylesheet" href="login.css">  
</head>
<body>
  <center><h1>Sign in your account</h1></center>
  <br><br><br><br><br><br><br><br>
  <div class = "login">
    <form action="login.php" method="post" enctype="multipart/form-data">
    <?php 
      if(isset($error)) {
        foreach($error as $error) {
            echo '<span class="error-msg">' . $error . '</span>';
        };
      };
      ?>
      <lebel> Email: </lebel>
      <input type="text" placeholder="Enter your email address" name="email" required>
      <lebel> Password: </lebel>
      <input type="password" placeholder="Enter your password" name="password" required>
      <input type="checkbox" checked="checked"> Remember Login Details
      <br>
      <button type="submit"><a href="signup.html"></a>Login</button>
      <center><p> Don't have an account? <a href="signupfile.php"> Resister now! </a></p></center>
      <br>
    </form>
  </div>
</body>
</html>