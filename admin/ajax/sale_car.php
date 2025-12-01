<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../../config/index.php');
include('../class/Cars.php');
include('../../class/MailClass.php');

try {
	$cars = new Cars($dbObject);
	$mailClass = new MailClass($dbObject, $SITE_NAME, $SITE_LOGO);

	$response = $cars->insertIntoSale($_REQUEST);
	if ($response['success'] == true) 
	{
		if ($response['owner_id'] != '' && $response['vin'] != '')
		{
			try {
				// SEND EMAIL TO THE CAR OWNER
				$emailResult = $mailClass->sentMailtoOwnerOnCarSale($response['owner_id'], $response['vin']);
				if ($emailResult['success']) {
					$response['mailsent'] = true;
				} else {
					$response['mailsent'] = false;
					$response['message'] = $emailResult['message'];
				}
			} catch (Exception $e) {
				error_log("Error sending email to owner: " . $e->getMessage());
			}
		}

		if ($response['buyer_id'] != '' && $response['vin'] != '')
		{
			try {
				// SEND EMAIL TO THE BUYER
				$emailResult = $mailClass->sentMailtoBuyerOnCarSale($response['buyer_id'], $response['vin']);
				if ($emailResult['success']) {
					$response['mailsent'] = true;
				} else {
					$response['mailsent'] = false;
					$response['message'] = $emailResult['message'];
				}
			} catch (Exception $e) {
				error_log("Error sending email to buyer: " . $e->getMessage());
			}
		}
	}
	http_response_code(201);
	echo json_encode($response);
} catch (Exception $e) {
	error_log("Error in sale_car.php: " . $e->getMessage());
	http_response_code(500);
	echo json_encode(['success' => false, 'message' => 'An error occurred while processing the sale.']);
}
?>