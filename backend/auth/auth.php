<?php
require("../vendor/autoload.php");
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use UnexpectedValueException;
/*
$headers = apache_request_headers();

if (isset($headers['Authorization']))
{}
  $token = str_ireplace('Bearer', '', $headers['Authorization']);
*/

$key = '-GKXVpjD9V{|e`j8sO^O|8@mm=;AGez,K3{^MET1?Vq$,?rqn;?qr]PUKGT4>|T';
$headers = apache_request_headers();
$token = trim(str_ireplace('Bearer', '', $headers['Authorization']));
//$token = trim($token);
//echo json_encode($token);
try{    
  $decoded = JWT::decode($token,new Key($key, 'HS256'));
  $decoded = json_decode(json_encode($decoded), true);
  }catch (LogicException $e){
    exit("$e");
  } catch (UnexpectedValueException $e){
    exit("$e");
  }
    
  
/*
else{
  return false;
}
*/
?>