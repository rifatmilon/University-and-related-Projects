<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// variable declaration
$username = "";
$email    = "";
$contactno = "";
$dob = "";
$errors = array();
$_SESSION['success'] = "";

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'jetsetgo');

//Insert default admin user if there are no users in the database
// Check if there are any users in the database
$result = $db->query("SELECT COUNT(*) AS count FROM users");
$row = $result->fetch_assoc();
if ($row['count'] == 0) {
  // No users, insert default admin user
  $username = 'rifatmilon';
  $password = password_hash('dev123', PASSWORD_DEFAULT);
  $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
  mysqli_query($db, $query);
}


// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $contactno = mysqli_real_escape_string($db, $_POST['contactno']);
  $dob = mysqli_real_escape_string($db, $_POST['dob']);

  // form validation: ensure that the form is correctly filled
  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($email)) {
    array_push($errors, "Email is required");
  }
  if (empty($password_1)) {
    array_push($errors, "Password is required");
  }

  if ($password_1 != $password_2) {
    array_push($errors, "The two passwords do not match");
  }

  // register user if there are no errors in the form
  if (count($errors) == 0) {
    $password = md5($password_1); //encrypt the password before saving in the database
    $query = "INSERT INTO users (username, email, password, contactno, dob) 
					  VALUES('$username', '$email', '$password', '$contactno', '$dob')";
    mysqli_query($db, $query);

    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in, redirecting to Homepage";
    header('location:index.php');
  }
}

// Find a user
if (isset($_POST['find_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);

  // SQL query to find user
  $query = "SELECT * FROM users WHERE username='$username'";

  // Execute the query
  $result = mysqli_query($db, $query);
  if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['found_user'] = $user;
  } else {
    echo "User not found";
  }
}

// ... modify user ...//
// Modify an existing user
if (isset($_POST['mod_user'])) {
  // Get the form data
  $id = $_POST['id'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password_1'];
  $contactno = $_POST['contactno'];
  $dob = $_POST['dob'];

  // Update the user's data in the database
  $query = "UPDATE users SET username='$username', email='$email', password='$password', contactno='$contactno', dob='$dob' WHERE id='$id'";
  mysqli_query($db, $query);
  header('location:admin.php');
  }
//delete user
if (isset($_POST['del_user'])) {
  // delete user
  $username = mysqli_real_escape_string($db, $_POST['username']);

  // SQL query to delete user
  $query = "DELETE FROM users WHERE username='$username'";

  // Execute the query
  if (mysqli_query($db, $query)) {
    echo "User deleted successfully";
    header('location:admin.php');
  } else {
    echo "Error deleting user: " . mysqli_error($db);
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);


  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);

    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now logged in";
      if ($username == 'rifatmilon') {
        header('location: admin.php');
      } else {
        header('location: index.php');
      }
    } else {
      array_push($errors, "Wrong username/password combination");
    }
  }
}


// ... Forgot Password ...
if (isset($_POST['forgot_password'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);

  // Validate the email address
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Invalid email format");
  }

  // Generate a random password
  $new_password = substr(md5(rand()), 0, 7);

  // Hash the new password
  $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

  // Use a prepared statement to prevent SQL injection
  $stmt = $db->prepare("UPDATE users SET password=? WHERE email=?");
  $stmt->bind_param("ss", $hashed_password, $email);

  // Check if the query was successful
  if (!$stmt->execute()) {
    array_push($errors, "Database error: " . $stmt->error);
  }

  // Send an email to the user with the new password
  $to = $email;
  $subject = "Your new password";
  $message = "Your new password is: $new_password";
  $email_sent = mail($to, $subject, $message);

  // Check if the email was sent successfully
  if (!$email_sent) {
    array_push($errors, "Email sending failed");
  }

  // Redirect to the login page
  header('location: login.php');
}

//....profile page...//

// Get the user's username from the session
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];

  // Fetch the user's data from the database
  $sql = "SELECT * FROM users WHERE username = '$username'";
  $result = $db->query($sql);

  if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
      $_SESSION['username'] = $row['username'];
      $_SESSION['email'] = $row['email'];
    }
  } else {
    echo "0 results";
  }
} else {
  // User is not logged in
  $isLoggedIn = false;
}
?>