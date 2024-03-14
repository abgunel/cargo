<?php
require_once "../config/database.php";

function update($data){
    $database = new Database();
    $db = $database->connection();
    $OrderName = $data['OrderName'];
    $Orderer = $data['Orderer'];
    $OrderDescription = $data ['OrderDescription'];
    $OrderedDepId = $data ['OrderedDepId'];
    $OrderedPro = $data ['OrderedPro'];
    $OrderLink = $data ['OrderLink'];
    $OrderImage = $data ['OrderImage'];
    $Id = $data ['Id'];

    $stmt = $db->prepare("UPDATE `orders` SET `OrderName` = '$OrderName', `Orderer` = '$Orderer', `OrderDescription` = '$OrderDescription', `OrderedDepId` = '$OrderedDepId', `OrderedPro` = '$OrderedPro', `OrderLink` = '$OrderLink', `OrderImage` = '$OrderImage' WHERE `Id` = '$Id'");
    if ($stmt->execute()){
      return true;
    }else{
      return;
    }

}
?>