<?php
include('../../config/index.php');
include('../class/Cars.php');

try {
	$cars = new Cars($dbObject);

	$response = array(
		'success' => false,
		'message' => ''
	);

	$vin = $_POST['vin'];
	$fileName = $_POST['fileName'];

	if ($vin != '' && $fileName != '') {
		try {
			$result = $cars->deleteCarImages($_POST);
			$imagePath = '../../uploaded-images/car-images/' . $vin . '/' . $fileName;

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
		} catch (Exception $e) {
			error_log("Error deleting car image: " . $e->getMessage());
			http_response_code(500);
			echo json_encode(['error' => 'Database error occurred while deleting image.']);
		}
	} else {
		http_response_code(400);
		echo json_encode(['error' => 'VIN and fileName parameters are required.']);
	}
} catch (Exception $e) {
	error_log("Error in delete_image.php: " . $e->getMessage());
	http_response_code(500);
	echo json_encode(['error' => 'An error occurred while processing the request.']);
}
?>
