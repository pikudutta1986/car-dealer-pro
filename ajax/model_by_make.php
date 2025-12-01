<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../config/index.php');
include('../class/Cars.php');


$cars = new Cars($dbObject);

$make_slug = $_GET['make_slug'];
$response = $cars->getActiveModelByMakeSlug($make_slug);
http_response_code(201);
echo json_encode($response);
?>