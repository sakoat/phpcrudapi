<?php
/**
 * https://roytuts.com/php-rest-api-authentication-using-jwt/
 */

 /**
* Author : https://roytuts.com
*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';
include_once '../class/employees.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// get posted data
    $database = new Database();
    $db = $database->getConnection();
    $item = new Employee($db);
    $data = json_decode(file_get_contents("php://input", true));
	
    $item->username = $data->username;
    $item->password = $data->password;
	$res = $item->userRegistration();
    
    if($item->userRegistration()){
		echo json_encode(array('success' => true, 'message' => 'You registered successfully'));
	} else {
		echo json_encode(array('success' => false, 'message' => 'Something went wrong, please contact administrator'));
	}
}

?>