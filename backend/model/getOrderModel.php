<?php
require_once "../config/database.php";

function getOrder($id){
    $data = [];
    $database = new Database();
    $db = $database->connection();
    //$stmt = $db->prepare("SELECT ord.Id, ord.DateTime, ord.OrderName, ord.Orderer, dep.OrderedDep, ord.OrderedPro, ord.OrderLink, ord.OrderImage, ord.OrderDescription FROM orders as ord left JOIN departments as dep ON ord.OrderedDepId = dep.OrderedDepId WHERE ord.Id = '$id'");
    $stmt = $db->prepare("SELECT OrderName, OrderDescription, OrderedDepId, Orderer, OrderedPro, OrderLink, OrderImage FROM `orders` WHERE `Id` = '$id' ");
    if ($stmt->execute()){
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    return $data;
  }

?>