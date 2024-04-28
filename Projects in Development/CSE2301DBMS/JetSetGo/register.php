<?php include('server.php') ?>
<!DOCTYPE html>
<html>

<head>
  <title>Registration system</title>
  <link rel="stylesheet" type="text/css" href="css/stylerl.css">
</head>

<body>
  <div class="header">
    <h2>Sign up</h2>
  </div>

  <form method="post" action="register.php">

    <?php include('errors.php'); ?>

    <div class="input-group">
      <label>Username</label>
      <input type="text" name="username" value="<?php echo $username; ?>">
    </div>
    <div class="input-group">
      <label>Email</label>
      <input type="email" name="email" value="<?php echo $email; ?>">
    </div>
    <div class="input-group">

      <label>Password</label>
      <input type="password" name="password_1">
    </div>
    <div class="input-group">
      <label>Confirm password</label>
      <input type="password" name="password_2">
    </div>
    <div class="input-group">
      <label>Contact No</label>
      <input type="text" name="contactno" value="<?php echo $contactno; ?>">
    </div>
    <div class="input-group">
      <label>Date of Birth (format: day/month/year)</label>
      <input type="text" name="dob" value="<?php echo $dob; ?>">
    </div>

    <div class="input-group">
      <button type="submit" class="btn" name="reg_user">Register</button>
    </div>
    <p>
      Already a member? <a href="login.php">Sign in</a>
    </p>
  </form>

  <footer id="footer" class="footer">
    <div class="footerContainer">
      <p class="copyright">© 2024 by rifatmilon.</p>
    </div>
  </footer>
</body>

</html>