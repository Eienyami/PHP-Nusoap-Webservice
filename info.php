<!DOCTYPE html>
<title>Welcome!</title>
<link rel="stylesheet" type="text/css" href="style.css">
<?php
session_start();
$conn = new mysqli("localhost", "root", "root","student");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = 'SELECT * FROM student WHERE enrollment = \''. $_SESSION['reg_user'].'\';';
$result = $conn->query($sql) or die($conn->error);

while($data=$result->fetch_assoc())
{
	echo"<center><legend>Welcome ".$data["first_name"]."</legend></center>";
    echo"<center><table border='1'></center>";
    echo"<tr><td>Enrollment Number</td><td>".$data["enrollment"]."</td></tr>";
    echo"<tr><td>Firstname</td><td>".$data["first_name"]."</td></tr>";
    echo"<tr><td>Lastname</td><td>".$data["last_name"]."</td></tr>";
    echo"<tr><td>Email Address</td><td>".$data["email"]."</td></tr>";
    echo"<tr><td>Contact Number</td><td>".$data["mo_number"]."</td></tr>";
    echo"<tr><td>Semester</td><td>".$data["sem"]."</td></tr>";
    echo"<tr><td>Department</td><td>".$data["dept"]."</td></tr>";
    echo"<tr><td>Batch</td><td>".$data["batch"]."</td></tr>";
    echo"</table>";
}
$conn->close();
?>