<?php
session_start();
include("../config/index.php");
if($_SESSION['username'] =='')
{
    header("Location: ".$SITE_URL."/admin/login.php");
    die();
}

$carsSql = 'SELECT * FROM cars_listings WHERE id = :id';
$carsStmt = $dbObject->prepare($carsSql);
$carsStmt->execute([':id' => $_REQUEST['id']]);
$carRow = $carsStmt->fetch(PDO::FETCH_ASSOC);

if ($carRow) {
    $vin = $carRow['vin'];

    $uploadDir = "./uploaded-images/car-images/$vin/";
    if (is_dir($uploadDir)) {
        $images = glob($uploadDir . "*");
        foreach ($images as $image) {
            if (is_file($image)) {
                unlink($image);
            }
        }
        rmdir($uploadDir);
    }

    $deleteImagesSql = 'DELETE FROM cars_images WHERE vin = :vin';
    $deleteImagesStmt = $dbObject->prepare($deleteImagesSql);
    $deleteImagesStmt->execute([':vin' => $carRow['vin']]);

    $deleteSql = 'DELETE FROM cars_listings WHERE id = :id';
    $deleteStmt = $dbObject->prepare($deleteSql);
    $deleteResult = $deleteStmt->execute([':id' => $_REQUEST['id']]);
}

header("Location: ".$SITE_URL."/admin/cars.php");
exit();

