<?php 
try {
	// INCLUDE THE GLOBAL DATA AND DATABASE
	include('./config/index.php');

	// INCLUDE ALL THE CLASS GLOBALLY
	include('./class/Cars.php');
	include('./class/Page.php');
	include('./class/Seo.php');

	// CREATE THE OBJECT OF THE CLASS
	$carsClassObject = new Cars($dbObject);

	// CREATE THE OBJECT OF THE CLASS
	$pageClassObject = new Page($dbObject);

	// CREATE THE OBJECT OF THE CLASS
	$seoClassObject = new Seo($dbObject);

	// ROUTING DEFAULTS
	if (!isset($_REQUEST['mod']) || $_REQUEST['mod'] === '') {
		$_REQUEST['mod'] = 'home';
	}

	// GET THE GLOBAL DATA 
	try {
		$globalCarMakes = $carsClassObject->getActiveMake();
		$lowestCar = $carsClassObject->getLowestPriceCar();
		$highestCar = $carsClassObject->getHighestPriceCar();
	} catch (Exception $e) {
		error_log("Error loading global car data: " . $e->getMessage());
		$globalCarMakes = array();
		$lowestCar = false;
		$highestCar = false;
	}

	// SET THE SEO DATA
	try {
		$seoClassObject->seoCurrentPageMeta($SITE_URL, $SITE_INFO);
	} catch (Exception $e) {
		error_log("Error setting SEO data: " . $e->getMessage());
	}

	// INCLUDE THE THEME INDEX
	include('./theme-template/'.$ACTIVE_THEME.'/index.php');
} catch (Exception $e) {
	error_log("Critical error in index.php: " . $e->getMessage());
	// Display a user-friendly error page
	echo '<!DOCTYPE html>
	<html>
	<head>
		<title>Error - ' . $SITE_NAME . '</title>
		<style>
			body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
			.error-container { max-width: 600px; margin: 0 auto; }
			h1 { color: #dc3545; }
			p { color: #666; }
		</style>
	</head>
	<body>
		<div class="error-container">
			<h1>Something went wrong</h1>
			<p>We apologize for the inconvenience. Our team has been notified and is working to fix this issue.</p>
			<p>Please try again later or contact support if the problem persists.</p>
		</div>
	</body>
	</html>';
}