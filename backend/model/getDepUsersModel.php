<?php
require_once "../config/database.php";

function getUserList($depId){
    $data = [];
    $database = new Database();
    $db = $database->connection();
    $stmt = $db->prepare("SELECT `Id`, `Name` FROM `users` WHERE `DepId` = '$depId'");
    if ($stmt->execute()){
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $data;
  }

?>