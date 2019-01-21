<?php
include_once('database.php');

$name = $_POST['name'];
$email = $_POST['email'];
$father_name = $_POST['father_name'];
$qualification = $_POST['qualification'];
$position = $_POST['position'];
$address = $_POST['address'];
$dob = $_POST['dob'];
$company_name = $_POST['company_name'];


if(!filter_var($email, FILTER_VALIDATE_EMAIL))
{
	$data['message'] = 'Invalid email';
	$data['status'] = 400;
	header('Content-Type: application/json');
	echo json_encode($data);
}
 
try
{
 	$conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
	$stmt = $conn->prepare("update users set name= :name, father_name= :father_name, qualification= :qualification, position= :position, address= :address, dob= :dob, company_name= :company_name where email= :email");
	$stmt->bindValue(':name', $name);
	$stmt->bindValue(':father_name', $father_name);
	$stmt->bindValue(':qualification', $qualification);
	$stmt->bindValue(':position', $position);
	$stmt->bindValue(':address', $address);
	$stmt->bindValue(':dob', $dob);
	$stmt->bindValue(':company_name', $company_name);
	$stmt->bindValue(':email', $email);
	$stmt->execute();

	//write user details to json file
	$stmt = $conn->prepare("select * from users");
	$stmt->execute();
	$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

 	$fp = fopen('users.json','w');
	fwrite($fp, json_encode($users));
	fclose($fp);
	$data['message'] = 'Successfully profile updated.';
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