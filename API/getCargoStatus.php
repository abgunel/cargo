<?php
require_once "../auth/auth.php";
require_once "../model/getCargoStatusModel.php";

if (isset($_GET['get']) && ($decoded['role'] == "Admin" || "Stok" || "Satın")){

    $order =getOrderStatus($_GET['get']);
    $data = array('order' => $order);
    header("Content-Type: application/json");
    echo json_encode($data);
    exit();
  }



?>