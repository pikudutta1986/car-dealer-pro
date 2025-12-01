<?php 
// CORS headers for AJAX requests
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../../config/index.php');
include('../class/Page.php');

// Error reporting disabled for production
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

try {
	$page = new Page($dbObject);

	$response = $page->insertIntoPage($_REQUEST);
	http_response_code(201);
	echo json_encode($response);
} catch (Exception $e) {
	error_log("Error in addedit_page.php: " . $e->getMessage());
	http_response_code(500);
	echo json_encode(['success' => false, 'message' => 'An error occurred while processing the request.']);
}
?>