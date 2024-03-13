<?php
require_once "../auth/auth.php";
require_once "../model/postOrderTableModel.php";
$data = json_decode(file_get_contents('php://input'), true);


if (isset($_GET['add']) && ($decoded['role'] == "Admin" || "Formen" || "Satın")){
    $result= insert($_POST);
  
    if ($result){
      $res = array('res' => 'success');
    }else{
      $res = array('res' => 'error');
    }
  
    echo json_encode($res);
  }

?>