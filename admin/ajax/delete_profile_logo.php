<?php
include('../../config/index.php');
include('../class/Cars.php');


$cars = new Cars($dbObject);

$response = array(
    'success' => false,
    'message' => ''
);

$fileName = $_POST['fileName'];

if ($fileName != '') {
    $result = $cars->deleteProfileLogo($_POST);
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
