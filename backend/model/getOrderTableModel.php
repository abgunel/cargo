<?php
require_once "../config/database.php";

function getOrderTable(){
  $data = [];
  $database = new Database();
  $db = $database->connection();
  $stmt = $db->prepare("SELECT ord.Id, ord.DateTime, ord.OrderName, usr.Name, dep.OrderedDep, ord.OrderedPro, ord.OrderLink, ord.OrderImage, ord.OrderDescription FROM orders as ord left JOIN departments as dep ON ord.OrderedDepId = dep.OrderedDepId left JOIN users as usr ON ord.Orderer = usr.Id");
  if ($stmt->execute()){
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  return $data;
}

function getFormenOrderTable($Orderer){
  $data = [];
  $database = new Database();
  $db = $database->connection();
  $stmt = $db->prepare("SELECT ord.Id, ord.DateTime, ord.OrderName, usr.Name, dep.OrderedDep, ord.OrderedPro, ord.OrderLink, ord.OrderImage, ord.OrderDescription FROM orders as ord left JOIN departments as dep ON ord.OrderedDepId = dep.OrderedDepId left JOIN users as usr ON ord.Orderer = usr.Id WHERE ord.Orderer = $Orderer ");
  if ($stmt->execute()){
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  return $data;

}
?>