<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Donor</title>
  <link rel="stylesheet" href="login.css">  
</head>
<body>
  <center><h1>ULAB Blood Bank</h1></center>
  <br><br><br><br><br><br><br><br>
  <div class = "login">
    <form action="" method="post" enctype="multipart/form-data">
      <center><lebel> Search Donor by Blood Group </lebel></center>
      <input type="text" placeholder="Enter the blood group" name="bloodgroup">
      <input type="Submit" name="submit">
      <br>
      <br>
      <a href="home.html">Back to Home</a>
    </form>
  </div>
</body>
</html>

<?php

$conn = new PDO("mysql:host=localhost;dbname=ulabbloodbank", 'root', '');

if(isset($_POST["submit"])) {
    $str = $_POST["bloodgroup"];
    $sth = $conn->prepare("SELECT * FROM userdetails WHERE bloodgroup='$str'");

    $sth->setFetchMode(PDO::FETCH_OBJ);
    $sth -> execute();

    if($row = $sth->fetch()) {
        ?><br><br><br>
        <table>
            <tr>
                <th>First Name</th>
                <th> Surname</th>
                <th> Email </th>
                <th>Contact No</th>
                <th>Blood Group</th>
                <th>Password</th>
                <th>Gender</th>

            </tr>
            <tr>
                <td><?php echo $row->firstName; ?></td><br>
                <td><?php echo $row->surname; ?></td><br>
                <td><?php echo $row->email; ?></td>
                <td><?php echo $row->contactNo; ?></td>
                <td><?php echo $row->bloodgroup; ?></td>
                <td><?php echo $row->gender; ?></td>
            </tr>
        </table>
    <?php
    }
    else {
        echo "Donor of this blood group is unavilable";
    }
}
    
?>