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

	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
	{
		$name    = htmlspecialchars($_POST['name'] ?? '');
		$email   = htmlspecialchars($_POST['email'] ?? '');
		$subject = htmlspecialchars($_POST['subject'] ?? '');
		$message = htmlspecialchars($_POST['message'] ?? '');

		if (!$name || !$email || !$subject || !$message) {
			echo "All fields are required.";
			exit;
		}
		// EMAIL TO SITE OWNER FROM CONTACT FORM
		$emailResult = $mailClass->sentContactMail($_POST);
		if ($emailResult['success']) {
			http_response_code(200);
			echo json_encode($emailResult);
		} else {
			http_response_code(500);
			echo json_encode($emailResult);
		}
	}
} catch (Exception $e) {
	error_log("Error in send_mail.php: " . $e->getMessage());
	echo "An error occurred while sending the email.";
}
?>