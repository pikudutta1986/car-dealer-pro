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

		
	function getAllMenuPages()
	{
		try {
			$sql = "SELECT * FROM page WHERE showonmenu = 'Y' AND status = 'Y'";
			$query = $this->connection->prepare($sql);
			$query->execute();
			$rows = $query->fetchALL(PDO::FETCH_ASSOC);
			return $rows;
		} catch (PDOException $e) {
			error_log("Error in getAllMenuPages: " . $e->getMessage());
			return array();
		}
	}
	
	public function getAdminHomePageSettings()
	{
		try {
			$query = "SELECT * FROM homepage_setting WHERE id = 1";
			$stmt = $this->connection->prepare($query);
			$stmt->execute();
			$homepageData = $stmt->fetch(PDO::FETCH_ASSOC);
			
			return $homepageData;
		} catch (PDOException $e) {
			error_log("Error in getAdminHomePageSettings: " . $e->getMessage());
			return false;
		}
	}
		
	}	