<?php
class Seo{
	// Connection instance
	private $connection;

	public $meta_title = "";
	public $meta_keywords = "";
	public $meta_description = "";
	public $schema = "";

	// Db connection
	public function __construct($connection)
	{
		$this->connection = $connection;
	}
	
	public function slugify($text)
	{
		if ($text != '') {
			
			$utf8 = array(
			'/[áàâãªä]/u'   =>   'a',
			'/[ÁÀÂÃÄ]/u'    =>   'A',
			'/[ÍÌÎÏ]/u'     =>   'I',
			'/[íìîï]/u'     =>   'i',
			'/[éèêë]/u'     =>   'e',
			'/[ÉÈÊË]/u'     =>   'E',
			'/[óòôõºö]/u'   =>   'o',
			'/[ÓÒÔÕÖ]/u'    =>   'O',
			'/[úùûü]/u'     =>   'u',
			'/[ÚÙÛÜ]/u'     =>   'U',
			'/ç/'           =>   'c',
			'/Ç/'           =>   'C',
			'/ñ/'           =>   'n',
			'/Ñ/'           =>   'N',
			'/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
			'/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
			'/[“”«»„]/u'    =>   ' ', // Double quote
			'/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
			);
			$text = preg_replace(array_keys($utf8), array_values($utf8), $text);
			$text = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text)));
			
			return $text;
			} else {
			return $text;
		}
	}

	function getpageDetailsBySlug($slug)
	{
		try {
			$sql = "SELECT * FROM page WHERE slug = :slug";
			$query = $this->connection->prepare($sql);
			$query->execute([':slug' => $slug]);
			$row = $query->fetch(PDO::FETCH_ASSOC);
			return $row;
		} catch (PDOException $e) {
			error_log("Error in getpageDetailsBySlug: " . $e->getMessage());
			return false;
		}
	}

	public function getCarDetailsByvinid($vin)
	{
		try {
			$sqlString = 'SELECT c.*, cmake.make, cmodel.model, cb.bodystyle FROM cars_listings c 
			JOIN cars_make cmake ON c.make_id=cmake.make_id
			JOIN cars_model cmodel ON c.model_id=cmodel.model_id
			JOIN cars_bodystyle cb ON c.bodystyle_id=cb.bodystyle_id WHERE c.vin = :vin';
			$listtmt = $this->connection->prepare($sqlString);
			$listtmt->execute([':vin' => $vin]);
			$listRow = $listtmt->fetch(PDO::FETCH_ASSOC);
			
			if ($listRow) {
				//GET CAR IMAGES
				$imageRows = $this->getImagesByVin($listRow['vin']);
				$imageNames = [];
				foreach ($imageRows as $row) {
					$imageNames[] = $row['imagename'];
				}
				$listRow['images'] = implode('|', $imageNames);
				$listRow['owner_info'] = $this->getCarUserById($listRow['owner_id']);
				return $listRow;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			error_log("Error in getCarDetailsByvinid: " . $e->getMessage());
			return false;
		}
	}

	public function getCarUserById($id)
	{
		try {
			$query = "SELECT * FROM users WHERE user_id = :id";
			$stmt = $this->connection->prepare($query);
			$stmt->execute([':id' => $id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			return $row;
		} catch (PDOException $e) {
			error_log("Error in getCarUserById: " . $e->getMessage());
			return false;
		}
	}

	// GET IMAGES BY PARAM VIN.
	public function getImagesByVin($vin)
	{
		try {
			$sql = 'SELECT * FROM cars_images WHERE vin = :vin ORDER BY imageorder';
			$stmt = $this->connection->prepare($sql);
			$stmt->execute([':vin' => $vin]);
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			return $rows;
		} catch (PDOException $e) {
			error_log("Error in getImagesByVin: " . $e->getMessage());
			return array();
		}
	}
	
	function seoCurrentPageMeta($SITE_URL, $SITE_INFO)
	{
		// META DATA FOR HOME PAGE
		if ($_REQUEST['mod'] == 'home') {
			$this->meta_title = $SITE_INFO['businessname'] . " - Buy cars in ".$SITE_INFO['city'];
			$this->meta_description = "Buy cars in ".$SITE_INFO['city']." at affordable price.";
			$this->meta_keywords = "Buy cars in ".$SITE_INFO['city'].", Buy cars at checp price, Buy used cars";
			$this->schema = "";
		}

		// META DATA FOR CR LIST PAGE
		if ($_REQUEST['mod'] == 'search') {

			$seachString = '';

			foreach (['make', 'model', 'body_style'] as $key) {
				if (!empty($_REQUEST[$key])) {
					$seachString .= ucfirst($_REQUEST[$key]) . ' ';
				}
			}

			if ($seachString !== '') {
				$seachString .= '- ';
			}

			$title = $seachString.$SITE_INFO['businessname'] . " - Buy cars in ".$SITE_INFO['city'];
			$description =  $seachString."Buy cars in ".$SITE_INFO['city']." at affordable price.";
			$keywords = $seachString."Buy cars in ".$SITE_INFO['city'].", Buy cars at checp price, Buy used cars";

			$this->meta_title = $title;
			$this->meta_description = $description;
			$this->meta_keywords = $keywords;
			$this->schema = "";
		}

		// META DATA FOR CAR DETAILS PAGE
		if ($_REQUEST['mod'] == 'details') {

			$carsData = $this->getCarDetailsByvinid($_GET['vin']);

			$carName = $carsData['year'].' '.$carsData['make'].' '.$carsData['model'];

			$this->meta_title = $carName." - ".$SITE_INFO['businessname'] . " - Buy cars in ".$SITE_INFO['city'];
			$this->meta_description = $carName." - Buy cars in ".$SITE_INFO['city']." at affordable price.";
			$this->meta_keywords = $carName." - Buy cars in ".$SITE_INFO['city'].", Buy cars at checp price, Buy used cars";

			$images = explode('|', $carsData['images']);

			// Build dynamic images array for JSON-LD
			$imageJson = '';
			if (!empty($images) && is_array($images)) {
				$escaped = array_map(function($img) use ($SITE_URL, $carsData) {
					return '"' . $SITE_URL . '/uploaded-images/car-images/' . $carsData['vin'] . '/' . htmlspecialchars($img, ENT_QUOTES) . '"';
				}, $images);

				// Join with newline and indentation
				$imageJson = implode(",\n    ", $escaped);
			}

			$this->schema = '
			<script type="application/ld+json">
			{
				"@context": "https://schema.org",
				"@type": "Car",
				"name": "'.htmlspecialchars($carName).'",
				"image": [
					'.$imageJson.'
				],
				"description": "Well-maintained '.htmlspecialchars($carsData['year'].' '.$carsData['make'].' '.$carsData['model']).' with low mileage, automatic transmission, and advanced safety features.",
				"brand": {
					"@type": "Brand",
					"name": "'.htmlspecialchars($carsData['make']).'"
				},
				"model": "'.htmlspecialchars($carsData['model']).'",
				"vehicleModelDate": "'.htmlspecialchars($carsData['year']).'",
				"vehicleIdentificationNumber": "'.htmlspecialchars($carsData['vin']).'",
				"mileageFromOdometer": {
					"@type": "QuantitativeValue",
					"value": "'.htmlspecialchars($carsData['mileage']).'",
					"unitCode": "KMT"
				},
				"fuelType": "'.htmlspecialchars($carsData['fuel_type']).'",
				"vehicleTransmission": "'.htmlspecialchars($carsData['transmission']).'",
				"bodyType": "'.htmlspecialchars($carsData['bodystyle']).'",
				"color": "'.htmlspecialchars($carsData['color']).'",
				"seatingCapacity": "'.htmlspecialchars($carsData['seating_capacity']).'",
				"additionalProperty": {
					"@type": "PropertyValue",
					"name": "Airbags",
					"value": "'.htmlspecialchars($carsData['airbags']).'"
				},
				"offers": {
					"@type": "Offer",
					"url": "'.$SITE_URL.'/car-details/'.urlencode($carsData['year'].'-'.$carsData['make'].'-'.$carsData['model']).'/'.$carsData['vin'].'",
					"priceCurrency": "INR",
					"price": "'.htmlspecialchars($carsData['website_price']).'",
					"itemCondition": "https://schema.org/UsedCondition",
					"availability": "https://schema.org/InStock",
					"seller": {
						"@type": "Organization",
						"name": "'.htmlspecialchars($SITE_INFO['businessname']).'",
						"url": "'.$SITE_URL.'",
						"logo": "'.$SITE_URL.'/assets/images/logo.png",
						"contactPoint": {
							"@type": "ContactPoint",
							"telephone": "'.htmlspecialchars($carsData['owner_info']['phone']).'",
							"contactType": "sales",
							"areaServed": "IN",
							"availableLanguage": ["English"]
						},
						"address": {
							"@type": "PostalAddress",
							"streetAddress": "",
							"addressLocality": "",
							"addressRegion": "",
							"postalCode": "",
							"addressCountry": "IN"
						}
					}
				},
				"mainEntityOfPage": {
					"@type": "WebPage",
					"@id": "'.$SITE_URL.'/car-details/'.urlencode($carsData['year'].'-'.$carsData['make'].'-'.$carsData['model']).'/'.$carsData['vin'].'"
				}
			}
			</script>';
		}

		// META DATA FOR STATIC PAGE
		if ($_REQUEST['mod'] == 'static') {
			$pagedata = $this->getpageDetailsBySlug($_REQUEST['slug']);
			$this->meta_title = $pagedata['title']." - ".$SITE_INFO['businessname'] . " - Buy cars in ".$SITE_INFO['city'];
			$this->meta_description =  $pagedata['title']." - Buy cars in ".$SITE_INFO['city']." at affordable price.";
			$this->meta_keywords = $pagedata['title']." - Buy cars in ".$SITE_INFO['city'].", Buy cars at checp price, Buy used cars";
			$this->schema = "";
		}

		// META DATA FOR REGISTER PAGE
		if ($_REQUEST['mod'] == 'register') {
			$this->meta_title = 'Car Dealer Registration Online';
			$this->meta_description =  "Become a online car dealer. Reach million of users.";
			$this->meta_keywords = '';
		}

		// META DATA FOR 404 PAGE
		if ($_REQUEST['mod'] == 'notfound') {
			$this->meta_title = "Page not found | ".$SITE_INFO['businessname'] . " - Buy cars in ".$SITE_INFO['city'];
			$this->meta_description = "Buy cars in ".$SITE_INFO['city']." at affordable price.";
			$this->meta_keywords = "Buy cars in ".$SITE_INFO['city'].", Buy cars at checp price, Buy used cars";
			$this->schema = "";
		}
	}
	
}	