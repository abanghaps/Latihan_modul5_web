<?php


class Database
{
    private $conn;

    public function __construct($host, $username, $password, $database)
    {
        $this->conn = new mysqli($host, $username, $password, $database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
    
}
class Controller
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
}

?>
