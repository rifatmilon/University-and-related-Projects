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

if (isset($_POST['search_flights'])) {
  $origin = mysqli_real_escape_string($db, $_POST['origin']);
  $dest = mysqli_real_escape_string($db, $_POST['depart']);

  // SQL query to find flights
  $query = "SELECT f.*, a1.airportname AS departureairport, a2.airportname AS arrivalairport, al.airlinename, al.airlineurl
            FROM flights f
            JOIN airports a1 ON f.departureairportid = a1.airportid
            JOIN airports a2 ON f.arrivalairportid = a2.airportid
            JOIN airlines al ON f.airlineid = al.airlineid
            WHERE a1.airportname = ? AND a2.airportname = ?";

  // Prepare and bind
  $stmt = $db->prepare($query);
  $stmt->bind_param("ss", $origin, $dest); // "ss" specifies that both parameters are strings

  // Execute the statement
  $stmt->execute();

  // Get the result
  $result = $stmt->get_result();

  // Fetch all rows
  $flights = $result->fetch_all(MYSQLI_ASSOC);

  // Check if any flights were found
  if (count($flights) > 0) {
    // Flights found, store in session
    $_SESSION['flights'] = $flights;
  } else {
    echo "No flights found";
  }
}
?>

<!DOCTYPE html>
<html>
<title>Flight Search</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link rel="stylesheet" href="styleSearch.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="scriptSearch.js"></script>

<body>
  <div class="container">
    <div class="card custom-bg w-75 p-4 d-flex">
      <div class="row">
        <div class="pb-3 h3 text-left">Flight Search &#128747;</div>
      </div>
      <form id="flight-form" action="search.php" method="post">
        <div class="row">
          <div class="form-group col-md align-items-start flex-column">
            <label for="origin" class="d-inline-flex">From</label>
            <input type="text" placeholder="City or Airport" class="form-control" id="origin" name="origin" required>
          </div>
          <div class="form-group col-md align-items-start flex-column">
            <label for="depart" class="d-inline-flex">To</label>
            <input type="text" placeholder="City or Airport" class="form-control" id="depart" name="depart" required>
          </div>
        </div>
        <div class="row">
          <div class="text-left col-auto">
            <button type="submit" class="btn btn-primary" name="search_flights">Search flights</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <br>
  <?php if (isset($flights) && count($flights) > 0) : ?>
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Flight ID</th>
            <th>Airline</th>
            <th>Flight Number</th>
            <th>Departure Airport</th>
            <th>Arrival Airport</th>
            <th>Departure Time</th>
            <th>Arrival Time</th>
            <th>Duration</th>
            <th>Seats Available</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($flights as $flight) : ?>
            <tr>
              <td><?php echo $flight['flightid']; ?></td>
              <td><?php echo $flight['airlinename']; ?></td>
              <td><?php echo $flight['flightnumber']; ?></td>
              <td><?php echo $flight['departureairport']; ?></td>
              <td><?php echo $flight['arrivalairport']; ?></td>
              <td><?php echo $flight['departuredatetime']; ?></td>
              <td><?php echo $flight['arrivaldatetime']; ?></td>
              <td><?php echo $flight['duration']; ?></td>
              <td><?php echo $flight['seatsavailable']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
  <p>
    Wanna go back to homepage? <a href="index.php">Click here</a>
  </p>
</body>

</html>