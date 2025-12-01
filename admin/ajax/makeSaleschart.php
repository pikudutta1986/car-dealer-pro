<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include('../../config/index.php');
include('../class/Cars.php');


$cars = new Cars($dbObject);

$carsSaleMakes = array();
$carsMakes = array();
$sales = array();

function array_find_index(array $array, callable $callback) {
    foreach ($array as $index => $item) {
        if ($callback($item)) {
            return $index;
        }
    }
    return false; // or -1 depending on what you prefer
}

$query = "SELECT cars_listings.id, cars_make.make as make FROM cars_sale 
LEFT JOIN cars_listings ON cars_listings.vin =  cars_sale.vin 
LEFT JOIN cars_make ON cars_listings.make_id = cars_make.make_id";
$stmt = $dbObject->prepare($query);
$stmt->execute();
$salerow = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($salerow as $item)
{
	$index = array_find_index($carsSaleMakes, fn($u) => $u['make'] == $item['make']);
	
	if($index > -1)
	{
		$carsSaleMakes[$index]['count'] = $carsSaleMakes[$index]['count'] + 1;
	}else{
		$arrayPush = array('make' => $item['make'], 'count'=> '1');
		array_push($carsSaleMakes, $arrayPush);
	}
}

usort($carsSaleMakes, function ($a, $b) {
    return $b['count'] <=> $a['count'];
});

foreach($carsSaleMakes as $carsSaleMake)
{
	$carsMakes[] = $carsSaleMake['make'];       // keys
    $sales[] = $carsSaleMake['count'];       // keys
}

$response = array('carsMakes'=>$carsMakes, 'sales'=>$sales);

http_response_code(201);
echo json_encode($response);
?>