<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../../config/index.php');
include('../class/Cars.php');

try {
	$cars = new Cars($dbObject);

	// Initialize arrays for chart data
	$months = [];
	$carSaleCount = [];

	// Loop through the last 6 months
	for ($i = 0; $i < 6; $i++) {
		// Get the current date, then modify it by subtracting months
		$date = new DateTime();
		$date->modify("-$i month");

		// Get the month name and extract the first 3 characters
		$monthName = $date->format('F'); // Full month name
		$months[] = substr($monthName, 0, 3); // Take first 3 characters
		
		// Get the first day of the month (start date)
		$startOfMonth = $date->modify('first day of this month')->format('Y-m-d');

		// Get the last day of the month (end date)
		$endOfMonth = $date->modify('last day of this month')->format('Y-m-d');
		
		try {
			$query = "SELECT COUNT(*) AS totalSales FROM cars_sale WHERE DATE(saledate) BETWEEN :start AND :end";
			$stmt = $dbObject->prepare($query);
			$stmt->execute([':start' => $startOfMonth, ':end' => $endOfMonth]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
			$carSaleCount[] = $row['totalSales'];
		} catch (PDOException $e) {
			error_log("Error fetching chart sale data for month: " . $e->getMessage());
			$carSaleCount[] = 0; // Default to 0 if query fails
		}
	}

	$response = array('months'=>array_reverse($months), 'carsCount'=>array_reverse($carSaleCount));

	http_response_code(201);
	echo json_encode($response);
} catch (Exception $e) {
	error_log("Error in chart_sale_data.php: " . $e->getMessage());
	http_response_code(500);
	echo json_encode(['error' => 'An error occurred while fetching chart data.']);
}
?>
