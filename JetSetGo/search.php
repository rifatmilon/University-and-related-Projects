<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jetsetgo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data
$origin = $_POST['origin'];
$depart = $_POST['depart'];

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM Flights WHERE DepartureAirport = ? AND ArrivalAirport = ?");
$stmt->bind_param("ss", $origin, $depart);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch data
while ($row = $result->fetch_assoc()) {
  // Output each row (for testing purposes)
  echo "FlightID: " . $row["FlightID"] . " - Departure: " . $row["DepartureAirport"] . " - Arrival: " . $row["ArrivalAirport"] . "<br>";
}

// Close connection
$stmt->close();
$conn->close();
?>
