<?php
require_once "../config/database.php";

function getConfirmOrderTable(){
  $data = [];
  $database = new Database();
  $db = $database->connection();
  $stmt = $db->prepare("SELECT ord.Id, ord.ReceiverImage, ord.DateTime, ord.OrderName, ord.OrderedPro, ord.OrderDescription, rec.ReceiveStatus FROM orders as ord left JOIN `receive` as rec ON ord.OrderReceived = rec.Id");
  if ($stmt->execute()){
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  return $data;
}

function getFormenConfirmOrderTable($Orderer){
  $data = [];
  $database = new Database();
  $db = $database->connection();
  $stmt = $db->prepare("SELECT ord.Id, ord.ReceiverImage, ord.DateTime, ord.OrderName, ord.OrderedPro, ord.OrderDescription, rec.ReceiveStatus FROM orders as ord left JOIN `receive` as rec ON ord.OrderReceived = rec.Id WHERE ord.Orderer = '$Orderer'");
  if ($stmt->execute()){
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  return $data;

}
?>