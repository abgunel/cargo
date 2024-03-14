<?php
require_once "../auth/auth.php";
require_once "../model/getFirmModel.php";

if (isset($_GET['get']) && ($decoded['role'] == "Admin" || "Stok" || "Satın")){

    $firm =getFirm();
    header("Content-Type: application/json");
    echo json_encode($firm);
    exit();
  }
?>