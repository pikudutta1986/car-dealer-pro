<?php
	class Page{
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
		
		function getpageDetailsById($id)
		{
			$sql = "SELECT * FROM page WHERE page_id = :id";
			$query = $this->connection->prepare($sql);
			$query->execute([':id' => $id]);
			$row = $query->fetch(PDO::FETCH_ASSOC);
			return $row;
		}
		
		function getAllpageDetails()
		{
			$sql = "SELECT * FROM page";
			$query = $this->connection->prepare($sql);
			$query->execute();
			$rows = $query->fetchALL(PDO::FETCH_ASSOC);
			return $rows;
		}
		
		function getAllMenuPages()
		{
			$sql = "SELECT * FROM page WHERE showonmenu = 'Y' AND status = 'Y'";
			$query = $this->connection->prepare($sql);
			$query->execute();
			$rows = $query->fetchALL(PDO::FETCH_ASSOC);
			return $rows;
		}
		
		public function deletePageByid($data)
		{
			$response = array();
			$checkSql = "DELETE FROM page WHERE page_id = :page_id";
			$checkStmt = $this->connection->prepare($checkSql);
			$checkResult = $checkStmt->execute([':page_id' => $data['page_id']]);
			if ($checkResult) {
				$response['message'] = 'Delete successfully.';
				$response['success'] = true;
				return $response;
				} else {
				$response['message'] = 'Failed to delete.';
				$response['success'] = false;
				return $response;
			}
		}
		
		public function insertIntoPage($data)
		{
			$response = array();

			if($data["title"] != '') 
			{
				// UPDATE CASE
				if ($data['page_id'] && $data['page_id'] != '' && $data['page_id'] != 0) 
				{
					$makeSql = 'SELECT * FROM page WHERE page_id = :page_id';
					$makeStmt = $this->connection->prepare($makeSql);
					$makeStmt->execute([':page_id' => $data['page_id']]);
					$makeRow = $makeStmt->fetch(PDO::FETCH_ASSOC);
					
					if ($makeRow) {
						$updateSql = "UPDATE page SET title = :title, slug = :slug, showonmenu = :showonmenu, showcontactform = :showcontactform, content = :content WHERE page_id = :page_id";
						$updateStmt = $this->connection->prepare($updateSql);
						$updateResult = $updateStmt->execute([
							':title' => $data['title'],
							':slug' => $data['slug'],
							':showonmenu' => $data['showonmenu'],
							':showcontactform' => $data['showcontactform'],
							':content' => $data['content'],
							':page_id' => $data['page_id']
						]);
						
						if ($updateResult) {
							$response['edit_id'] = $data['page_id'];
							$response['message'] = 'Updated successfully.';
							$response['success'] = true;
							return $response;
							} else {
							$response['message'] = 'Updattion failed.';
							$response['success'] = false;
							return $response;
						}
					}
				}else{
					
					// Generate unique slug
					$baseSlug = $data["slug"];
					$slug = $baseSlug;
					$counter = 1;
					
					while (true) {
						$checkSql = "SELECT COUNT(*) as count FROM page WHERE slug = :slug";
						$checkStmt = $this->connection->prepare($checkSql);
						$checkStmt->execute([':slug' => $slug]);
						$checkResult = $checkStmt;
						$row = $checkResult->fetch(PDO::FETCH_ASSOC);
						
						if ($row['count'] == 0) {
							break; // Slug is unique
							} else {
							$slug = $baseSlug . '-' . $counter;
							$counter++;
						}
					}
					
					// INSERT CASE with unique slug
					$insertSql = "INSERT INTO page (title, slug, showonmenu, showcontactform, content) VALUES (:title, :slug, :showonmenu, :showcontactform, :content)";
					$insertStmt = $this->connection->prepare($insertSql);
					$insertResult = $insertStmt->execute([
						':title' => $data['title'],
						':slug' => $slug,
						':showonmenu' => $data['showonmenu'],
						':showcontactform' => $data['showcontactform'],
						':content' => $data['content']
					]);
					
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
				}
				
				} else {
				$response['message'] = 'Page title is required.';
				$response['success'] = false;
				return $response;
			}
		}
	}	