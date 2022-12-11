<?php 
/**
 * Help  link: https://www.positronx.io/create-simple-php-crud-rest-api-with-mysql-php-pdo/
 * PHP Basic CRUD For Rest api
 *  we use Employee DB Table as example 
 */
    class Database {
        private $host = "127.0.0.1";
        private $database_name = "phpapidb";
        private $username = "root";
        private $port = "3308";
        private $password = "";
        public $conn;

        public function getConnection(){
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=" . $this->host . "; port=". $this->port."; dbname=" . $this->database_name, $this->username, $this->password);
                $this->conn->exec("set names utf8");
            }catch(PDOException $exception){
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->conn;
        }

        public function closeConnection() {
            $this->conn = null;
            //mysqli_close($this->conn);$this->conn->close();

        }
    }  
?>