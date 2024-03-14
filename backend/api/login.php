<?php
require_once "../model/loginModel.php";

$data = json_decode(file_get_contents('php://input'), true);


if (isset($_POST)){
    $result= login($data);
    header("Content-Type: application/json");
    echo json_encode($result);
    exit();
}
?>