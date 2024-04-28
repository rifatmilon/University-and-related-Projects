<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
} // start the session if not started yet

// Include the server.php file
include 'server.php';

if (file_exists('errors.php')) {
  include('errors.php');
} else {
  die('errors.php file not found.');
}

// Check if the user is an admin
if (!isset($_SESSION['username']) || $_SESSION['username'] != 'rifatmilon') {
  die('You do not have permission to access this page.');
}

// Define $id before using it
$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
  // Use prepared statements to prevent SQL Injection
  $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
}

// Fetch all users from the database
$result = $db->query("SELECT * FROM users");
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
  <title>Admin Page</title>
  <!-- Include the CSS file -->
  <link rel="stylesheet" type="text/css" href="css/styleadminpage.css">
</head>

<body>
  <div class="container">
    <h1>Admin Page</h1>
    <br>
    <H2>Table of all users</H2>
    <!-- Display a table of all users -->
    <table>
      <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Contact No</th>
        <th>DOB</th>
        <!-- Add more columns as needed -->
      </tr>
      <?php foreach ($users as $user) : ?>
        <tr>
          <td><?php echo $user['id']; ?></td>
          <td><?php echo $user['username']; ?></td>
          <td><?php echo $user['email']; ?></td>
          <td><?php echo $user['contactno']; ?></td>
          <td><?php echo $user['dob']; ?></td>
          <!-- Add more columns as needed -->
        </tr>
      <?php endforeach; ?>
    </table>
    <br>
    <h2>Add Users</h2>
    <!-- Add a form for adding a users -->
    <form method="post" action="admin.php">

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
      <input type="submit" name="reg_user" value="Register User">
    </form>

    <br>
    <h2>Find Users</h2>
    <!-- Add a form for finding a user -->
    <form method="post" action="admin.php">
      <div class="input-group">
        <label>Find User</label>
        <input type="text" name="username">
      </div>
      <input type="submit" name="find_user" value="Find User">
    </form>

    <br>
    <h2>Modify Users</h2>
    <!-- Add a form for modifying a user -->
    <form id="modifyUserForm" method="post" action="admin.php">
      <input type="hidden" name="id" value="<?php echo isset($_SESSION['found_user']) ? $_SESSION['found_user']['id'] : ''; ?>">

      <div class="input-group">
        <label>Username</label>
        <input type="text" name="username" value="<?php echo isset($_SESSION['found_user']) ? $_SESSION['found_user']['username'] : ''; ?>">
      </div>
      <div class="input-group">
        <label>Email</label>
        <input type="email" name="email" value="<?php echo isset($_SESSION['found_user']) ? $_SESSION['found_user']['email'] : ''; ?>">
      </div>
      <div class="input-group">
        <label>Password</label>
        <input type="password" name="password_1" value="<?php echo isset($_SESSION['found_user']) ? $_SESSION['found_user']['password'] : ''; ?>">
      </div>
      <div class="input-group">
        <label>Confirm password</label>
        <input type="password" name="password_2" value="<?php echo isset($_SESSION['found_user']) ? $_SESSION['found_user']['password'] : ''; ?>">
      </div>
      <div class="input-group">
        <label>Contact No</label>
        <input type="text" name="contactno" value="<?php echo isset($_SESSION['found_user']) ? $_SESSION['found_user']['contactno'] : ''; ?>">
      </div>
      <div class="input-group">
        <label>Date of Birth (format: day/month/year)</label>
        <input type="text" name="dob" value="<?php echo isset($_SESSION['found_user']) ? $_SESSION['found_user']['dob'] : ''; ?>">
      </div>

      <input type="submit" name="mod_user" value="Modify User">
      <input type="button" value="Clear Data" onclick="clearFormData()">
    </form>

    <br>
    <h2>Delete Users</h2>

    <!-- Add a form for deleting a user -->
    <form method="post" action="admin.php">
      <div class="input-group">
        <label>Username</label>
        <input type="text" name="username" value="<?php echo $username; ?>">
      </div>
      <input type="submit" name="del_user" value="Delete User">
    </form>
  </div>

  <!-- Include the JavaScript file -->
  <script src="js/cleardata.js"></script>
</body>

</html>