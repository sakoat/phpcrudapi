<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    
    include_once '../config/database.php';
    include_once '../class/employees.php';
    include_once '../jwt/GenerateJwtToken.php';

    $tokenObj = new GenerateJwtToken();
    $is_jwt_valid = false;
    $bearer_token = $tokenObj->get_bearer_token();
    if ($bearer_token) {
        $is_jwt_valid = $tokenObj->is_jwt_valid($bearer_token);
    }
    if ($is_jwt_valid) {
        $database = new Database();
        $db = $database->getConnection();
        $items = new Employee($db);
        $stmt = $items->getEmployees();
        $itemCount = $stmt->rowCount();

        //echo json_encode($itemCount);
        if($itemCount > 0){
        
            $employeeArr = array();
            $employeeArr["body"] = array();
            $employeeArr["itemCount"] = $itemCount;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $e = array(
                    "id" => $id,
                    "name" => $name,
                    "email" => $email,
                    "age" => $age,
                    "designation" => $designation,
                    "created" => $created
                );
                array_push($employeeArr["body"], $e);
            }
            echo json_encode($employeeArr);
        } else {
            http_response_code(404);
            echo json_encode(
                array("message" => "No record found.")
            );
        }
    } else {
        echo json_encode(array('error' => 'Access denied'));
    }
?>