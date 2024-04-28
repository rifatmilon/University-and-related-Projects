<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Include the server.php file
include 'server.php';

// Set a default avatar image
$avatar = 'img/default-avatar.png';

// Get user's booked flights
if (isset($_SESSION['id'])) {
  $user_id = $_SESSION['id']; // Assuming the user's ID is stored in session
  $query = "SELECT * FROM bookings WHERE userid = ?";
  $stmt = $db->prepare($query);
  if ($stmt === false) {
    die("Error preparing statement: " . $db->error);
  }
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $bookings = $result->fetch_all(MYSQLI_ASSOC);
} else {
  $bookings = array(); // Empty array if 'id' is not set in session
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Profile Page</title>
</head>

<body>
  <div class="profile">
    <div class="avatar">
      <img src="<?php echo $avatar; ?>" alt="Avatar">
    </div>
    <div class="info">
      <h2><?php echo "Username: " . $_SESSION['username']; ?></h2>
      <p><?php echo "Email: " . $_SESSION['email']; ?></p>
    </div>
    <div class="bookings">
      <h3>Your Booked Flights:</h3>
      <?php foreach ($bookings as $booking) : ?>
        <p>Booking ID: <?php echo $booking['bookingid']; ?></p>
        <p>Flight ID: <?php echo $booking['flightid']; ?></p>
        <p>Total Price: <?php echo $booking['totalprice']; ?></p>
        <p>Booking Date: <?php echo $booking['bookingdate']; ?></p>
        <p>Seat Count: <?php echo $booking['seatcount']; ?></p>
        <hr>
      <?php endforeach; ?>
    </div>
    <p>
      Wanna go back to homepage? <a href="index.php">Click here</a>
    </p>
  </div>
</body>

</html>