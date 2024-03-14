<?php
require_once "../config/database.php";

function getDep(){
    $data = [];
    $database = new Database();
    $db = $database->connection();
    $stmt = $db->prepare("SELECT * FROM `departments`");
    if ($stmt->execute()){
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $data;
  }

?>