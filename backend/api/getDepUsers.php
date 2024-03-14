<?php
require_once "../auth/auth.php";
require_once "../model/getDepUsersModel.php";

if (isset($_GET['get']) && ($decoded['role'] == "Admin" || "Satın")){

    $list =getUserList($_GET['get']);
    header("Content-Type: application/json");
    echo json_encode($list);
    exit();
  }

?>