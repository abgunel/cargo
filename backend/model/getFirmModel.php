<?php
require_once "../config/database.php";

function getFirm(){
    $data = [];
    $database = new Database();
    $db = $database->connection();
    $stmt = $db->prepare("SELECT * FROM `cargofirm`");
    if ($stmt->execute()){
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $data;
  }

?>