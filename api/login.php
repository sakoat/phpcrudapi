<?php
/**
 * https://roytuts.com/php-rest-api-authentication-using-jwt/
 * 
 */
include_once '../config/database.php';
include_once '../class/employees.php';
include_once '../jwt/GenerateJwtToken.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// get posted data
	$database = new Database();
    $db = $database->getConnection();
    $item = new Employee($db);
    $data = json_decode(file_get_contents("php://input", true));
	
    $item->username = $data->username;
    $item->password = $data->password;
	
	$result = $item->getSingleUser();
	
	if (!isset($result) || empty($result)) {
		echo json_encode(array('error' => 'Invalid User'));
	} else {
		$tokenObj = new GenerateJwtToken();
		$username = $result['username'];
		
		$headers = array('alg'=>'HS256','typ'=>'JWT');
		$payload = array('username'=>$username, 'exp'=>(time() + 3600));

		$jwt =  $tokenObj->generate_jwt($headers, $payload);
		
		echo json_encode(array('token' => $jwt));
	}
}

?>