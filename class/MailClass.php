<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $SITE_ROOT.'PHPMailer/src/Exception.php';
require $SITE_ROOT.'PHPMailer/src/PHPMailer.php';
require $SITE_ROOT.'PHPMailer/src/SMTP.php';
class MailClass
{
	// Connection instance
	private $connection;
	private $siteName;
	private $siteLogo;
	private $emailSetting;

	
	// Db connection
	public function __construct($connection, $siteName, $siteLogo)
	{
		$this->connection = $connection;
		$this->siteName = $siteName;
		$this->siteLogo = $siteLogo;

		$sql = "SELECT * FROM email_setting";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		$this->emailSetting = $stmt->fetch(PDO::FETCH_ASSOC);
	}

	// SEND EMAIL TO THE SITE OWNER ON A LEAD RECEIVED FROM CAR DETAILS
	public function sentLeadMail($request)
	{
	
		// Sanitize input
		$name = htmlspecialchars(trim($request['name']));
		$email = htmlspecialchars(trim($request['email']));
		$phone = htmlspecialchars(trim($request['phone']));
		$message = nl2br(htmlspecialchars(trim($request['message'])));
		$vin = htmlspecialchars(trim($request['vin']));

		// Email content (HTML)
		$email_subject = "New Lead for VIN: ".$vin;

		$body = "Hi,<br>A new lead is here:<br>
			<strong>VIN:</strong> ".$vin."<br>
			<strong>Name:</strong> ".$name."<br>
			<strong>Email:</strong> ".$email."<br>
			<strong>Phone:</strong> ".$phone."<br>
			<strong>Message:</strong><br>".$message."<br>";

		$sql = "SELECT * FROM admin LIMIT 1";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$to = $row['email'];

		$emailResult = $this->sentSMTPMail($to, $email_subject, $body);
		return $emailResult;
		
	}

	// EMAIL TO SITE OWNER FROM CONTACT FORM
	public function sentContactMail($to)
	{
		$name    = htmlspecialchars($_POST['name'] ?? '');
		$email   = htmlspecialchars($_POST['email'] ?? '');
		$subject = htmlspecialchars($_POST['subject'] ?? '');
		$message = htmlspecialchars($_POST['message'] ?? '');

		// Email content (HTML)
		$email_subject = "New contact: ".$name;

		$body = "Hi,<br>New contact information received:<br>
			<strong>Name:</strong> ".$name."<br>
			<strong>Email:</strong> ".$email."<br>
			<strong>Subject:</strong> ".$subject."<br>
			<strong>Message:</strong><br>".$message."<br>";

		$sql = "SELECT * FROM admin LIMIT 1";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$to = $row['email'];

		$emailResult = $this->sentSMTPMail($to, $email_subject, $body);
		return $emailResult;
	}
	
	// SEND EMAIL TO THE OWNER ON CAR ADDED
	public function sentMailtoCarAdd($owner_name, $owner_email)
	{
		$subject = 'Your car is added to our inventory';
		$message = 'Hi '.$owner_name.', <br>Congratulation! Your car added is added to our inventory.<br><br>Thank you<br>'.$this->siteName;
		$return_message = '';

		// IF "Send email to the car owner on car added to the inventory." IS CHECKED FROM ADMIN
		if($this->emailSetting && $this->emailSetting['send_add_inventory'] == 'Y')
		{
			$emailResult = $this->sentSMTPMail($owner_email, $subject, $message);
			return $emailResult;
		}
	}

	//  SEND EMAIL TO THE OWNER ON CAR SOLD OUT
	public function sentMailtoOwnerOnCarSale($owner_id, $vin)
	{	
		// IF "Send email to the car owner on car sold out from the inventory." IS CHECKED FROM ADMIN
		if($this->emailSetting && $this->emailSetting['send_sold_out'] == 'Y')
		{
			$userSql = "SELECT * FROM users WHERE user_id = :uid";
			$userStmt = $this->connection->prepare($userSql);
			$userStmt->execute([':uid' => $owner_id]);
			$userRow = $userStmt->fetch(PDO::FETCH_ASSOC);

			$subject = 'Your car is sold';
			$message = 'Hi '.$userRow['name'].', <br>Congratulation! Your car is sold out.<br><br>Thank you<br>'.$this->siteName;
			
			$emailResult = $this->sentSMTPMail($userRow['email'], $subject, $message);
			return $emailResult;
		}
	}

	//  SEND EMAIL TO THE BUYER ON CAR SOLD OUT
	public function sentMailtoBuyerOnCarSale($buyer_id, $vin)
	{
		// IF "Send email to the car owner on car sold out from the inventory." IS CHECKED FROM ADMIN
		if($this->emailSetting && $this->emailSetting['send_sold_out_buyer'] == 'Y')
		{
			$userSql = "SELECT * FROM users WHERE user_id = :uid";
			$userStmt = $this->connection->prepare($userSql);
			$userStmt->execute([':uid' => $buyer_id]);
			$userRow = $userStmt->fetch(PDO::FETCH_ASSOC);

			$subject = 'Congratulation';
			$message = 'Hi '.$userRow['name'].', <br>Congratulation! Wish you to drive well and safe.<br><br>Thank you<br>'.$this->siteName;
			
			$emailResult = $this->sentSMTPMail($userRow['email'], $subject, $message);
			return $emailResult;
		}
	}

		
	public function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[random_int(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function sentResetPasswordMail($admin_id, $to, $site_url)
	{
		$email_subject = 'Reset your password';
		$randomString = $this->generateRandomString(16);
		$sql = "UPDATE admin SET password_reset_token = :token WHERE admin_id = :admin_id";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([':token' => $randomString, ':admin_id' => $admin_id]);
		$password_link = $site_url.'/admin/set-password.php?token='.$randomString;

		$body = 'Hi, <br>Click on the link below to set new password:<br><a target="_blank" href="'.$password_link.'">'.$password_link.'</a><br><br>Thank you<br>'.$this->siteName;

		$emailResult = $this->sentSMTPMail($to, $email_subject, $body);
		return $emailResult;
	}

	public function sentResetPasswordMailForAgent($agent_id, $to, $site_url)
	{
		$email_subject = 'Reset your password';
		$randomString = $this->generateRandomString(16);
		$sql = "UPDATE agent SET password_reset_token = :token WHERE agent_id = :agent_id";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([':token' => $randomString, ':agent_id' => $agent_id]);
		$password_link = $site_url.'/set-password/'.$randomString;

		$body = 'Hi, <br>Click on the link below to set new password:<br><a target="_blank" href="'.$password_link.'">'.$password_link.'</a><br><br>Thank you<br>'.$this->siteName;

		$emailResult = $this->sentSMTPMail($to, $email_subject, $body);
		return $emailResult;
	}
	
	// SEND EMAIL
	public function sentSMTPMail($to, $subject, $message)
	{
		if(
			$this->emailSetting && 
			$this->emailSetting['smtp_host'] != '' &&
			$this->emailSetting['smtp_port'] != '' &&
			$this->emailSetting['username'] != '' &&
			$this->emailSetting['password'] != ''
		)
		{
			//Create an instance; passing `true` enables exceptions	
			$mail = new PHPMailer(true);

			try {
				//Server settings
				$mail->isSMTP();                                        //Send using SMTP
				$mail->Host       = $this->emailSetting['smtp_host'];   //Set the SMTP server to send through
				$mail->SMTPAuth   = true;                        		//Enable SMTP authentication
				$mail->Username   = $this->emailSetting['username'];    //SMTP username
				$mail->Password   = $this->emailSetting['password'];    //SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 		//Enable implicit TLS encryption
				$mail->Port       = $this->emailSetting['smtp_port'];   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

				//Recipients
				$mail->setFrom($this->emailSetting['username'], $this->siteName);
				$mail->addAddress($to);     							//Add a recipient

				//Content
				$mail->isHTML(true);                                     //Set email format to HTML
				$mail->Subject = $subject;
				$mail->Body    = $message;
				$mail->AltBody = $message;
				$mail->send();
				return array('success' => true, 'message' => 'Email sent successfully');
			} catch (Exception $e) {
				return array('success' => false, 'message' => 'Email sending failed: ' . $e->getMessage());
			}
		}
		else
		{
			return array('success' => false, 'message' => 'Email setting is not configured');
		}
	}
	
}		