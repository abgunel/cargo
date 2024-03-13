<?php
require_once "../auth/auth.php";
require_once "../model/getOrderTableModel.php";

if (isset($_GET['get']) && ($decoded['role'] == "Admin" || "Satın" || "Stok")){
  
    $table =getOrderTable();
  }

if(isset($_GET['get']) && ($decoded['role'] == "Formen")){

  $table = getFormenOrderTable($decoded['id']);
}

$data = array('table' => $table);
header("Content-Type: application/json");
echo json_encode($data);
exit();
?>