<?php
require_once "../auth/auth.php";
require_once "../model/removeOrderModel.php";
$data = json_decode(file_get_contents('php://input'), true);

if (isset($_GET['remove']) && ($decoded['role'] == "Admin" || "Formen" || "Satın")){
    $result= remove($_GET['remove']);
  
    if ($result){
      $res = array('res' => 'success');
    }else{
      $res = array('res' => 'error');
    }
  
    echo json_encode($res);
  }

?>