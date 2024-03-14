<?php

require("../vendor/autoload.php");
use Firebase\JWT\JWT;



function createToken($id, $role, $depId, $user)
{

  try
  {
    $key = '-GKXVpjD9V{|e`j8sO^O|8@mm=;AGez,K3{^MET1?Vq$,?rqn;?qr]PUKGT4>|T';
    $issueDate = time();
    $expirationDate = time()*3600; //1 hour
    $payload = array(
      "iss" => "http://localhost",
      "aud" => "http://localhost",
      "iat" => $issueDate,
      "exp" => $expirationDate,
      "id" => $user,
      "role" => $role,
      "depId" => $depId,
      "user" => $id
    );

    $jwtGeneratedToken = JWT::encode($payload, $key, 'HS256');
  
    return [
      'token' => $jwtGeneratedToken,
      'expires' => $expirationDate,
    ];
  }
  catch(PDOException $e){
    echo $e->getMessage();
  }
}

?>