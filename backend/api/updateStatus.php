<?php
require_once "../auth/auth.php";
require_once "../model/updateStatusModel.php";
$data = json_decode(file_get_contents('php://input'), true);

if (isset($_GET['update']) && ($decoded['role'] == "Admin" || "Stok" || "Satın")){
    $result= update($_POST);
  
    if ($result){
      $res = array('res' => 'success');
    }else{
      $res = array('res' => 'error');
    }
  
    echo json_encode($res);
  }

?>