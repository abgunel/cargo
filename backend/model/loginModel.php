<?php
require_once "../config/database.php";
require_once "../auth/createToken.php";

function login($recieve){
    $id = $recieve['id'];
    $pass = $recieve['pass'];
    $data = [];
    $database = new Database();
    $db = $database->connection();

    $stmt = $db->prepare("SELECT usr.Id, usr.Name, usr.DepId, usr.Password, rol.RoleName FROM users as usr left JOIN role as rol ON usr.RoleId = rol.RoleId WHERE usr.Name = '$id'");
    //$stmt = $db->prepare("SELECT * FROM `users` WHERE `Name`= '$id'");
    //$stmt = $db->prepare("SELECT `users.Name`, `users.Password`, `role.RoleName`  FROM `users` INNER JOIN `role` ON `users.RoleId` = `role.RoleId` WHERE `users.Name`= '$id'");
    //$stmt = $db->prepare("SELECT *  FROM `users` INNER JOIN `role` ON `users.RoleId`=`role.RoleId` WHERE `Name`= '$id'");
    if ($stmt->execute()){
      $data = $stmt->fetch(PDO::FETCH_ASSOC);
      if($data != null){
        if($data['Name']==$id && $data['Password']==$pass ){
          $token = createToken($id, $data['RoleName'], $data['DepId'],$data['Id'] );
          
          $data = array('id' => $id, 'token' => $token, 'role'=> $data['RoleName'], 'depId'=>$data['DepId'], 'idno' =>$data['Id']);
          return $data;
        }
      }else{return null;}

    }else{return null;}


}

?>