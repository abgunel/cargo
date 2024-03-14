<?php
require_once "../config/database.php";

function update($data){
    $database = new Database();
    $db = $database->connection();
    $CargoPostDate = $data['CargoPostDate'];
    $CargoStatusId = $data['CargoStatusId'];
    $CargoFirmId = $data ['CargoFirmId'];
    $CargoTrackingCode = $data ['CargoTrackingCode'];
    $Id = $data ['Id'];

    $stmt = $db->prepare("UPDATE `orders` SET `CargoPostDate` = '$CargoPostDate', `CargoStatusId` = '$CargoStatusId', `CargoFirmId` = '$CargoFirmId', `CargoTrackingCode` = '$CargoTrackingCode' WHERE `Id` = '$Id'");
    if ($stmt->execute()){
      return true;
    }else{
      return;
    }

}
?>