<?php
require_once "../auth/auth.php";
require_once "../model/getOrderModel.php";

if (isset($_GET['get']) && ($decoded['role'] == "Admin" || "Formen" || "Satın")){

    $order =getOrder($_GET['get']);
    $data = array('order' => $order);
    header("Content-Type: application/json");
    echo json_encode($data);
    exit();
  }



?>