<?php
require_once "../config/database.php";

function insert($data){
    $database = new Database();
    $db = $database->connection();
    $OrderName = $data['OrderName'];
    $Orderer = $data['Orderer'];
    $OrderDescription = $data ['OrderDescription'];
    $OrderedDepId = $data ['OrderedDepId'];
    $OrderedPro = $data ['OrderedPro'];
    $OrderLink = $data ['OrderLink'];
    $OrderImage = $data ['OrderImage'];

    $stmt = $db->prepare("INSERT INTO `orders` (`OrderName`, `Orderer`, `OrderDescription`, `OrderedDepId`, `OrderedPro`, `OrderLink`, `OrderImage`)
    VALUES (:OrderName, :Orderer, :OrderDescription, :OrderedDepId, :OrderedPro, :OrderLink, :OrderImage)");

    $stmt->bindParam(':OrderName', $OrderName);
    $stmt->bindParam(':Orderer', $Orderer);
    $stmt->bindParam(':OrderDescription', $OrderDescription);
    $stmt->bindParam(':OrderedDepId', $OrderedDepId);
    $stmt->bindParam(':OrderedPro', $OrderedPro);
    $stmt->bindParam(':OrderLink', $OrderLink);
    $stmt->bindParam(':OrderImage', $OrderImage);

    if ($stmt->execute()){
      return true;
    }
    else{
      return;
  }
}
?>