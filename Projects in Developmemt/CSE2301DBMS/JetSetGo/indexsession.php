<?php
include 'server.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
} // start the session if not started yet

if (isset($_SESSION['username'])) { // check if user is logged in
  $loginLink = "index.php"; // Link to the profile page
  $loginText = "My Profile";
  $bookNowLink = "booking.php";
  $searchFlightsLink = "search.html";
} else {
  $loginLink = "login.php";
  $loginText = "Login";
  $bookNowLink = "login.php";
  $searchFlightsLink = "login.php";
}
