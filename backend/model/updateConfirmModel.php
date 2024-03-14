<?php
require_once "../config/database.php";

function update($data){
    $database = new Database();
    $db = $database->connection();
    $OrderReceived = $data ['OrderReceived'];
    $ReceiverImage = $data ['ReceiverImage'];
    $Id = $data ['Id'];
    //exit(json_encode($data));

    $stmt = $db->prepare("UPDATE `orders` SET `OrderReceived` = '$OrderReceived', `ReceiverImage` = '$ReceiverImage' WHERE `Id` = '$Id'");
    if ($stmt->execute()){
      return true;
    }else{
      return;
    }

}
?>