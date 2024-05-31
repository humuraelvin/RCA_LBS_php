<?php
// used to get mysql database connection
class NewDatabase{

    private $db_host = DB_SERVER;
    private $db_name = DB_NAME;
    private $db_user = DB_USER;
    private $db_password = DB_PASSWORD;
    private $connection;

    public function getConnection(){

        $this->connection = null;

        try{
            $this->connection = new PDO("mysql:host=" . $this->db_host . ";dbname=" . $this->db_name, $this->db_user, $this->db_password);
        }catch(PDOException $exception){
            echo "Connection failed: " . $exception->getMessage();
        }

        return $this->connection;
    }
}
?>