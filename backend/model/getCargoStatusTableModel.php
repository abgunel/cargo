<?php
require_once "../config/database.php";

function getCargoStatusTable(){
  $data = [];
  $database = new Database();
  $db = $database->connection();
  $stmt = $db->prepare("SELECT ord.Id, ord.CargoPostDate, cs.CargoStatus, usr.Name, cf.CargoFirm, ord.CargoTrackingCode,  ord.DateTime, ord.OrderName, dep.OrderedDep, ord.OrderedPro, ord.ReceiverImage FROM orders as ord left JOIN departments as dep ON ord.OrderedDepId = dep.OrderedDepId left JOIN cargostatus as cs ON ord.CargoStatusId = cs.CargoStatusId left JOIN cargofirm as cf ON ord.CargoFirmId = cf.CargoFirmId left JOIN users as usr ON ord.Orderer = usr.Id");
  if ($stmt->execute()){
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  return $data;
}

function getFormenCargoStatusTable($Orderer){
  $data = [];
  $database = new Database();
  $db = $database->connection();
  $stmt = $db->prepare("SELECT ord.Id, ord.CargoPostDate, cs.CargoStatus, usr.Name, cf.CargoFirm, ord.CargoTrackingCode, ord.DateTime, ord.OrderName, dep.OrderedDep, ord.OrderedPro, ord.ReceiverImage FROM orders as ord left JOIN departments as dep ON ord.OrderedDepId = dep.OrderedDepId left JOIN cargostatus as cs ON ord.CargoStatusId = cs.CargoStatusId left JOIN cargofirm as cf ON ord.CargoFirmId = cf.CargoFirmId left JOIN users as usr ON ord.Orderer = usr.Id  WHERE ord.Orderer = '$Orderer'");
  if ($stmt->execute()){
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  return $data;

}
?>