<?php
require_once "../config/database.php";

function remove($id){
    $data = [];
    $database = new Database();
    $db = $database->connection();
    $stmt = $db->prepare("DELETE FROM `orders` WHERE `Id` = '$id'");
    if ($stmt->execute()){
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $data;
  }

?>