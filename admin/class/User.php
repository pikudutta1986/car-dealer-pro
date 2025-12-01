<?php
	class User
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
		
		// GET ALL LEADS 
		public function saveSocialLinks($param)
		{
			try{
				
				$linksQuery = "SELECT * FROM social_links WHERE 1 ORDER BY id LIMIT 1";
				$linkStmt = $this->connection->prepare($linksQuery);
				$linkStmt->execute();
				$row = $linkStmt->fetch(PDO::FETCH_ASSOC);
				
				if ($row)
				{
					$updateQuery = "UPDATE social_links SET 
					fb_page_link = :fb,
					twitter_page_link = :tw,
					yt_page_link = :yt,
					insta_page_link = :ig
					WHERE id = :id";
					$updateStmt = $this->connection->prepare($updateQuery);
					$updateStmt->execute([
						':fb' => $param['fb_page_link'] ?? '',
						':tw' => $param['twitter_page_link'] ?? '',
						':yt' => $param['yt_page_link'] ?? '',
						':ig' => $param['insta_page_link'] ?? '',
						':id' => $row['id']
					]);
				}
				else{
					$insertQuery = "INSERT INTO social_links (fb_page_link, twitter_page_link, yt_page_link, insta_page_link)
					VALUES (:fb, :tw, :yt, :ig)";
					$insertStmt = $this->connection->prepare($insertQuery);
					$insertStmt->execute([
						':fb' => $param['fb_page_link'] ?? '',
						':tw' => $param['twitter_page_link'] ?? '',
						':yt' => $param['yt_page_link'] ?? '',
						':ig' => $param['insta_page_link'] ?? ''
					]);
				}
				
				$response['message'] = 'Social links saved successfully.';
				$response['success'] = true;
				return $response;
				
				} catch (Exception $e) {
				$response['message'] = 'Something went wrong.';
				$response['success'] = false;
				return $response;
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
		
		// GET ALL LEADS 
		public function getAllLeads()
		{
			$tokenQuery = "SELECT * FROM leads WHERE 1";
			$tokenStmt = $this->connection->prepare($tokenQuery);
			$tokenStmt->execute();
			$rows = $tokenStmt->fetchAll(PDO::FETCH_ASSOC);
			return $rows;
		}

		public function getAllUsers()
		{
			$tokenQuery = "SELECT * FROM users WHERE 1";
			$tokenStmt = $this->connection->prepare($tokenQuery);
			$tokenStmt->execute();
			$rows = $tokenStmt->fetchAll(PDO::FETCH_ASSOC);
			return $rows;
		}
		
		public function getAllCurrency()
		{
			$sql = "SELECT * FROM currencies ORDER BY id ASC";
			$stmt = $this->connection->prepare($sql);
			$stmt->execute();
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $rows;
		}
		
		// GET ADMIN ROW BY ID.
		public function getAdminRowById($admin_id)
		{
			$query = "SELECT * FROM admin WHERE admin_id = :admin_id";
			$stmt = $this->connection->prepare($query);
			$stmt->execute([':admin_id' => $admin_id]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($user) {
				return $user;
				} else {
				return false;
			}
		}
		
		// GET USER ROW BY EMAIL.
		public function getUserRowByEmail($email)
		{
			$query = "SELECT * FROM users WHERE email = :email";
			$stmt = $this->connection->prepare($query);
			$stmt->execute([':email' => $email]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($user) {
				return $user;
				} else {
				return false;
			}
		}
		
		// GET USER ROW BY ID.
		public function getUserRowById($user_id)
		{
			$query = "SELECT * FROM users WHERE user_id = :user_id";
			$stmt = $this->connection->prepare($query);
			$stmt->execute([':user_id' => $user_id]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($user) {
				return $user;
				} else {
				return false;
			}
		}
		
		// GET USER ROW BY USERNAME.
		public function getUserRowByUsername($username)
		{
			$query = "SELECT * FROM users WHERE username = :username OR email = :username";
			$stmt = $this->connection->prepare($query);
			$stmt->execute([':username' => $username]);
			$user = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($user) {
				return $user;
				} else {
				return false;
			}
		}
		
		// GET CURRENT TOKEN IF NOT EXPIRED.
		public function getCurrentToken($user_id)
		{
			$tokenQuery = "SELECT token FROM cars_reset_password WHERE user_id = :user_id ORDER BY id DESC LIMIT 1";
			$tokenStmt = $this->connection->prepare($tokenQuery);
			$tokenStmt->execute([':user_id' => $user_id]);
			$resetToken = $tokenStmt->fetch(PDO::FETCH_ASSOC);
			
			if ($resetToken) {
				return $resetToken['token'];
				} else {
				return false;
			}
		}
		
		// GENERATE TOKEN TO RESET PASSWORD.
		public function generateToken($user_id)
		{
			// GENERATE RESET TOKEN
			$token = bin2hex(random_bytes(50));
			$expires_at = date("Y-m-d H:i:s", strtotime('+1 hour'));
			
			// STORE TOKEN IN THE DATABASE.
			$insertQuery = 'INSERT INTO cars_reset_password (user_id, token, expires_at) VALUES (:user_id, :token, :expires_at)';
			$insertStmt = $this->connection->prepare($insertQuery);
			$result = $insertStmt->execute([
				':user_id' => $user_id,
				':token' => $token,
				':expires_at' => $expires_at
			]);
			
			if ($result) {
				return $token;
				} else {
				return false;
			}
		}
		
		// CHECK IF THE TOKEN HAS EXPIRED.
		public function isTokenExpired($user_id)
		{
			$tokenQuery = "SELECT * FROM cars_reset_password WHERE user_id = :user_id ORDER BY id DESC LIMIT 1";
			$tokenStmt = $this->connection->prepare($tokenQuery);
			$tokenStmt->execute([':user_id' => $user_id]);
			$resetToken = $tokenStmt->fetch(PDO::FETCH_ASSOC);
			
			// CHECK IF THE TOKEN IS EXPIRED.
			$isTokenExpired = false;
			if ($resetToken) {
				$expires_at = strtotime($resetToken['expires_at']);
				$current_time = time();
				if ($current_time > $expires_at) {
					$isTokenExpired = true;
				}
			}
			
			return $isTokenExpired;
		}
		
		// SEND RESET LINK.
		public function sendResetLinkMail($email, $token, $SITE_URL)
		{
			// SEND EMAIL
			$resetLink = $SITE_URL . "/set-password.php?token=" . $token;
			$subject = "Password Reset Request";
			$message = "Please click the link below to reset your password:\n\n" . $resetLink;
			
			$fullname = "Autobuyersmarket";
			$sendermail = "forum@autobuyersmarket.com";
			
			$headers  = "From: \"" . $fullname . "\"<" . $sendermail . ">\r\nContent-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit";

			$host = $_SERVER['HTTP_HOST']; // or use $_SERVER['SERVER_NAME']

			if ($host === 'localhost' || $host === '127.0.0.1' || $host === '::1') {
				return false;
			}else{
				if (mail($email, $subject, $message, $headers)) {
					return true;
				} else {
					return false;
				}
			}
		}
		
		public function getAdminHomePageSettings()
		{
			$query = "SELECT * FROM homepage_setting WHERE id = 1";
			$stmt = $this->connection->prepare($query);
			$stmt->execute();
			$homepageData = $stmt->fetch(PDO::FETCH_ASSOC);
			
			return $homepageData;
			
		}
		
		public function saveHomepageSetting($data)
		{
			$query = "SELECT * FROM homepage_setting LIMIT 1";
			$stmt = $this->connection->prepare($query);
			$stmt->execute();
			$homepageData = $stmt->fetch(PDO::FETCH_ASSOC);
			$result = null;
			
			if(!$homepageData)
			{
				$insertQuery = 'INSERT INTO homepage_setting (banner_image, banner_heading1, banner_heading2, show_bodystyle, cargrid_heading, numberofcars, content, show_make) VALUES ("", "", "", "N", "", 0, "", "N")';
				$insertStmt = $this->connection->prepare($insertQuery);
				$insertStmt->execute();
			}
			
			if(isset($data['imgSrc']))
			{
				$insertQuery = 'UPDATE homepage_setting SET banner_image = :banner_image WHERE id = 1';
				$updateStmt = $this->connection->prepare($insertQuery);
				$result = $updateStmt->execute([':banner_image' => $data['fileName']]);
				
				if($result)
				{
					return true;
				}
				else
				{
					return false;
				}
				
			}
			else
			{
				$insertQuery = "UPDATE homepage_setting SET banner_heading1 = :h1, banner_heading2 = :h2, show_bodystyle = :show_bodystyle, cargrid_heading = :cargrid_heading, numberofcars = :numberofcars, content = :content, show_make = :show_make WHERE id = 1";
				$updateStmt = $this->connection->prepare($insertQuery);
				$result = $updateStmt->execute([
					':h1' => $data['banner_heading1'],
					':h2' => $data['banner_heading2'],
					':show_bodystyle' => $data['show_bodystyle'],
					':cargrid_heading' => $data['cargrid_heading'],
					':numberofcars' => (int)$data['numberofcars'],
					':content' => $data['content'],
					':show_make' => $data['show_make']
				]);
				
				if($result)
				{
					$response['message'] = 'Homepage setting update successfully.';
					//$response['data'] = $this->getAdminHomePageSettings();
					$response['success'] = true;
					return $response;
				}else{
					$response['message'] = 'Unable to update';
					$response['success'] = false;
					return $response;
				}
			}
			
			
		}
		
		public function deleteHomepageBannerImage()
		{
			$imageData = array();
			$deleteSql = 'UPDATE homepage_setting SET banner_image = "" WHERE id = 1';
			$deleteStmt = $this->connection->prepare($deleteSql);
			$deleteResult = $deleteStmt->execute();
			
			if ($deleteResult) {
				return true;
			} else {
				return false;
			}
		}
	}
