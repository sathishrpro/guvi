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
	$input['email'] = $email ;
	$input['pwd'] = $pwd;

	$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
  	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $conn->prepare("select * from users where email=:email and pwd=:pwd");
 	$stmt->execute($input);
    if($stmt->rowCount()>0)
    { 
    	$data['message'] = 'Successfully logged in!';
		$data['status'] = 200;
		header('Content-Type: application/json');
		echo json_encode($data);
		return;
    }

    $data['message'] = 'Invalid email or password';
	$data['status'] = 400;
	header('Content-Type: application/json');
	echo json_encode($data);
	return;
}
catch(Exception $e)
{
	echo "Error: " . $e->getMessage();
}




?>