<?php
require_once "../auth/auth.php";
require_once "../model/getDepModel.php";

if (isset($_GET['get']) && ($decoded['role'] == "Admin" || "Formen" || "Satın")){

    $dep =getDep();
    //$data = array($dep);
    header("Content-Type: application/json");
    echo json_encode($dep);
    exit();
  }
?>