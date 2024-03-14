<?php
require_once "../auth/auth.php";
require_once "../model/getConfirmOrderTableModel.php";

if (isset($_GET['get']) && ($decoded['role'] == "Admin" || "Satın" || "Stok")){
  
    $table =getConfirmOrderTable();
  }

if(isset($_GET['get']) && ($decoded['role'] == "Formen")){

  $table = getFormenConfirmOrderTable($decoded['id']);
}

$data = array('table' => $table);
header("Content-Type: application/json");
echo json_encode($data);
exit();
?>