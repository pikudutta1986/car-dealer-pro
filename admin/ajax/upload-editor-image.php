<?php
include('../../config/index.php');
include('../class/Cars.php');	

try {
	$uploadDirRootParent = $SITE_ROOT.'uploaded-images';
	
	if (!is_dir($uploadDirRootParent)) {
		mkdir($uploadDirRootParent, 0777, true);
	}

	$targetDir = $SITE_ROOT.'uploaded-images/editor-images';

	if (!is_dir($targetDir)) {
		mkdir($targetDir, 0777, true);
	}


	if (!isset($_FILES['file']) || $_FILES['file']['error'] != 0) {
		http_response_code(400);
		echo json_encode(['error' => 'Image upload failed.']);
		exit;
	}

	$uploadedFile = $_FILES['file'];
	$ext = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
	$allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

	if (!in_array(strtolower($ext), $allowed)) {
		http_response_code(400);
		echo json_encode(['error' => 'Invalid file type.']);
		exit;
	}

	$filename = uniqid() . '.' . $ext;
	$filepath = $targetDir .'/'. $filename;

	if (!move_uploaded_file($uploadedFile['tmp_name'], $filepath)) {
		http_response_code(500);
		echo json_encode(['error' => 'Failed to move uploaded file.']);
		exit;
	}

	$orginalFilePath = $SITE_URL.'/uploaded-images/editor-images/'.$filename;


	// Respond with image URL
	echo json_encode(['location' => $orginalFilePath]);
} catch (Exception $e) {
	error_log("Error in upload-editor-image.php: " . $e->getMessage());
	http_response_code(500);
	echo json_encode(['error' => 'An error occurred while processing the request.']);
}
?>
