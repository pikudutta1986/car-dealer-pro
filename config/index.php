<?php 
// SET THE SITE ROOT
$SITE_ROOT = str_replace('config', '', __DIR__);

function loadEnv($path) 
{
    if (!file_exists($path)) 
    {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) 
    {
        if (str_starts_with(trim($line), '#')) 
        {
            continue;
        }
        
        if (strpos($line, '=') === false) 
        {
            continue;
        }
        
        $parts = explode('=', $line, 2);
        if (count($parts) !== 2) 
        {
            continue;
        }
        
        list($name, $value) = $parts;
        putenv("$name=$value");
        $_ENV[$name] = $value;
    }
}

// LOAD THE ENV
loadEnv($SITE_ROOT .'/.env');

// SET YOUR WEBSITE URL HERE
$SITE_URL = $_ENV['SITE_URL'] ?? '';

// YOUR DATABASE HOST
$DB_HOST  = $_ENV['DB_HOST'] ?? 'localhost';

// YOUR DATABASE USERNAME
$DB_USERNAME = $_ENV['DB_USERNAME'] ?? 'root';

// YOUR DATABASE PASSWORD
$DB_PASSWORD = $_ENV['DB_PASSWORD'] ?? '';

// YOUR DATABASE NAME
$DB_NAME = $_ENV['DB_NAME'] ?? '';

// FUEL TYPE LIST
$FUEL_TYPES = array('Diesel', 'Petrol','Electric', 'Gas', 'Hybrid', 'Other');

// TRANSMISSION LIST
$TRANSMISSION = array('Automatic', 'Manual');

// MILEAGE LIST
$MILEAGE_ARRAY = array('10000', '20000','30000','40000','50000','60000','70000','80000','90000','100000');

/////////////////////////////// DO NOT EDIT BELOW CODE ///////////////////////////////////

// OPEN THIS FILE TO SET DATABASE CONNECTION
include("database.php");

// STORE THE WEBSITE INFO GLOBALLY
$database = new Database($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$dbObject = $database->getConnection();

// SAVE BUSINESS INFO
if (isset($_POST['save_business_info'])) 
{
    $username = (trim($_POST['username'])) ? trim($_POST['username']) : '';
    $email = (trim($_POST['email'])) ? trim($_POST['email']) : '';
    $phone = (trim($_POST['phone'])) ? trim($_POST['phone']) : '';
    $businessname = (trim($_POST['businessname'])) ? trim($_POST['businessname']) : '';
    $address = (trim($_POST['address'])) ? trim($_POST['address']) : '';
    $city = (trim($_POST['city'])) ? trim($_POST['city']) : '';
    $state = (trim($_POST['state'])) ? trim($_POST['state']) : '';
    $country = (trim($_POST['country'])) ? trim($_POST['country']) : '';
    $zip = (trim($_POST['zip'])) ? trim($_POST['zip']) : '';
    $currency = (trim($_POST['currency'])) ? trim($_POST['currency']) : '$';
    $distance_unit = (trim($_POST['distance_unit'])) ? trim($_POST['distance_unit']) : 'KM';
    
    $updateSql = 'UPDATE admin SET 
    username = :username, 
    email = :email, 
    phone = :phone, 
    city = :city, 
    state = :state, 
    country = :country, 
    address = :address, 
    zip = :zip, 
    businessname = :businessname,
    currency = :currency,
    distance_unit = :distance_unit
    WHERE admin_id = :admin_id';
    
    $stmt = $dbObject->prepare($updateSql);
    $updateResult = $stmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':phone' => $phone,
        ':city' => $city,
        ':state' => $state,
        ':country' => $country,
        ':address' => $address,
        ':zip' => $zip,
        ':businessname' => $businessname,
        ':currency' => $currency,
        ':distance_unit' => $distance_unit,
        ':admin_id' => $_SESSION['user_id']
    ]);
    
    if ($updateResult) {
        $_SESSION['username'] = $username;
        $profileMessage = 'Profile information updated successfully.';
    }

    // REDIRECT TO PASSWORD SET PAGE IF PASSWORD NOT UPDATED YET
    $adminSql = "SELECT password_changed FROM admin WHERE 1";
    $adminStmt = $dbObject->prepare($adminSql);
    $adminStmt->execute();
    $adminData = $adminStmt->fetch(PDO::FETCH_ASSOC);
    $password_changed = $adminData['password_changed'];
    if ($password_changed == 'N') {
        header("Location: ".$SITE_URL."/admin/settings.php?tab=password");
    }
    
}


if(isset($_POST['set_password_btn'])) {
    $new_password = (trim($_POST['new_password'])) ? trim($_POST['new_password']) : '';
    $confirm_password = (trim($_POST['confirm_password'])) ? trim($_POST['confirm_password']) : '';
    
    if (empty($new_password) || empty($confirm_password)) {
        $setPasswordMessage = 'Password fields must not be blank.';
    } else {
        if($new_password == $confirm_password) {
            $passwordUpdateQuery = "UPDATE admin SET password_changed = 'Y', password = :password WHERE admin_id = 1";
            $stmt = $dbObject->prepare($passwordUpdateQuery);
            $updateResult = $stmt->execute([':password' => password_hash($new_password, PASSWORD_DEFAULT)]);
            
            if($updateResult) {
                header("Location: ".$SITE_URL."/admin/dashboard.php");
            }else {
                $setPasswordMessage = 'Error occured during password change.';
            }
        }else {
            $setPasswordMessage = 'Passwords do not match.';
        }
    }
    
}

// GET WEBSITE INFO FROM DATABASE
$siteinfoSql = "SELECT password_changed, email, phone, businessname, business_logo, address, city, state, 
country, zip, currency, distance_unit, current_theme FROM admin WHERE admin_id = 1";
$siteinfoQuery = $dbObject->prepare($siteinfoSql);
$siteinfoQuery->execute();
$SITE_INFO = $siteinfoQuery->fetch(PDO::FETCH_ASSOC);

// SET YOUR SITE NAME HERE
$SITE_NAME = ($SITE_INFO['businessname']) ? $SITE_INFO['businessname'] : "Auto Dealers";

$SITE_LOGO = ($SITE_INFO['business_logo'] && file_exists($SITE_ROOT.'uploaded-images/'.$SITE_INFO['business_logo'])) ? $SITE_URL.'/uploaded-images/'.$SITE_INFO['business_logo'] : $SITE_URL.'/assets/images/logo.png';

$SITE_CURRENCY = $SITE_INFO['currency'];

$DISTANCE_UNIT = $SITE_INFO['distance_unit'];

$BOOTSPACE_UNIT = 'Liter';

$GROUND_CLEARANCE_UNIT = 'mm';

// GET ACTIVE THEME FROM
$ACTIVE_THEME = ($SITE_INFO['current_theme']) ? $SITE_INFO['current_theme'] : "theme1";

/////////////////////////////// DO NOT EDIT ABOVE CODE ///////////////////////////////////



