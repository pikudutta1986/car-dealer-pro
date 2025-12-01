<?php 
error_reporting(0);

include("../config/index.php");


if($_SESSION['username'] =='')
{
    header("Location: ".$SITE_URL."/admin/login.php");
    die();
}


include("./class/Cars.php");


$cars = new Cars($dbObject);

$baseURL = $SITE_URL . '/image-uploads';

if(isset($_REQUEST['username'])) {
    $listRows = $cars->getListsDataByUsername($_REQUEST['username']);
}

$itemsArray = array();
foreach($listRows as $item) {
    $itemArray = array();
    $itemArray["username"] = $item['username'];
    if(trim($item["vin"]) != '' || trim($item["vin"]) != null) {
        $itemArray["VIN"] = $item["vin"];
    }
    // echo '<pre>';
    // print_r($item);
    $itemArray["Type"] = 'U';
    $itemArray["Stock"] = $item["stock"];
    $itemArray["Make"] = $item["make"];
    $itemArray["Model"] = $item["model"];
    $itemArray["ModelYear"] = $item["year"];
    $itemArray["Trim"] = $item["trim"];
    $itemArray["BodyStyle"] = $item["bodystyle_name"];
    $itemArray["Mileage"] = $item["mileage"];
    $itemArray["Cylinders"] = $item["engine"];
    $itemArray["FuelType"] = $item["fuel_type"];
    $itemArray["Transmission"] = $item["transmission"];
    $itemArray["Price"] = $item["price"];
    $itemArray["ExteriorColor"] = $item["color"];
    $itemArray["images"] = $cars->createImageUrl($item['images'], $baseURL, $item["vin"]);
    $itemArray["Description"] = str_replace("\r\n", PHP_EOL, $item["details"]);
    $itemArray["Features"] = $item["features"];
    
    $itemsArray[] = $itemArray;
}

// GENERATE THE CSV DATA
$csvData = '';
$csvData .= '"'.implode('","', array_keys($itemsArray[0])) . "\"\t";

foreach ($itemsArray as $row) {
    $csvData .= '"'.implode('","', $row) . "\"\t";
}

echo $csvData;
?>