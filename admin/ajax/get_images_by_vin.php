<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../../config/index.php');
include('../class/Cars.php');

try {
	$cars = new Cars($dbObject);

	$vin = $_POST['vin'];

	$response = $cars->getImagesByVin($vin);
	http_response_code(201);
	echo json_encode($response);
} catch (Exception $e) {
	error_log("Error in get_images_by_vin.php: " . $e->getMessage());
	http_response_code(500);
	echo json_encode(['error' => 'An error occurred while fetching images.']);
}
?>