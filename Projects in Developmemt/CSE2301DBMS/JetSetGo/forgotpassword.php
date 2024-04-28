<?php
include('server.php');
?>

<!DOCTYPE html>
<html>

<head>
  <title>Forgot Password</title>
  <link rel="stylesheet" type="text/css" href="css/stylerl.css">
</head>

<body>
  <div class="header">
    <h2>Forgot Password</h2>
  </div>
  <form method="post" action="forgotpassword.php">
    <div class="input-group">
      <label>Email</label>
      <input type="email" name="email" required>
    </div>
    <div class="input-group">
      <button type="submit" class="btn" name="forgot_password">Submit</button>
    </div>
  </form>
</body>

</html>