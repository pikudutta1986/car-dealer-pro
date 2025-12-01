<?php
session_start();
include("../config/index.php");
if($_SESSION['username'] =='')
{
    header("Location: ".$SITE_URL."/admin/login.php");
    die();
}

$deleteSql = "UPDATE cars_make SET status='INACTIVE' WHERE make_id = :id";
$stmt = $dbObject->prepare($deleteSql);
$stmt->execute([':id' => $_REQUEST['id']]);


header("Location: ".$SITE_URL."/admin/makes.php");
exit();

