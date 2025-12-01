<?php 
session_start();
include("../config/index.php");
header("Location: ".$SITE_URL."/admin/login.php");
die();
