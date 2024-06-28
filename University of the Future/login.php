<?php

@include 'connectDatabase.php';

session_start();

if (isset($_POST['submit'])) {

    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
    $password = md5($_POST['password']);
    $rePassword = md5($_POST['rePassword']);
    $gender = $_POST['gender'];
    $lastCompletedDegree = mysqli_real_escape_string($conn, $_POST['lastCompletedDegree']);

    $select = "SELECT * FROM signup WHERE email='$email' && password='$password'";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
    $rows = mysqli_fetch_array($result);

        $_SESSION[$fullname] = $rows[$fullname];
        header('location:indexZero.html');
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
    <form action="login2.php" method="post" enctype="multipart/form-data">
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
      <center><p> Don't have an account? <a href="signup.php"> Resister now! </a></p></center>
      <br>
    </form>
  </div>
</body>
</html>