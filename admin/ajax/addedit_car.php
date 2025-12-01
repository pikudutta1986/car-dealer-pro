<?php 
// CORS headers for AJAX requests
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../../config/index.php');
include('../class/Cars.php');
include('../../class/MailClass.php');

try {
	$cars = new Cars($dbObject);
	$mailClass = new MailClass($dbObject, $SITE_NAME, $SITE_LOGO);

	// Normalize request data to ensure all expected fields exist (for PHP 8+ compatibility)
	$normalizedData = $_REQUEST;
	$expectedFields = [
		'vin', 'carcondition', 'make_id', 'model_id', 'bodystyle_id', 'fuel_type', 'year', 'website_price',
		'name', 'email', 'phone', 'owner_price', 'address',
		'varient', 'mileage', 'transmission', 'max_power', 'color', 'engine',
		'boot_space', 'ground_clearance', 'details', 'features',
		'cylinders', 'max_torque', 'seating_capacity', 'airbags'
	];
	
	foreach ($expectedFields as $field) {
		if (!isset($normalizedData[$field])) {
			$normalizedData[$field] = '';
		}
	}

	$response = $cars->insertIntoListings($normalizedData);

	// FOR NEW CAR SEND EMAIL TO THE OWNER ON CAR ADDED
	if (!isset($normalizedData['id']) && $response['success'] == true && $normalizedData['email'] != '') 
	{
		try {
			$emailResult = $mailClass->sentMailtoCarAdd($normalizedData['name'], $normalizedData['email']);
			if ($emailResult['success']) {
				$response['mailsent'] = true;
			} else {
				$response['mailsent'] = false;
				$response['message'] = $emailResult['message'];
			}
		} catch (Exception $e) {
			error_log("Error sending car add email: " . $e->getMessage());
			$response['mailsent'] = false;
		}
	}
	http_response_code(201);
	echo json_encode($response);
} catch (Exception $e) {
	error_log("Error in addedit_car.php: " . $e->getMessage());
	error_log("Stack trace: " . $e->getTraceAsString());
	http_response_code(500);
	echo json_encode(['success' => false, 'message' => 'An error occurred while processing the request: ' . $e->getMessage()]);
}
?>