<?php
include_once('database.php');

$email = $_POST['email'];
$pwd = sha1($_POST['pwd']);

if(!filter_var($email, FILTER_VALIDATE_EMAIL))
{
	$data['message'] = 'Invalid email';
	$data['status'] = 400;
	header('Content-Type: application/json');
	echo json_encode($data);
	return;
}

if(empty($pwd))
{
	$data['message'] = 'Please enter your password';
	$data['status'] = 400;
	header('Content-Type: application/json');
	echo json_encode($data);
	return;
}

try
{
	$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $conn->prepare("INSERT into users (email, pwd) values (:email, :pwd)");
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':pwd',  $pwd);
	$stmt->execute();
    $data['message'] = 'Successfully registered. Pleas click <a href="login.html">here</a> to login.';
	$data['status'] = 200;
	header('Content-Type: application/json');
	echo json_encode($data);
	return;
}
catch(Exception $e)
{
	echo "Error: " . $e->getMessage();
}




?>	