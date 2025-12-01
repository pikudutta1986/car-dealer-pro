<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../../config/index.php');
include('../class/Cars.php');

$cars = new Cars($dbObject);

// Initialize an empty array to store the month names
$months = [];
$carSaleTotal = [];
$carProfitTotal = [];

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
	
	$query = "SELECT SUM(sale_price) AS sale_price, SUM(owner_price) AS owner_price FROM cars_sale WHERE DATE(saledate) BETWEEN :start AND :end";
	$stmt = $dbObject->prepare($query);
	$stmt->execute([':start' => $startOfMonth, ':end' => $endOfMonth]);
	$salerow = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$carSaleTotal[] = $salerow['sale_price'];
	
	$profit = $salerow['sale_price']-$salerow['owner_price'];
	
	if($profit < 0)
	{
		$profit = 0;
	}
	
	$carProfitTotal[] = $profit;

	
}

$response = array('months'=>array_reverse($months), 'carSaleTotal'=>array_reverse($carSaleTotal), 'carProfitTotal'=>array_reverse($carProfitTotal));

http_response_code(201);
echo json_encode($response);
?>