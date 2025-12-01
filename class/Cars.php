<?php
class Cars
{
	// Connection instance
	private $connection;
	
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
	
	function displayDate($date)
	{
		return date("M d, Y", strtotime($date));
	}

	// Check if expiration_date column exists
	private function hasExpirationDateColumn()
	{
		try {
			$checkSql = "SHOW COLUMNS FROM cars_listings LIKE 'expiration_date'";
			$checkStmt = $this->connection->prepare($checkSql);
			$checkStmt->execute();
			$result = $checkStmt->fetch(PDO::FETCH_ASSOC);
			return !empty($result);
		} catch (PDOException $e) {
			return false;
		}
	}

	// GET SOCIAL LINKS 
	public function getAllSocialLinks()
	{
		$linkQuery = "SELECT * FROM social_links WHERE 1 ORDER BY id LIMIT 1";
		$linkStmt = $this->connection->prepare($linkQuery);
		$linkStmt->execute();
		$row = $linkStmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	
	public function getActiveMake()
	{
		$query = "SELECT * FROM cars_make WHERE status='ACTIVE' AND make_id IN (SELECT make_id FROM cars_listings WHERE status = 'AVAILABLE') ORDER BY make ASC";
		$stmt = $this->connection->prepare($query);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}
	
	public function getHomePageCars($limit)
	{
		if(!$limit)
		{
			$limit = 8;
		}
		
		$expirationFilter = $this->hasExpirationDateColumn() 
			? "AND (cars.expiration_date IS NULL OR cars.expiration_date >= CURDATE())" 
			: "";
		
		$query = "SELECT *, makes.make AS name, models.model AS model, bodystyle.bodystyle AS bodystyle FROM cars_listings AS cars LEFT JOIN cars_make AS makes ON cars.make_id = makes.make_id LEFT JOIN cars_model AS models ON cars.model_id = models.model_id LEFT JOIN cars_bodystyle AS bodystyle ON cars.bodystyle_id = bodystyle.bodystyle_id WHERE cars.status='AVAILABLE' ".$expirationFilter." ORDER BY id DESC  LIMIT :limit";
		$stmt = $this->connection->prepare($query);
		$stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		for($i=0; $i < sizeof($rows); $i++)
		{
			$queryforImages = "SELECT * FROM cars_images WHERE vin = :vin";
			$stmtImages = $this->connection->prepare($queryforImages);
			$stmtImages->execute([':vin' => $rows[$i]['vin']]);
			$rowsImages = $stmtImages->fetchAll(PDO::FETCH_ASSOC);
			$rows[$i]['carimages'] = $rowsImages;
		}
		return $rows;
	}
	
	public function getSearchCars($param)
	{
		$queryString = '';
		if(isset($param['make']) && $param['make'] != '')
		{
			$queryString .= " AND makes.make_slug = '".$param['make']."'";
		}
		
		if(isset($param['model']) && $param['model'] != '')
		{
			$queryString .= " AND models.model_slug = '".$param['model']."'";
		}
		
		if(isset($param['body_style']) && $param['body_style'] != '')
		{
			$queryString .= " AND bodystyle.slug = '".$param['body_style']."'";
		}
		
		if(isset($param['fuel_type']) && $param['fuel_type'] != '')
		{
			$queryString .= " AND cars.fuel_type = '".$param['fuel_type']."'";
		}
		
		if(isset($param['transmisson']) && $param['transmisson'] != '')
		{
			$queryString .= " AND cars.transmission = '".$param['transmisson']."'";
		}
		
		if(isset($param['mileage']) && $param['mileage'] != '')
		{
			$queryString .= " AND cars.mileage >= '".$param['mileage']."'";
		}
		
		if(isset($param['year']) && $param['year'] != '')
		{
			$queryString .= " AND cars.year >= '".$param['year']."'";
		}
		
		if(isset($param['filterAmount']) && $param['filterAmount'] != '')
		{
			$pariceArray = explode('-',$param['filterAmount']);
			$queryString .= " AND cars.website_price >= ".trim($pariceArray[0])." AND cars.website_price <= ".trim($pariceArray[1]);
		}
		
		// Setup pagination
		$perPage = 12; // Items per page
		
		if(isset($_GET['perPage']))
		{
			$perPage = $_GET['perPage']; 
		}
		
		$orderBy = 'CAST(cars.website_price AS UNSIGNED) ASC';
		
		if(isset($_GET['sort_by']) && $_GET['sort_by'] == 'desc' )
		{
			$orderBy = 'CAST(cars.website_price AS UNSIGNED) DESC';
		}
		
		$page = isset($param['page']) && is_numeric($param['page']) ? (int)$param['page'] : 1;
		$offset = ($page - 1) * $perPage;
		
		$expirationFilter = $this->hasExpirationDateColumn() 
			? "AND (cars.expiration_date IS NULL OR cars.expiration_date >= CURDATE())" 
			: "";
		
		$query = "SELECT cars.id FROM cars_listings AS cars 
		LEFT JOIN cars_make AS makes ON cars.make_id = makes.make_id 
		LEFT JOIN cars_model AS models ON cars.model_id = models.model_id 
		LEFT JOIN cars_bodystyle AS bodystyle ON cars.bodystyle_id = bodystyle.bodystyle_id 
		WHERE cars.status='AVAILABLE' ".$expirationFilter." ".$queryString;
		$stmt = $this->connection->prepare($query);
		$stmt->execute();
		$totalRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$totalPages = ceil(sizeof($totalRows) / $perPage);
		
		
		$query = "SELECT * FROM cars_listings AS cars 
		LEFT JOIN cars_make AS makes ON cars.make_id = makes.make_id 
		LEFT JOIN cars_model AS models ON cars.model_id = models.model_id 
		LEFT JOIN cars_bodystyle AS bodystyle ON cars.bodystyle_id = bodystyle.bodystyle_id 
		WHERE cars.status='AVAILABLE' ".$expirationFilter." ".$queryString." ORDER BY ".$orderBy."  LIMIT ".$perPage." OFFSET ".$offset;
		$stmt = $this->connection->prepare($query);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		for($i=0; $i < sizeof($rows); $i++)
		{
			$queryforImages = "SELECT * FROM cars_images WHERE vin = :vin";
			$stmtImages = $this->connection->prepare($queryforImages);
			$stmtImages->execute([':vin' => $rows[$i]['vin']]);
			$rowsImages = $stmtImages->fetchAll(PDO::FETCH_ASSOC);
			$rows[$i]['carimages'] = $rowsImages;
		}
		
		$result = array('data' => $rows, 'totalRows' => sizeof($totalRows), 'totalPages' => $totalPages);
		return $result;
	}
	
	public function getMakeById($id)
	{
		$query = "SELECT * FROM cars_make WHERE make_id = :id";
		$stmt = $this->connection->prepare($query);
		$stmt->execute([':id' => $id]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	
	// MODEL FUNCTIONS
	public function getActiveModelByMake($make_id)
	{
		$expirationFilter = $this->hasExpirationDateColumn() 
			? "AND (expiration_date IS NULL OR expiration_date >= CURDATE())" 
			: "";
		
		$query = "SELECT * FROM cars_model WHERE status='ACTIVE' AND make_id = :make_id AND model_id IN (SELECT model_id FROM cars_listings WHERE status = 'AVAILABLE' ".$expirationFilter.") ORDER BY model ASC";
		$stmt = $this->connection->prepare($query);
		$stmt->execute([':make_id' => $make_id]);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $rows;
	}
	
	// MODEL FUNCTIONS
	public function getActiveModelByMakeSlug($make_slug)
	{
		$expirationFilter = $this->hasExpirationDateColumn() 
			? "AND (expiration_date IS NULL OR expiration_date >= CURDATE())" 
			: "";
		
		$query = "SELECT * FROM cars_model WHERE status='ACTIVE' AND make_id IN (SELECT make_id FROM cars_make WHERE make_slug = :make_slug AND status='ACTIVE') AND model_id IN (SELECT model_id FROM cars_listings WHERE status = 'AVAILABLE' ".$expirationFilter.") ORDER BY model ASC";
		$stmt = $this->connection->prepare($query);
		$stmt->execute([':make_slug' => $make_slug]);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $rows;
	}
	
	
	public function getModelById($id)
	{
		$query = "SELECT * FROM cars_model WHERE model_id = :id";
		$stmt = $this->connection->prepare($query);
		$stmt->execute([':id' => $id]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	
	public function getActiveBodyStyle()
	{
		$sql = "SELECT * FROM cars_bodystyle WHERE status='ACTIVE' ORDER BY bodystyle ASC";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}
	

	
	public function getBodyStyleById($id)
	{
		$query = "SELECT * FROM cars_bodystyle WHERE bodystyle_id = :id";
		$stmt = $this->connection->prepare($query);
		$stmt->execute([':id' => $id]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	// GET CARS LISTS.
	public function getCarsLists()
	{
		try {
			$sqlString = 'SELECT c.*, cmake.make, cmodel.model, cb.bodystyle FROM cars_listings c 
			JOIN cars_make cmake ON c.make_id=cmake.make_id
			JOIN cars_model cmodel ON c.model_id=cmodel.model_id
			JOIN cars_bodystyle cb ON c.bodystyle_id=cb.bodystyle_id';
			
			$sqlString .= ' ORDER BY c.id DESC';
			
			$listStmt = $this->connection->prepare($sqlString);
			$listStmt->execute();
			$listRows = $listStmt->fetchAll(PDO::FETCH_ASSOC);
			
			if (count($listRows) > 0) {
				foreach ($listRows as &$item) {
					try {
						$imageSql = "SELECT * FROM cars_images WHERE vin = :vin ORDER BY imageorder LIMIT 1";
						$imageStmt = $this->connection->prepare($imageSql);
						$imageStmt->execute([':vin' => $item['vin']]);
						$imageRow = $imageStmt->fetch(PDO::FETCH_ASSOC);
						if ($imageRow) {
							$item['image'] = $imageRow['imagename'];
						}
					} catch (PDOException $e) {
						error_log("Error fetching car image: " . $e->getMessage());
						$item['image'] = null;
					}
					
					if ($item['status'] == 'SOLD OUT') {
						try {
							$saleSql = "SELECT * FROM cars_sale WHERE vin = :vin ORDER BY sale_id DESC LIMIT 1";
							$saleStmt = $this->connection->prepare($saleSql);
							$saleStmt->execute([':vin' => $item['vin']]);
							$saleRow = $saleStmt->fetch(PDO::FETCH_ASSOC);
							if ($saleRow) {
								$item['owner_price'] = $saleRow['owner_price'];
								$item['sale_price'] = $saleRow['sale_price'];
								$item['saledate'] = $saleRow['saledate'];
							}
						} catch (PDOException $e) {
							error_log("Error fetching sale data: " . $e->getMessage());
						}
					}
				}
				return $listRows;
			} else {
				return array();
			}
		} catch (PDOException $e) {
			error_log("Error in getCarsLists: " . $e->getMessage());
			return array();
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
	
	public function getCarDetailsById($id)
	{
		try {
			$sqlString = 'SELECT c.*, cmake.make, cmodel.model, cb.bodystyle FROM cars_listings c 
			JOIN cars_make cmake ON c.make_id=cmake.make_id
			JOIN cars_model cmodel ON c.model_id=cmodel.model_id
			JOIN cars_bodystyle cb ON c.bodystyle_id=cb.bodystyle_id WHERE id = :id';
			$listtmt = $this->connection->prepare($sqlString);
			$listtmt->execute([':id' => $id]);
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
			error_log("Error in getCarDetailsById: " . $e->getMessage());
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
	
	// CREATE IMAGE URLS.
	public function createImageUrl($imagesString, $baseURL, $vin)
	{
		$imagesArray = explode('|', $imagesString);
		$newImagesArray = array_map(function ($image) use ($baseURL, $vin) {
			return $baseURL . '/' . $vin . '/' .  $image;
		}, $imagesArray);
		return implode('|', $newImagesArray);
	}


	public function getSaleDetailsByVIN($vin)
	{
		$query = "SELECT * FROM cars_sale WHERE vin = :vin ORDER BY saledate DESC";
		$stmt = $this->connection->prepare($query);
		$stmt->execute([':vin' => $vin]);
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;	
	}
	
	public function getCarDetailsByVIN($vin)
	{
		$query = "SELECT c.*, cmake.make, cmake.make_slug, cmodel.model, cmodel.model_slug, cb.bodystyle FROM cars_listings c 
		JOIN cars_make cmake ON c.make_id=cmake.make_id
		JOIN cars_model cmodel ON c.model_id=cmodel.model_id
		JOIN cars_bodystyle cb ON c.bodystyle_id=cb.bodystyle_id WHERE vin = :vin";
		$stmt = $this->connection->prepare($query);
		$stmt->execute([':vin' => $vin]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function getLowestPriceCar()
	{
		$query = "SELECT c.*, cmake.make, cmodel.model, cb.bodystyle FROM cars_listings c 
		JOIN cars_make cmake ON c.make_id=cmake.make_id
		JOIN cars_model cmodel ON c.model_id=cmodel.model_id
		JOIN cars_bodystyle cb ON c.bodystyle_id=cb.bodystyle_id WHERE c.status='AVAILABLE' ORDER BY CAST(c.website_price AS UNSIGNED) ASC LIMIT 1";
		$stmt = $this->connection->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function getHighestPriceCar()
	{
		$query = "SELECT c.*, cmake.make, cmodel.model, cb.bodystyle FROM cars_listings c 
		JOIN cars_make cmake ON c.make_id=cmake.make_id
		JOIN cars_model cmodel ON c.model_id=cmodel.model_id
		JOIN cars_bodystyle cb ON c.bodystyle_id=cb.bodystyle_id WHERE c.status='AVAILABLE' ORDER BY CAST(c.website_price AS UNSIGNED) DESC LIMIT 1";
		$stmt = $this->connection->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	
	public function getCarsSaleCount($startDate,$endDate)
	{
		$query = "SELECT COUNT(*) AS totalSales FROM cars_sale WHERE DATE(saledate) BETWEEN :start AND :end";
		$stmt = $this->connection->prepare($query);
		$stmt->execute([':start' => $startDate, ':end' => $endDate]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['totalSales'];
	}


	public function getCarLink($SITE_URL, $carItem)
	{
		return  $SITE_URL."/car-details/".$carItem['year']."-".$carItem['make_slug']."-".$carItem['model_slug']."/".$carItem['vin'];
	}
	
	public function insertIntoLead($data)
	{
		try {
			// Get agent_id from the car listing using VIN
			$agent_id = null;
			if (isset($data['vin']) && !empty($data['vin'])) {
				$carSql = "SELECT agent_id FROM cars_listings WHERE vin = :vin LIMIT 1";
				$carStmt = $this->connection->prepare($carSql);
				$carStmt->execute([':vin' => $data['vin']]);
				$carData = $carStmt->fetch(PDO::FETCH_ASSOC);
				if ($carData && isset($carData['agent_id']) && !empty($carData['agent_id'])) {
					$agent_id = (int)$carData['agent_id'];
				}
			}
			
			// Insert lead with agent_id if available
			if ($agent_id !== null) {
				$insertQuery = 'INSERT INTO leads (vin, agent_id, name, email, phone, message) VALUES (:vin, :agent_id, :name, :email, :phone, :message)';
				$stmt = $this->connection->prepare($insertQuery);
				$result = $stmt->execute([
					':vin' => $data['vin'],
					':agent_id' => $agent_id,
					':name' => $data['name'],
					':email' => $data['email'],
					':phone' => $data['phone'],
					':message' => $data['message']
				]);
			} else {
				// Fallback for cars without agent_id (e.g., admin-added cars)
				$insertQuery = 'INSERT INTO leads (vin, name, email, phone, message) VALUES (:vin, :name, :email, :phone, :message)';
				$stmt = $this->connection->prepare($insertQuery);
				$result = $stmt->execute([
					':vin' => $data['vin'],
					':name' => $data['name'],
					':email' => $data['email'],
					':phone' => $data['phone'],
					':message' => $data['message']
				]);
			}
			return $result;
		} catch (PDOException $e) {
			error_log("Error in insertIntoLead: " . $e->getMessage());
			return false;
		}
	}
}	