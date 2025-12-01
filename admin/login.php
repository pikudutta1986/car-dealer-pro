<?php
session_start();
include("../config/index.php");

$errorMessage = '';
if (isset($_SESSION['username']) && $_SESSION['username'] != '') {
    header("Location: ".$SITE_URL."/admin/dashboard.php");
    die();
}

try 
{
    $adminSql = "SELECT password_changed FROM admin WHERE 1";
    $adminStmt = $dbObject->prepare($adminSql);
    $adminStmt->execute();
    $adminData = $adminStmt->fetch(PDO::FETCH_ASSOC);
    $password_changed = $adminData['password_changed'];
} 
catch (PDOException $e) 
{
    error_log("Error fetching admin data: " . $e->getMessage());
    $password_changed = 'N';
}

if (isset($_POST['login_btn'])) 
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch by username/email first
    $query = "SELECT * FROM admin WHERE (username = :username OR email = :username) LIMIT 1";
    $stmt = $dbObject->prepare($query);
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) 
    {
        $db_password = $user['password'];
        if ($db_password === md5($password)) 
        {    
            $_SESSION['user_id'] = $user['admin_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['currency'] = $user['currency'];

            $errorMessage = "Login success.";

            if ($password_changed == 'Y') 
            {
                header("Location: ".$SITE_URL."/admin/dashboard.php");
            } 
            else 
            {
                header("Location: ".$SITE_URL."/admin/settings.php?tab=profile");
            }
        } 
        else 
        {
            $errorMessage = "Username or password is not valid.";
        }
    } 
    else 
    {
        $errorMessage = "Invalid username!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <link rel="icon" href="<?php echo $SITE_LOGO;?>" type="image/png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $SITE_NAME;?> | Admin Login</title>
    <!-- Custom styles for this template-->
    <link href="<?php echo $SITE_URL; ?>/admin/assets/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?php echo $SITE_URL; ?>/admin/assets/custom.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?php echo $SITE_URL; ?>/theme-template/theme1/js/jquery-3.3.1.min.js"></script>
    <!-- Form Validation Script -->
    <script src="<?php echo $SITE_URL; ?>/js/form-validation.js"></script>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-custom">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 logo-div d-none d-lg-block bg-login-image text-center">
                                <img src="<?php echo $SITE_LOGO;?>" alt="<?php echo $SITE_NAME;?>" />
                            </div>
                            <div class="col-lg-6">
                                <div class="p-7">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        <div class="error-message mb-2"><?php echo $errorMessage;?></div>
                                    </div>
                                    <form class="user login-form" method="post" action="">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control form-control-user" id="exampleInputEmail" placeholder="Enter Username..." required />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Enter Password" required />
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" name="login_btn" value="Login">
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="text-right primary">
                                                    <a href="<?php echo $SITE_URL; ?>/admin/forget-password.php">
                                                        Forget password?
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <?php if ($password_changed == 'N') { ?>
                                    <hr>
                                    <p class="error-message">After logging in for the first time, please change username and password.</p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

	</div>

</body>

<style>
    .login-form .form-group {
        height: 70px;
    }
    .login-form .form-control {
        height: 40px;
    }
</style>

</html>