<?php
  
try
{
  
 	$usersJSON = file_get_contents('users.json');
 	$users = json_decode($usersJSON,true);
	$data['users'] = $users;
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