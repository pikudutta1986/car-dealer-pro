<?php 
include('../../config/index.php');
include('../class/Cars.php');

try {
	$cars = new Cars($dbObject);
	
	
	// Error reporting disabled for production
	// error_reporting(E_ALL);
	// ini_set('display_errors', 1);
	
	$uploadDirRootParent = $SITE_ROOT.'uploaded-images/';
	
	if (!is_dir($uploadDirRootParent)) {
		mkdir($uploadDirRootParent, 0777, true);
	}
	
	$uploadDir =  $SITE_ROOT.'uploaded-images/make-images';
	if (!is_dir($uploadDir)) {
		mkdir($uploadDir, 0777, true);
	}
	
	$response = array(
		'success' => false,
		'message' => ''
	);
	
	$imgSrc = $_POST['imgSrc'];
	$fileName = $_POST['fileName'];
	
	
	$imgDataArray = explode(',', $imgSrc);
	
	if (count($imgDataArray) == 2) {
		$imageData = base64_decode($imgDataArray[1]); 
		
		if ($imageData === false) {
			$response['success'] = false;
			$response['message'] = 'Invalid base64 encoding.';
			http_response_code(400);
			echo json_encode($response);
			exit;
		}
		
		$imageType = null;
		if (strpos($imgDataArray[0], 'image/svg+xml') !== 0) {
			$imageType = 'svg';
		} else {
			if (preg_match('/^data:image\/(\w+);base64/', $imgDataArray[0], $matches)) {
				$imageType = strtolower($matches[1]);
			}
		}
		
		if ($imageType !== null) {
			$filePath = $uploadDir . '/' . $fileName;
			
			if (file_put_contents($filePath, $imageData)) {
				$response['imagename'] = $fileName;
				$response['success'] = true;
				$response['message'] = 'Image uploaded successfully.';
				http_response_code(201);
				echo json_encode($response); 
			} else {
				http_response_code(500);
				echo json_encode(['error' => 'Failed to save the file.']);
			}
		} else {
			http_response_code(400);
			echo json_encode(['error' => 'Unsupported image format or invalid data URL.']);
		}
	} else {
		http_response_code(400);
		echo json_encode(['error' => 'Invalid image data URL format.']);
	}
} catch (Exception $e) {
	error_log("Error in upload_make_image.php: " . $e->getMessage());
	http_response_code(500);
	echo json_encode(['error' => 'An error occurred while processing the request.']);
}

?>