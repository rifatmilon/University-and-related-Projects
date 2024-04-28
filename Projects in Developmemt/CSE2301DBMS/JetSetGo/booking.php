<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jetsetgo";

// Create connection
$db = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
  die("Connection failed: " . $db->connect_error);
}

if (isset($_POST['book_flight'])) {
  $flight_id = intval($_POST['flight_id']);
  $user_id = intval($_POST['user_id']);
  $seat_count = intval($_POST['seat_count']); // Convert seat_count to integer

  // Check if user exists
  $query = "SELECT id FROM users WHERE id = ?";
  $stmt = $db->prepare($query);
  if ($stmt === false) {
    die("Error preparing statement: " . $db->error);
  }
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows === 0) {
    echo "User not found.";
    exit;
  }

  // SQL query to get baseprice from flights table
  $query = "SELECT baseprice FROM flights WHERE flightid = ?";
  $stmt = $db->prepare($query);
  if ($stmt === false) {
    die("Error preparing statement: " . $db->error);
  }
  $stmt->bind_param("i", $flight_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows === 0) {
    echo "Flight not found.";
    exit;
  }
  $row = $result->fetch_assoc();
  $price_per_seat = $row['baseprice'];

  // Calculate total price
  $total_price = $seat_count * $price_per_seat;

  // SQL query to book a flight
  $query = "INSERT INTO bookings (userid, flightid, totalprice, bookingdate, seatcount) VALUES (?, ?, ?, NOW(), ?)";

  // Prepare and bind
  $stmt = $db->prepare($query);
  if ($stmt === false) {
    die("Error preparing statement: " . $db->error);
  }
  $stmt->bind_param("iidi", $user_id, $flight_id, $total_price, $seat_count); // "iidi" specifies the types of parameters

  // Execute the statement
  if ($stmt->execute()) {
    echo "Flight booked successfully. Total price: " . $total_price; // Display total price
  } else {
    echo "Error: " . $stmt->error;
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Flight Booking</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      padding: 20px;
    }

    form {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 5px;
      max-width: 500px;
      margin: 0 auto;
    }

    label {
      display: block;
      margin-bottom: 5px;
    }

    input[type="number"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      border: 1px solid #cccccc;
    }

    input[type="submit"] {
      background-color: #007BFF;
      color: #ffffff;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
  <form action="booking.php" method="post">
    <label for="flight_id">Flight ID:</label><br>
    <input type="number" id="flight_id" name="flight_id" required><br>
    <label for="user_id">User ID:</label><br>
    <input type="number" id="user_id" name="user_id" required><br>
    <label for="seat_count">Seats to Book:</label><br>
    <input type="number" id="seat_count" name="seat_count" required><br>
    <input type="submit" name="book_flight" value="Book Flight">
  </form>

  <p>
    Wanna go back to homepage? <a href="index.php">Click here</a>
  </p>
</body>

</html>