<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../../config/index.php');
include('../class/User.php');

try {
	$userObj = new User($dbObject);

	$response = $userObj->saveSocialLinks($_REQUEST);
	http_response_code(201);
	echo json_encode($response);
} catch (Exception $e) {
	error_log("Error in save_social_links.php: " . $e->getMessage());
	http_response_code(500);
	echo json_encode(['success' => false, 'message' => 'An error occurred while processing the request.']);
}
?>