<?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  if (isset($_SESSION['username'])) {
    // User is already logged in
    header('Location: index.php');
    exit();
  }
  include('server.php') 
?>
<!DOCTYPE html>
<html>

  <head>
    <title>Registration system</title>
    <link rel="stylesheet" type="text/css" href="css/stylerl.css">
  </head>

  <body>

    <div class="header">
      <h2>Login</h2>
    </div>

    <form method="post" action="login.php">

      <?php include('errors.php'); ?>

      <div class="input-group">
        <label>Username</label>
        <input type="text" name="username">
      </div>
      <div class="input-group">
        <label>Password</label>
        <input type="password" name="password">
      </div>
      <div class="input-group">
        <button type="submit" class="btn" name="login_user">Login</button>
      </div>
      <p>
        Forgot password? <a href="forgotpassword.php">Reset Password</a>
      </p>
      <p>
        Not yet a member? <a href="register.php">Sign up</a>
      </p>
    </form>
    <footer id="footer" class="footer">
      <div class="footerContainer">
        <p class="copyright">© 2024 by rifatmilon.</p>
      </div>
    </footer>

  </body>

</html>