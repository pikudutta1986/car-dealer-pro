<?php
	include('../../config/index.php');
	include('../class/Cars.php');
	include('../class/User.php');
	
	$cars = new Cars($dbObject);
	$user = new User($dbObject);
	
	$response = array(
    'success' => false,
    'message' => ''
	);
	
// Error reporting disabled for production
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
	
	$fileName = $_POST['fileName'];
	
	if ($fileName != '') {
		$result = $user->deleteHomepageBannerImage();
		$imagePath = '../../uploaded-images/' . $fileName;
		
		if (file_exists($imagePath)) {
			if (unlink($imagePath)) {
				
				
				$response['data'] = $result;
				$response['success'] = true;
				$response['message'] = 'Image deleted successfully.';
				http_response_code(201);
				echo json_encode($response);
				
				} else {
				http_response_code(500);
				echo json_encode(['error' => 'Failed to delete the image file.']);
			}
			} else {
			http_response_code(404);
			echo json_encode(['error' => 'Image file not found.']);
		}
		} else {
		http_response_code(400);
		echo json_encode(['error' => 'FileName parameters are required.']);
	}
?>
