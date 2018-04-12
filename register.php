<!DOCTYPE html>
<?php 
 session_start();
require_once ('lib/nusoap.php'); 

if(isset($_POST['register_button'])) 
{ 
	$enroll= $_POST['enroll']; 
	$password= $_POST['password'];
	$f_name= $_POST['f_name'];
	$l_name= $_POST['l_name'];
	$email= $_POST['email'];
	$mo_num= $_POST['mo_num'];
	$sem=$_POST['sem'];
	$dept=$_POST['dept'];
	$batch=$_POST['batch'];

	try{
		$client = new nusoap_client('http://localhost/project/server.php?wsdl'); 
	}catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "<br \\>";
		return;
	}

	try{
		$response = $client->call('reg',[$enroll,$password,$f_name,$l_name,$email,$mo_num,$sem,$dept,$batch]); 
	}catch (Exception $e) {
		echo 'ex in calling get_message: ' ,  $e->getMessage(), "<br \\>";
		return;
	}
	 
	if($client->fault) 
	{ 
		echo "FAULT: <p>Code: (".$client->faultcode."</p>"; 
		echo "String: ".$client->faultstring; 
	} 
	else 
	{
		$_SESSION["reg_user"]=$response['enroll'];
		header("location:info.php");
	}
} 
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<center>
	<div class='wrapper'>
		<fieldset>
			<legend>Register</legend>
			<form action="register.php" method="post">
		        <input type="text" placeholder="Enrollment Number" name="enroll"><br>
		        <input type="password" placeholder='Password' name="password"><br>
		        <input type="text" placeholder='First Name' name="f_name"><br>
		        <input type="text" placeholder="Last Name" name="l_name"><br>
		        <input type="text" placeholder="Email Address" name="email"><br>
		        <input type="text" placeholder="Contact Number" name="mo_num"><br>
		        <input type="text" placeholder="Semester" name="sem"><br>
		        <input type="text" placeholder="Department" name="dept"><br>
		        <input type="text" placeholder="Batch" name="batch"><br>
		        <input type="submit" value="Register" name='register_button'>
		    </form>
		</fieldset>
	</div>

</center>
</body>
</html> 