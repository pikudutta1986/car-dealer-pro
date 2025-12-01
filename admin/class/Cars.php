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

		public function getCarLink($SITE_URL, $carItem)
		{
			return  $SITE_URL."/car-details/".$carItem['year']."-".$carItem['make_slug']."-".$carItem['model_slug']."/".$carItem['vin'];
		}
		
		// MAKE FUNCTIONS
		public function getAllMake()
		{
			$query = "SELECT * FROM cars_make ORDER BY make ASC";
			$stmt = $this->connection->prepare($query);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);  
			return $rows;
		}
		
		function displayDate($date)
		{
			return date("M d, Y", strtotime($date));
		}
		
		public function getActiveMake()
		{
			$query = "SELECT * FROM cars_make WHERE status='ACTIVE' ORDER BY make ASC";
			$stmt = $this->connection->prepare($query);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rows;
		}
		
		public function getMakeById($id)
		{
			$query = "SELECT * FROM cars_make WHERE make_id = :id";
			$stmt = $this->connection->prepare($query);
			$stmt->execute([':id' => $id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			return $row;
		}
		
		public function insertIntoMake($data)
		{
			$response = array();
			
			if($data["make"] != '') 
			{
				$make_slug = $this->slugify($data["make"]);
				
				// UPDATE CASE
				if (isset($data['id'])) 
				{
					$makeSql = 'SELECT * FROM cars_make WHERE make_id = :id';
					$makeStmt = $this->connection->prepare($makeSql);
					$makeStmt->execute([':id' => $data['id']]);
					$makeRow = $makeStmt->fetch(PDO::FETCH_ASSOC);
					
					if ($makeRow) {
						$updateSql = "UPDATE cars_make SET make = :make, make_slug = :make_slug, image = :image WHERE make_id = :id";
						$updateStmt = $this->connection->prepare($updateSql);
						$updateResult = $updateStmt->execute([':make' => $data['make'], ':make_slug' => $make_slug, ':image' => $data['image'], ':id' => $data['id']]);
						
						if ($updateResult) {
							$response['edit_id'] = $data['id'];
							$response['message'] = 'Updated successfully.';
							$response['success'] = true;
							return $response;
							} else {
							$response['message'] = 'Updattion failed.';
							$response['success'] = false;
							return $response;
						}
					}
				}
				
				
				// INSERT CASE
				$insertSql = "INSERT INTO cars_make (make, make_slug, image) VALUES (:make, :slug, :image)";
				$insertStmt = $this->connection->prepare($insertSql);
				$insertResult = $insertStmt->execute([':make' => $data['make'], ':slug' => $make_slug, ':image' => $data['image']]);
				
				if ($insertResult) {
					$response['edit_id'] = $this->connection->lastInsertId();
					$response['message'] = 'Inserted successfully.';
					$response['success'] = true;
					return $response;
					} else {
					$response['message'] = 'Insertion failed.';
					$response['success'] = false;
					return $response;
				}
				
			} else {
				$response['message'] = 'Please, fill the basic details.';
				$response['success'] = false;
				return $response;
			}
		}
		
		public function deleteMakeImage($id)
		{
			$query = "UPDATE cars_make SET image = NULL WHERE make_id = :id";
			$stmt = $this->connection->prepare($query);
			$stmt->execute([':id' => $id]);
		}
		
		// MODEL FUNCTIONS
		public function getActiveModelByMake($make_id)
		{
			$query = "SELECT * FROM cars_model WHERE status='ACTIVE' AND make_id = :make_id ORDER BY model ASC";
			$stmt = $this->connection->prepare($query);
			$stmt->execute([':make_id' => $make_id]);
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			return $rows;
		}
		
		public function getAllModelByMake($make_id)
		{
			$query = "SELECT * FROM cars_model WHERE make_id = :make_id ORDER BY model ASC";
			$stmt = $this->connection->prepare($query);
			$stmt->execute([':make_id' => $make_id]);
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			return $rows;
		}
		
		public function getAllMakeModels()
		{
			$query = "SELECT cars_model.*, cars_make.make FROM cars_model JOIN cars_make ON cars_model.make_id = cars_make.make_id ORDER BY cars_make.make ASC";
			$stmt = $this->connection->prepare($query);
			$stmt->execute();
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
		
		public function insertIntoModel($data)
		{
			$response = array();
			
			if($data["model"] != '' && $data["make_id"] != '')  
			{
				$model_slug = $this->slugify($data["model"]);
				
				// UPDATE CASE
				if (isset($data['id'])) 
				{
					$modelSql = "SELECT * FROM cars_model WHERE model_id = :id";
					$modelStmt = $this->connection->prepare($modelSql);
					$modelStmt->execute([':id' => $data['id']]);
					$modelRow = $modelStmt->fetch(PDO::FETCH_ASSOC);
					
					if ($modelRow) {
						$updateSql = "UPDATE cars_model SET make_id = :make_id, model = :model, model_slug = :model_slug WHERE model_id = :id";
						$updateStmt = $this->connection->prepare($updateSql);
						$updateResult = $updateStmt->execute([':make_id' => $data['make_id'], ':model' => $data['model'], ':model_slug' => $model_slug, ':id' => $data['id']]);
						
						if ($updateResult) {
							$response['edit_id'] = $data['id'];
							$response['message'] = 'Updated successfully.';
							$response['success'] = true;
							return $response;
							} else {
							$response['message'] = 'Updattion failed.';
							$response['success'] = false;
							return $response;
						}
					}
				}
				
				// INSERT CASE
				$insertSql = "INSERT INTO cars_model (make_id, model, model_slug) VALUES (:make_id, :model, :model_slug)";
				$insertStmt = $this->connection->prepare($insertSql);
				$insertResult = $insertStmt->execute([':make_id' => $data['make_id'], ':model' => $data['model'], ':model_slug' => $model_slug]);
				
				if ($insertResult) {
					$response['edit_id'] = $this->connection->lastInsertId();
					$response['message'] = 'Inserted successfully.';
					$response['success'] = true;
					return $response;
					} else {
					$response['message'] = 'Insertion failed.';
					$response['success'] = false;
					return $response;
				}
				
				} else {
				$response['message'] = 'Please, fill the basic details.';
				$response['success'] = false;
				return $response;
			}
		}
		
		public function getActiveBodyStyle()
		{
			$sql = "SELECT * FROM cars_bodystyle WHERE status='ACTIVE' ORDER BY bodystyle ASC";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rows;
		}
		
		public function getAllBodyStyle()
		{
			$sql = "SELECT * FROM cars_bodystyle ORDER BY bodystyle ASC";
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
		
		public function insertIntoBodyStyle($data)
		{
			$response = array();
			
			if($data["bodystyle"] != '')  
			{
				$slug = $this->slugify($data["bodystyle"]);
				// UPDATE CASE
				if (isset($data['id'])) 
				{
					$modelSql = "SELECT * FROM cars_bodystyle WHERE bodystyle_id = :id";
					$modelStmt = $this->connection->prepare($modelSql);
					$modelStmt->execute([':id' => $data['id']]);
					$modelRow = $modelStmt->fetch(PDO::FETCH_ASSOC);
					
					if ($modelRow) {
						$updateSql = "UPDATE cars_bodystyle SET bodystyle = :bodystyle, slug = :slug, image = :image WHERE bodystyle_id = :id";
						$updateStmt = $this->connection->prepare($updateSql);
						$updateResult = $updateStmt->execute([':bodystyle' => $data['bodystyle'], ':slug' => $slug, ':image' => $data['image'], ':id' => $data['id']]);
						
						if ($updateResult) {
							$response['edit_id'] = $data['id'];
							$response['message'] = 'Updated successfully.';
							$response['success'] = true;
							return $response;
							} else {
							$response['message'] = 'Updattion failed.';
							$response['success'] = false;
							return $response;
						}
					}
				}
				
				// INSERT CASE
				$insertSql = "INSERT INTO cars_bodystyle (bodystyle, slug, image) VALUES (:bodystyle, :slug, :image)";
				$insertStmt = $this->connection->prepare($insertSql);
				$insertResult = $insertStmt->execute([':bodystyle' => $data['bodystyle'], ':slug' => $slug, ':image' => $data['image']]);
				
				if ($insertResult) {
					$response['edit_id'] = $this->connection->lastInsertId();
					$response['message'] = 'Inserted successfully.';
					$response['success'] = true;
					return $response;
					} else {
					$response['message'] = 'Insertion failed.';
					$response['success'] = false;
					return $response;
				}
				
				} else {
				$response['message'] = 'Please, fill the basic details.';
				$response['success'] = false;
				return $response;
			}
		}
		
		public function deleteBodyStyleImage($id)
		{
			$query = "UPDATE cars_bodystyle SET image=NULL WHERE bodystyle_id = :id";
			$stmt = $this->connection->prepare($query);
			$stmt->execute([':id' => $id]);
		}
		
		// GET CARS LISTS.
		public function getCarsLists()
		{
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
					$imageSql = "SELECT * FROM cars_images WHERE vin = :vin ORDER BY imageorder LIMIT 1";
					$imageStmt = $this->connection->prepare($imageSql);
					$imageStmt->execute([':vin' => $item['vin']]);
					$imageRow = $imageStmt->fetch(PDO::FETCH_ASSOC);
					if ($imageRow) {
						$item['image'] = $imageRow['imagename'];
					}
					
					if ($item['status'] == 'SOLD OUT')
					{
						$saleSql = "SELECT * FROM cars_sale WHERE vin = :vin ORDER BY sale_id DESC LIMIT 1";
						$saleStmt = $this->connection->prepare($saleSql);
						$saleStmt->execute([':vin' => $item['vin']]);
						$saleRow = $saleStmt->fetch(PDO::FETCH_ASSOC);
						$item['owner_price'] = $saleRow['owner_price'];
						$item['sale_price'] = $saleRow['sale_price'];
						$item['saledate'] = $saleRow['saledate'];
					}
				}
				return $listRows;
				} else {
				return array();
			}
		}
		
		public function getCarUserById($id)
		{
			$query = "SELECT * FROM users WHERE user_id = :id";
			$stmt = $this->connection->prepare($query);
			$stmt->execute([':id' => $id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			return $row;
		}
		
		public function getCarDetailsById($id)
		{
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
		}
		
		public function insertIntoListings($data)
		{
			$response = array();
			
			if(
			$data["vin"] == '' || $data["carcondition"] == '' || $data["make_id"] == '' || $data["model_id"] == '' || 
			$data["bodystyle_id"] == '' || $data["fuel_type"] == '' || $data["year"] == '' ||
			$data["website_price"] == ''
			) 
			{
				$response['message'] = 'Please fill the basic details.';
				$response['success'] = false;
				return $response;
			}
			
			if($data["name"] == '' || $data["email"] == '' || $data["phone"] == '' || $data["owner_price"] == '') 
			{
				$response['message'] = 'Please fill the owner details with owner price.';
				$response['success'] = false;
				return $response;
			}
			
			// OWNER ADD OR UPDATE
			$userSql = "SELECT * FROM users WHERE email = :email OR phone = :phone";
			$userStmt = $this->connection->prepare($userSql);
			$userStmt->execute([':email' => $data['email'], ':phone' => $data['phone']]);
			$userRow = $userStmt->fetch(PDO::FETCH_ASSOC);
			
			// IF USER FOUND
			if ($userRow) {
				// SET THE OWNER ID
				$owner_id = $userRow['user_id'];
				// UPDATE USER INFO
				$updateUserSql = "UPDATE users SET name = :name, email = :email, phone = :phone, address = :address WHERE user_id = :user_id";
				$updOwner = $this->connection->prepare($updateUserSql);
				$updOwner->execute([':name' => $data['name'], ':email' => $data['email'], ':phone' => $data['phone'], ':address' => $data['address'], ':user_id' => $owner_id]);
			} else {
				$insertUserSql = 'INSERT INTO users (name, email, phone, address) VALUES (:name, :email, :phone, :address)';
				$insOwner = $this->connection->prepare($insertUserSql);
				$insertUserResult = $insOwner->execute([':name' => $data['name'], ':email' => $data['email'], ':phone' => $data['phone'], ':address' => $data['address']]);
				// SET THE OWNER ID
				$owner_id = $this->connection->lastInsertId();
			}
			
			// Get agent_id from data if provided
			$agent_id = isset($data['agent_id']) && !empty($data['agent_id']) ? (int)$data['agent_id'] : null;
			
			// UPDATE CASE
			if (isset($data['id'])) 
			{
				// CHECK IF CAR PRESENT BY ID 
				$listSql = "SELECT * FROM cars_listings WHERE id = :id";
				$listStmt = $this->connection->prepare($listSql);
				$listStmt->execute([':id' => $data['id']]);
				$listRow = $listStmt->fetch(PDO::FETCH_ASSOC);
				
				// IF CAR PRESENT
				if ($listRow) 
				{
					// CHECK FOR DUPLICATE VIN
					$selectSql = "SELECT * FROM cars_listings WHERE vin = :vin AND id != :id";
					$stmt = $this->connection->prepare($selectSql);
					$stmt->execute([':vin' => $data['vin'], ':id' => $data['id']]);
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
					// DUPLICATE VIN FOUND
					if ($row)
					{
						$response['message'] = 'VIN is already present.';
						$response['success'] = false;
						return $response;
					}
					
					// Build UPDATE query with agent_id if provided
					if ($agent_id !== null) {
						$updateSql = "UPDATE cars_listings SET vin = :vin, carcondition = :carcondition, owner_id = :owner_id, agent_id = :agent_id, make_id = :make_id, 
						model_id = :model_id, year = :year, varient = :varient, 
						bodystyle_id = :bodystyle_id, mileage = :mileage, 
						transmission = :transmission, fuel_type = :fuel_type, 
						max_power = :max_power, color = :color, engine = :engine, 
						owner_price = :owner_price, website_price = :website_price, 
						boot_space = :boot_space, ground_clearance = :ground_clearance, 
						cylinders = :cylinders, max_torque = :max_torque, seating_capacity = :seating_capacity, 
						airbags = :airbags,  details = :details, features = :features
						WHERE id = :id";
						$upd = $this->connection->prepare($updateSql);
						$updateResult = $upd->execute([
							':vin' => $data['vin'],
							':carcondition' => $data['carcondition'],
							':owner_id' => $owner_id,
							':agent_id' => $agent_id,
							':make_id' => $data['make_id'],
							':model_id' => $data['model_id'],
							':year' => $data['year'],
							':varient' => $data['varient'],
							':bodystyle_id' => $data['bodystyle_id'],
							':mileage' => $data['mileage'],
							':transmission' => $data['transmission'],
							':fuel_type' => $data['fuel_type'],
							':max_power' => $data['max_power'],
							':color' => $data['color'],
							':engine' => $data['engine'],
							':owner_price' => $data['owner_price'],
							':website_price' => $data['website_price'],
							':boot_space' => $data['boot_space'],
							':ground_clearance' => $data['ground_clearance'],
							':cylinders' => $data['cylinders'],
							':max_torque' => $data['max_torque'],
							':seating_capacity' => $data['seating_capacity'],
							':airbags' => $data['airbags'],
							':details' => addslashes($data['details']),
							':features' => addslashes($data['features']),
							':id' => $data['id']
						]);
					} else {
						$updateSql = "UPDATE cars_listings SET vin = :vin, carcondition = :carcondition, owner_id = :owner_id, make_id = :make_id, 
						model_id = :model_id, year = :year, varient = :varient, 
						bodystyle_id = :bodystyle_id, mileage = :mileage, 
						transmission = :transmission, fuel_type = :fuel_type, 
						max_power = :max_power, color = :color, engine = :engine, 
						owner_price = :owner_price, website_price = :website_price, 
						boot_space = :boot_space, ground_clearance = :ground_clearance, 
						cylinders = :cylinders, max_torque = :max_torque, seating_capacity = :seating_capacity, 
						airbags = :airbags,  details = :details, features = :features
						WHERE id = :id";
						$upd = $this->connection->prepare($updateSql);
						$updateResult = $upd->execute([
							':vin' => $data['vin'],
							':carcondition' => $data['carcondition'],
							':owner_id' => $owner_id,
							':make_id' => $data['make_id'],
							':model_id' => $data['model_id'],
							':year' => $data['year'],
							':varient' => $data['varient'],
							':bodystyle_id' => $data['bodystyle_id'],
							':mileage' => $data['mileage'],
							':transmission' => $data['transmission'],
							':fuel_type' => $data['fuel_type'],
							':max_power' => $data['max_power'],
							':color' => $data['color'],
							':engine' => $data['engine'],
							':owner_price' => $data['owner_price'],
							':website_price' => $data['website_price'],
							':boot_space' => $data['boot_space'],
							':ground_clearance' => $data['ground_clearance'],
							':cylinders' => $data['cylinders'],
							':max_torque' => $data['max_torque'],
							':seating_capacity' => $data['seating_capacity'],
							':airbags' => $data['airbags'],
							':details' => addslashes($data['details']),
							':features' => addslashes($data['features']),
							':id' => $data['id']
						]);
					}
					
					if ($updateResult) 
					{
						$response['edit_id'] = $data['id'];
						$response['message'] = 'Updated successfully.';
						$response['success'] = true;
						return $response;
					} 
					else 
					{
						$response['message'] = 'Update failed.';
						$response['success'] = false;
						return $response;
					}
				}
			}
			
			// INSERT CASE
			// CHECK FOR DUPLICATE VIN
			$selectSql = "SELECT * FROM cars_listings WHERE vin = :vin";
			$stmt = $this->connection->prepare($selectSql);
			$stmt->execute([':vin' => $data['vin']]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			// DUPLICATE VIN FOUND
			if ($row)
			{
				$response['message'] = 'VIN is already present.';
				$response['success'] = false;
				return $response;
			}
			
			// Check if expiration_date column exists
			$hasExpirationColumn = false;
			try {
				$checkSql = "SHOW COLUMNS FROM cars_listings LIKE 'expiration_date'";
				$checkStmt = $this->connection->prepare($checkSql);
				$checkStmt->execute();
				$result = $checkStmt->fetch(PDO::FETCH_ASSOC);
				$hasExpirationColumn = !empty($result);
			} catch (PDOException $e) {
				$hasExpirationColumn = false;
			}
			
			// Determine expiration_date based on account type
			$expirationDate = null;
			$accountType = isset($data['account_type']) ? $data['account_type'] : '';
			
			// If account_type not provided, try to get it from agent table
			if (empty($accountType) && isset($data['email'])) {
				try {
					$agentSql = "SELECT account_type FROM agent WHERE email = :email LIMIT 1";
					$agentStmt = $this->connection->prepare($agentSql);
					$agentStmt->execute([':email' => $data['email']]);
					$agentRow = $agentStmt->fetch(PDO::FETCH_ASSOC);
					if ($agentRow) {
						$accountType = $agentRow['account_type'];
					}
				} catch (PDOException $e) {
					error_log("Error checking account type: " . $e->getMessage());
				}
			}
			
			// Set expiration_date to 1 week from now for individual accounts
			if ($hasExpirationColumn && $accountType == 'individual') {
				$expirationDate = date('Y-m-d', strtotime('+1 week'));
			}
			
			// INSERT CASE
			if ($hasExpirationColumn) {
				if ($agent_id !== null) {
					$insertSql = 'INSERT INTO cars_listings 
					(vin, carcondition, owner_id, agent_id, year, make_id, model_id, varient, bodystyle_id, mileage, transmission, fuel_type, max_power, color, engine, owner_price, website_price, boot_space, ground_clearance, details, features, dateadded, expiration_date, cylinders, max_torque, seating_capacity, airbags) VALUES 
					(:vin, :carcondition, :owner_id, :agent_id, :year, :make_id, :model_id, :varient, :bodystyle_id, :mileage, :transmission, :fuel_type, :max_power, :color, :engine, :owner_price, :website_price, :boot_space, :ground_clearance, :details, :features, NOW(), :expiration_date, :cylinders, :max_torque, :seating_capacity, :airbags)';
					$ins = $this->connection->prepare($insertSql);
					$insertResult = $ins->execute([
						':vin' => $data['vin'],
						':carcondition' => $data['carcondition'],
						':owner_id' => $owner_id,
						':agent_id' => $agent_id,
						':year' => $data['year'],
						':make_id' => $data['make_id'],
						':model_id' => $data['model_id'],
						':varient' => $data['varient'],
						':bodystyle_id' => $data['bodystyle_id'],
						':mileage' => $data['mileage'],
						':transmission' => $data['transmission'],
						':fuel_type' => $data['fuel_type'],
						':max_power' => $data['max_power'],
						':color' => $data['color'],
						':engine' => $data['engine'],
						':owner_price' => $data['owner_price'],
						':website_price' => $data['website_price'],
						':boot_space' => $data['boot_space'],
						':ground_clearance' => $data['ground_clearance'],
						':details' => addslashes($data['details']),
						':features' => addslashes($data['features']),
						':expiration_date' => $expirationDate,
						':cylinders' => $data['cylinders'],
						':max_torque' => $data['max_torque'],
						':seating_capacity' => $data['seating_capacity'],
						':airbags' => $data['airbags']
					]);
				} else {
					$insertSql = 'INSERT INTO cars_listings 
					(vin, carcondition, owner_id, year, make_id, model_id, varient, bodystyle_id, mileage, transmission, fuel_type, max_power, color, engine, owner_price, website_price, boot_space, ground_clearance, details, features, dateadded, expiration_date, cylinders, max_torque, seating_capacity, airbags) VALUES 
					(:vin, :carcondition, :owner_id, :year, :make_id, :model_id, :varient, :bodystyle_id, :mileage, :transmission, :fuel_type, :max_power, :color, :engine, :owner_price, :website_price, :boot_space, :ground_clearance, :details, :features, NOW(), :expiration_date, :cylinders, :max_torque, :seating_capacity, :airbags)';
					$ins = $this->connection->prepare($insertSql);
					$insertResult = $ins->execute([
						':vin' => $data['vin'],
						':carcondition' => $data['carcondition'],
						':owner_id' => $owner_id,
						':year' => $data['year'],
						':make_id' => $data['make_id'],
						':model_id' => $data['model_id'],
						':varient' => $data['varient'],
						':bodystyle_id' => $data['bodystyle_id'],
						':mileage' => $data['mileage'],
						':transmission' => $data['transmission'],
						':fuel_type' => $data['fuel_type'],
						':max_power' => $data['max_power'],
						':color' => $data['color'],
						':engine' => $data['engine'],
						':owner_price' => $data['owner_price'],
						':website_price' => $data['website_price'],
						':boot_space' => $data['boot_space'],
						':ground_clearance' => $data['ground_clearance'],
						':details' => addslashes($data['details']),
						':features' => addslashes($data['features']),
						':expiration_date' => $expirationDate,
						':cylinders' => $data['cylinders'],
						':max_torque' => $data['max_torque'],
						':seating_capacity' => $data['seating_capacity'],
						':airbags' => $data['airbags']
					]);
				}
			} else {
				// Fallback for when column doesn't exist yet
				if ($agent_id !== null) {
					$insertSql = 'INSERT INTO cars_listings 
					(vin, carcondition, owner_id, agent_id, year, make_id, model_id, varient, bodystyle_id, mileage, transmission, fuel_type, max_power, color, engine, owner_price, website_price, boot_space, ground_clearance, details, features, dateadded, cylinders, max_torque, seating_capacity, airbags) VALUES 
					(:vin, :carcondition, :owner_id, :agent_id, :year, :make_id, :model_id, :varient, :bodystyle_id, :mileage, :transmission, :fuel_type, :max_power, :color, :engine, :owner_price, :website_price, :boot_space, :ground_clearance, :details, :features, NOW(), :cylinders, :max_torque, :seating_capacity, :airbags)';
					$ins = $this->connection->prepare($insertSql);
					$insertResult = $ins->execute([
						':vin' => $data['vin'],
						':carcondition' => $data['carcondition'],
						':owner_id' => $owner_id,
						':agent_id' => $agent_id,
						':year' => $data['year'],
						':make_id' => $data['make_id'],
						':model_id' => $data['model_id'],
						':varient' => $data['varient'],
						':bodystyle_id' => $data['bodystyle_id'],
						':mileage' => $data['mileage'],
						':transmission' => $data['transmission'],
						':fuel_type' => $data['fuel_type'],
						':max_power' => $data['max_power'],
						':color' => $data['color'],
						':engine' => $data['engine'],
						':owner_price' => $data['owner_price'],
						':website_price' => $data['website_price'],
						':boot_space' => $data['boot_space'],
						':ground_clearance' => $data['ground_clearance'],
						':details' => addslashes($data['details']),
						':features' => addslashes($data['features']),
						':cylinders' => $data['cylinders'],
						':max_torque' => $data['max_torque'],
						':seating_capacity' => $data['seating_capacity'],
						':airbags' => $data['airbags']
					]);
				} else {
					$insertSql = 'INSERT INTO cars_listings 
					(vin, carcondition, owner_id, year, make_id, model_id, varient, bodystyle_id, mileage, transmission, fuel_type, max_power, color, engine, owner_price, website_price, boot_space, ground_clearance, details, features, dateadded, cylinders, max_torque, seating_capacity, airbags) VALUES 
					(:vin, :carcondition, :owner_id, :year, :make_id, :model_id, :varient, :bodystyle_id, :mileage, :transmission, :fuel_type, :max_power, :color, :engine, :owner_price, :website_price, :boot_space, :ground_clearance, :details, :features, NOW(), :cylinders, :max_torque, :seating_capacity, :airbags)';
					$ins = $this->connection->prepare($insertSql);
					$insertResult = $ins->execute([
						':vin' => $data['vin'],
						':carcondition' => $data['carcondition'],
						':owner_id' => $owner_id,
						':year' => $data['year'],
						':make_id' => $data['make_id'],
						':model_id' => $data['model_id'],
						':varient' => $data['varient'],
						':bodystyle_id' => $data['bodystyle_id'],
						':mileage' => $data['mileage'],
						':transmission' => $data['transmission'],
						':fuel_type' => $data['fuel_type'],
						':max_power' => $data['max_power'],
						':color' => $data['color'],
						':engine' => $data['engine'],
						':owner_price' => $data['owner_price'],
						':website_price' => $data['website_price'],
						':boot_space' => $data['boot_space'],
						':ground_clearance' => $data['ground_clearance'],
						':details' => addslashes($data['details']),
						':features' => addslashes($data['features']),
						':cylinders' => $data['cylinders'],
						':max_torque' => $data['max_torque'],
						':seating_capacity' => $data['seating_capacity'],
						':airbags' => $data['airbags']
					]);
				}
			}
			
			if ($insertResult) {
				$response['edit_id'] = $this->connection->lastInsertId();
				$response['message'] = 'Inserted successfully.';
				$response['success'] = true;
				return $response;
			} else {
				$response['message'] = 'Insert failed.';
				$response['success'] = false;
				return $response;
			}
		}
		
		// INSERT CAR IMAGES.
		public function insertCarImages($data)
		{
			$imageorder = 1;
			
			if ($data['vin'] != '') {
				$imagNameQuery = "SELECT * FROM cars_images WHERE vin = :vin AND imagename = :img";
				$imageNameStmt = $this->connection->prepare($imagNameQuery);
				$imageNameStmt->execute([':vin' => $data['vin'], ':img' => $data['fileName']]);
				$imageNamerows = $imageNameStmt->fetchAll(PDO::FETCH_ASSOC);
				
				if (count($imageNamerows) > 0) {
					return false;
				}
				
				$rows = $this->getImagesByVin($data['vin']);
				
				if (count($rows) > 0) {
					$imageorder = count($rows) + 1;
				}
				
				$sql = 'INSERT INTO cars_images ( vin, imagename, imageorder ) VALUES (:vin, :img, :ord)';
				$stmt = $this->connection->prepare($sql);
				$result = $stmt->execute([':vin' => $data['vin'], ':img' => $data['fileName'], ':ord' => $imageorder]);
				
				if ($result) {
					$dataArray = $this->getImagesByVin($data['vin']);
					return $dataArray;
				} else {
					return false;
				}
			}
		}
		
		// INSERT CAR IMAGES.
		public function insertProfilelogoImages($data)
		{
			// Prepare the update query
			$updateQuery = "UPDATE admin SET business_logo = :logo WHERE admin_id  = :user_id";
			$up = $this->connection->prepare($updateQuery);
			$updateResult = $up->execute([':logo' => $data['fileName'], ':user_id' => $data['user_id']]);
			
			if ($updateResult) {

				$sql = 'SELECT business_logo FROM admin WHERE admin_id = :user_id';
				$stmt = $this->connection->prepare($sql);
				$stmt->execute([':user_id' => $data['user_id']]);
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$dataArray = $rows;
				return $dataArray;
			} else {
				return false;
			}
			
		}
		
		// UPDATE IMAGES ORDER BY DRAGGING.
		public function updateImagesOrder($data)
		{
			$vin = $data['vin'];
			$filesArray = $data['filesArray'];
			
			// Begin transaction
			$this->connection->beginTransaction();
			
			try {
				// Prepare the base query
				$caseStatement = "";
				$orderIndex = 1;
				foreach ($filesArray as $filename) {
					$caseStatement .= "WHEN '$filename' THEN $orderIndex ";
					$orderIndex++;
				}
				
				// Complete the case statement
				$caseStatement = "CASE imagename " . $caseStatement . "ELSE imageorder END";
				
				// Prepare the update query
				$updateQuery = "UPDATE cars_images SET imageorder = $caseStatement WHERE vin = :vin";
				$up = $this->connection->prepare($updateQuery);
				$updateResult = $up->execute([':vin' => $vin]);
				
				if ($updateResult) {
					// Commit the transaction
					$this->connection->commit();
					
					// Fetch the updated data
					$fetchQuery = "SELECT * FROM cars_images WHERE vin = :vin ORDER BY imageorder";
					$fetchStmt = $this->connection->prepare($fetchQuery);
					$fetchStmt->execute([':vin' => $vin]);
					$updatedData = $fetchStmt->fetchAll(PDO::FETCH_ASSOC);
					
					return [
					'success' => true,
					'data' => $updatedData,
					'message' => 'Image order updated successfully.'
					];
				} 
				else 
				{
					return [
					'success' => false,
					'message' => 'Failed to update image order.'
					];
				}
				} catch (Exception $e) {
				// Rollback the transaction if something failed
				$this->connection->rollBack();
				return [
				'success' => false,
				'message' => 'Failed to update image order: ' . $e->getMessage()
				];
			}
		}
		
		// DELETE CAR IMAGES.
		public function deleteCarImages($data)
		{
			$imageData = array();
			$deleteSql = 'DELETE FROM cars_images WHERE vin = :vin AND imagename = :img';
			$del = $this->connection->prepare($deleteSql);
			$deleteResult = $del->execute([':vin' => $data['vin'], ':img' => $data['fileName']]);
			
			if ($deleteResult) {
				// Reorder sequentially using prepared updates
				$fetch = $this->connection->prepare('SELECT imagename FROM cars_images WHERE vin = :vin ORDER BY imageorder');
				$fetch->execute([':vin' => $data['vin']]);
				$imgs = $fetch->fetchAll(PDO::FETCH_COLUMN, 0);
				$idx = 1;
				$updateResult = true;
				$upd = $this->connection->prepare('UPDATE cars_images SET imageorder = :ord WHERE vin = :vin AND imagename = :img');
				foreach ($imgs as $img) {
					$ok = $upd->execute([':ord' => $idx, ':vin' => $data['vin'], ':img' => $img]);
					if (!$ok) { $updateResult = false; break; }
					$idx++;
				}
				
				if ($updateResult) {
					$imageData = $this->getImagesByVin($data["vin"]);
					return $imageData;
					} else {
					return $imageData;
				}
				} else {
				return $imageData;
			}
		}
		
		// DELETE CAR IMAGES.
		public function deleteProfileLogo($data)
		{
			$imageData = array();
			$deleteSql = 'UPDATE admin SET business_logo = "" WHERE admin_id = :user_id';
			$del = $this->connection->prepare($deleteSql);
			$deleteResult = $del->execute([':user_id' => $data['user_id']]);
			
			if ($deleteResult) {
				return true;
			} else {
				return false;
			}
		}
		
		// GET IMAGES BY PARAM VIN.
		public function getImagesByVin($vin)
		{
			$sql = 'SELECT * FROM cars_images WHERE vin = :vin ORDER BY imageorder';
			$stmt = $this->connection->prepare($sql);
			$stmt->execute([':vin' => $vin]);
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			return $rows;
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
		
		public function insertIntoSale($data)
		{
			$response = array();
			
			if($data["vin"] != '' && $data["buyername"] != '' && $data["email"] != '' && $data["phone"] != '' && $data["sale_price"] != '')  
			{
				// BUYER ADD OR UPDATE
				$userSql = "SELECT * FROM users WHERE email = :email OR phone = :phone";
				$userStmt = $this->connection->prepare($userSql);
				$userStmt->execute([':email' => $data['email'], ':phone' => $data['phone']]);
				$userRow = $userStmt->fetch(PDO::FETCH_ASSOC);
				
				// IF USER FOUND
				if ($userRow) {
					// SET THE OWNER ID
					$buyer_id = $userRow['user_id'];
					// UPDATE USER INFO
					$updateUserSql = "UPDATE users SET name = :name, email = :email, phone = :phone, address = :address WHERE user_id = :user_id";
					$upd = $this->connection->prepare($updateUserSql);
					$upd->execute([':name' => $data['buyername'], ':email' => $data['email'], ':phone' => $data['phone'], ':address' => $data['address'], ':user_id' => $buyer_id]);
				} else {
					$insertUserSql = 'INSERT INTO users (name, email, phone, address) VALUES (:name, :email, :phone, :address)';
					$ins = $this->connection->prepare($insertUserSql);
					$insertUserResult = $ins->execute([':name' => $data['buyername'], ':email' => $data['email'], ':phone' => $data['phone'], ':address' => $data['address']]);
					// SET THE OWNER ID
					$buyer_id = $this->connection->lastInsertId();
				}
				
				$selectSql = "SELECT * FROM cars_listings WHERE vin = :vin";
				$stmt = $this->connection->prepare($selectSql);
				$stmt->execute([':vin' => $data['vin']]);
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$owner_id = $row['owner_id'];
				$owner_price = $row['owner_price'];
				
				// INSERT CASE
				$insertSql = "INSERT INTO cars_sale (vin, owner_id, buyer_id, owner_price, sale_price, saledate) VALUES (:vin, :owner_id, :buyer_id, :owner_price, :sale_price, NOW())";
				$insSale = $this->connection->prepare($insertSql);
				$insertResult = $insSale->execute([':vin' => $data['vin'], ':owner_id' => $owner_id, ':buyer_id' => $buyer_id, ':owner_price' => $owner_price, ':sale_price' => $data['sale_price']]);
				
				if ($insertResult) {
					// UPDATE CAR
					$updateSql = "UPDATE cars_listings SET owner_id = :buyer_id, status = 'SOLD OUT' WHERE vin = :vin";
					$upd2 = $this->connection->prepare($updateSql);
					$upd2->execute([':buyer_id' => $buyer_id, ':vin' => $data['vin']]);
					
					$response['message'] = 'Inserted successfully.';
					$response['owner_id'] = $owner_id;
					$response['buyer_id'] = $buyer_id;
					$response['vin'] = $data["vin"];
					$response['success'] = true;
					return $response;
				} else {
					$response['message'] = 'Insertion failed.';
					$response['success'] = false;
					return $response;
				}
				
			} else {
				$response['message'] = 'Please, fill the basic details.';
				$response['success'] = false;
				return $response;
			}
		}
		
		public function getSaleDetailsByVIN($vin)
		{
			$query = "SELECT * FROM cars_sale WHERE vin = :vin ORDER BY saledate DESC";
			$stmt = $this->connection->prepare($query);
			$stmt->execute([':vin' => $vin]);
			$rows = $stmt->fetch(PDO::FETCH_ASSOC);
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
	}	