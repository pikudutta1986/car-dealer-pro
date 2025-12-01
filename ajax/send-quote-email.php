<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../config/index.php');
include('../class/Cars.php');
include('../class/MailClass.php');

try {
	$cars = new Cars($dbObject);
	$mailClass = new MailClass($dbObject, $SITE_NAME, $SITE_LOGO);

	$response = $cars->insertIntoLead($_POST);

	if($response) {
		try {
			$emailResult = $mailClass->sentLeadMail($_POST);
			if ($emailResult['success']) {
				http_response_code(200);
				echo json_encode($emailResult);
			} else {
				http_response_code(500);
				echo json_encode($emailResult);
			}
		} catch (Exception $e) {
			error_log("Error sending lead email: " . $e->getMessage());
			http_response_code(500);
			echo json_encode(['success' => false, 'message' => 'Error sending lead email: ' . $e->getMessage()]);
		}
	} else {
		http_response_code(500);
		echo "Mail send failed.";
	}
} catch (Exception $e) {
	error_log("Error in send-quote-email.php: " . $e->getMessage());
	http_response_code(500);
	echo "An error occurred while processing the request.";
}