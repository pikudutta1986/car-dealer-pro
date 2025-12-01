<?php
class Database {
  // YOUR DATABASE HOST
  private $host  = "";
  // YOUR DATABASE USERNAME
  private $username = "";
  // YOUR DATABASE PASSWORD
  private $password = "";
  // YOUR DATABASE NAME
  private $database_name = ""; 

  public $conn;

  
	// Db connection
	public function __construct($dbhost, $dbusername, $dbpassword, $dbname)
	{
		$this->host = $dbhost;
    $this->username = $dbusername;
    $this->password = $dbpassword;
    $this->database_name = $dbname;
	}

  public function getConnection() {		

    try{
      $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
      $this->conn->exec("set names utf8");
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $exception){
        echo "Database could not be connected: " . $exception->getMessage();
    }
    return $this->conn;       
  }
}
?>
