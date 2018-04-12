<!DOCTYPE html>
<?php 
session_start();
require_once ('lib/nusoap.php'); 

if(isset($_POST['login_button'])) 
{ 
	$u_name= $_POST['enroll']; 
	$password= $_POST['password'];

	try{
		$client = new nusoap_client('http://localhost/project/server.php?wsdl'); 
	}catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "<br \\>";
		return;
	}

	try{
		$response = $client->call('authentication',[$u_name,$password]); 
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
		if(is_null($response)){
			print_r("<script>alert('Enrollment and Password not in database!');</script>");
		}
		elseif($response['enroll']=='admin'){
			header("location:admin_dash.php");
		}
		else{ 
			$_SESSION["reg_user"]=$response['enroll'];
			header("location:info.php");
		}
	}
} 
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<center>
	<div class='wrapper'>
		<fieldset>
			<legend>Login</legend>
			<form action="login.php" method="post">
		        <input type="text" placeholder="Enrollment Number" name="enroll"><br>
		        <input type="password" placeholder='Password' name="password"><br>
		        <input name='login_button' type="submit" value="Login">
		    </form>
		</fieldset>
	</div>

</center>
</body>
</html> 