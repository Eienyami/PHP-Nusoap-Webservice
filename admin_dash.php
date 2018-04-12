<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<center>
	<div class='wrapper'>
		<legend>Welcome Admin!</legend>
		<form action="admin_dash.php" method="post">
			<fieldset>
				<table style="border: 1">
					<tr>
						<th>Semester</th>
						<th>Department</th>
						<th>Batch</th>
					</tr>
					<tr>
						<td>							
							<input type="checkbox" name="formSem[]" value="2" checked="true">2<br>
							<input type="checkbox" name="formSem[]" value="4" checked="true">4<br>
							<input type="checkbox" name="formSem[]" value="6" checked="true">6<br>
							<input type="checkbox" name="formSem[]" value="8" checked="true">8
						</td>
						<td>
							<input type="checkbox" name="formDept[]" value="BM" checked="true">BM<br>
							<input type="checkbox" name="formDept[]" value="CE" checked="true">CE<br>
							<input type="checkbox" name="formDept[]" value="EC" checked="true">EC<br>
							<input type="checkbox" name="formDept[]" value="IC" checked="true">IC<br>
							<input type="checkbox" name="formDept[]" value="MET" checked="true">MET
						</td>
						<td>
							<input type="checkbox" name="formBatch[]" value="A1" checked="true">A1<br>
							<input type="checkbox" name="formBatch[]" value="A2" checked="true">A2<br>
							<input type="checkbox" name="formBatch[]" value="A3" checked="true">A3<br>
							<input type="checkbox" name="formBatch[]" value="B1" checked="true">B1<br>
							<input type="checkbox" name="formBatch[]" value="B2" checked="true">B2<br>
							<input type="checkbox" name="formBatch[]" value="B3" checked="true">B3
						</td>
					</tr>

				</table><br>
				<input name='submit_button' type="submit" value="Submit">				
			</fieldset>
	    </form>
	</div>
</center>
</body>
</html>

<?php

if(isset($_POST['submit_button'])) 
{
	$sem=$_POST['formSem'];
	$dept=$_POST['formDept'];
	$batch=$_POST['formBatch'];

	$cs=count($sem)-1;
	$cd=count($dept)-1;
	$cb=count($batch)-1;

	$sql = "SELECT * FROM student WHERE (sem = '";
	    for($i=0; $i < ($cs); $i++)
	    {
	      $sql .= $sem[$i] . "'or sem='";
	    }
	    $sql .= $sem[$cs] . "' )and( dept = '"; 
	    for($i=0; $i < ($cd); $i++)
	    {
	      $sql .= ($dept[$i] . "'or dept='");
	    } $sql .= $dept[$cd] . "' )and( batch = '";
	    for($i=0; $i < ($cb); $i++)
	    {
	      $sql .=($batch[$i] . "'or batch='");
	    }
	    $sql .= $batch[$cb] . "');";

	$conn = new mysqli("localhost", "root", "root","student");
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}
	$result = $conn->query($sql) or die($conn->error);

	echo"<center><table border='1'><legend>Registerd Users</legend></center>";
	echo"<tr><th>Enrollment No</th> <th>First Name</th> <th>Last Name</th> <th>Email</th>
	<th>Contact Number</th> <th>Semester</th> <th>Department</th> <th>Batch</th> </tr>";

	while($data=$result->fetch_assoc())
	{
	    echo"<tr><td>".$data["enrollment"]."</td>";
	    echo"<td>".$data["first_name"]."</td>";
	    echo"<td>".$data["last_name"]."</td>";
	    echo"<td>".$data["email"]."</td>";
	    echo"<td>".$data["mo_number"]."</td>";
	    echo"<td>".$data["sem"]."</td>";
	    echo"<td>".$data["dept"]."</td>";
	    echo"<td>".$data["batch"]."</td></tr>";
	}
	echo"</table>";
}
?>

