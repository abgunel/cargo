<?php

class Database 
{
    private $servername = "localhost:3306";
    private $username = "root";
    private $password = "";
    private $dbname = "cargo";
    private $conn;
    
    public function connection()
    {
      try{
        $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
      } catch (PDOException $e){
        echo "Connection failed: " . $e->getMessage();
      }
      return $this->conn;
    }
}

  ?>