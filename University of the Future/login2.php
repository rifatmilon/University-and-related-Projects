<?php

@include 'connectDatabase.php';

session_start();

if (isset($_POST['submit'])) {

    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contactNo = mysqli_real_escape_string($conn, $_POST['contactNo']);
    $password = md5($_POST['password']);
    $rePassword = md5($_POST['rePassword']);
    $gender = $_POST['gender'];
    $lastCompletedDegree = mysqli_real_escape_string($conn, $_POST['lastCompletedDegree']);

    $select = "SELECT * FROM signup WHERE email='$email' && password='$password'";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
    $rows = mysqli_fetch_array($result);

        $_SESSION[$fullname] = $rows[$fullname];
        header('location:indexZero.html');
    }
    else {
        $error[] = 'Invalid email or password';
    }
}
?>