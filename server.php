<?php
require_once ('lib/nusoap.php');
$namespace = "http://localhost/project/server.php?wsdl";
$server = new soap_server();
$server->configureWSDL("auth");
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
        'res',
        'complexType',
        'struct',
        'all',
        '',
    array( 
        'enroll' => array('name' => 'enroll','type' => 'xsd:string'),
        'pass' => array('name' => 'pass','type' => 'xsd:string')
    )
);

$server->register('authentication',
	array('enroll'=>'xsd:string', 'password' => 'xsd:string'),
    array('return'=>'tns:res'),
	$namespace,false,
        'rpc',
        'encoded',
        'Sample of embedded classes...');

$server->register('reg',
	array('enroll'=>'xsd:string',
		'password' => 'xsd:string',
		'f_name' => 'xsd:string',
		'l_name' => 'xsd:string',
		'email' => 'xsd:string',
		'num' => 'xsd:string',
		'sem' => 'xsd:int',
		'dept' => 'xsd:string',
		'batch' => 'xsd:string',),
    array('return'=>'tns:res'),
	$namespace,false,
        'rpc',
        'encoded',
        'Sample of embedded classes...');



function authentication($enroll,$password)
{
    $conn = new mysqli("localhost", "root", "root","student");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
	$sql = "SELECT enrollment, password FROM student";
	$result = $conn->query($sql) or die($conn->error);

	while($data=$result->fetch_assoc())
	{
		if ($enroll == $data['enrollment'] && $password == $data['password']){
			$response=array('enroll'=>$enroll, 'pass'=>$password);
			return $response;
			break;
		}
	}
	return null;
}

function reg($enroll,$password,$f_name,$l_name,$email,$num,$sem,$dept,$batch)
{
    $conn = new mysqli("localhost", "root", "root","student");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
	$sql = "INSERT INTO student VALUES ('".$enroll."','".$password."','".$f_name."','".$l_name.
										"','".$email."','".$num."','".$sem."','".$dept."','".$batch."');";

	if ($conn->query($sql) === TRUE) {
	    $response=array('enroll'=>$enroll, 'pass'=>$password);
		return $response;
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
 
$server->service($POST_DATA);
exit(); 
?>