<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../../config/index.php');
include('../class/Page.php');

// Error reporting disabled for production
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

$page = new Page($dbObject);


$response = $page->deletePageByid($_REQUEST);
http_response_code(201);
echo json_encode($response);
?>