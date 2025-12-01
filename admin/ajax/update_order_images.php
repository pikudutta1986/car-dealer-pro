<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../../config/index.php');
include('../class/Cars.php');


$cars = new Cars($dbObject);

// print_r($_REQUEST);
$vin = $_POST['vin'];
$filesArray = json_decode($_POST['filesArray'], true);
$data = ['vin' => $vin, 'filesArray' => $filesArray];

$response = $cars->updateImagesOrder($data);
http_response_code(201);
echo json_encode($response);
?>