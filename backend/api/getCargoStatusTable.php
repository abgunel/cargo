<?php
require_once "../auth/auth.php";
require_once "../model/getCargoStatusTableModel.php";

if (isset($_GET['get']) && ($decoded['role'] == "Admin" || "Satın" || "Stok")){
  
    $table =getCargoStatusTable();
  }

if(isset($_GET['get']) && ($decoded['role'] == "Formen")){

  $table = getFormenCargoStatusTable($decoded['id']);
}

$data = array('table' => $table);
header("Content-Type: application/json");
echo json_encode($data);
exit();
?>