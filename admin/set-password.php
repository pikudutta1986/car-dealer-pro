<?php
session_start();
include("../config/index.php");

$errorMessage = '';
if (isset($_SESSION['username']) && $_SESSION['username'] != '') {
    header("Location: ".$SITE_URL."/admin/dashboard.php");
    die();
}

$errorMessage = '';
$token = $_REQUEST['token'];

// Check if the token is valid and not expired
$query = 'SELECT * FROM admin WHERE password_reset_token = :token';
$stmt = $dbObject->prepare($query);
$stmt->execute([':token' => $token]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $admin_id = $row['admin_id'];

    if (isset($_POST['set_password_btn'])) {
    
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];

        if ($password !== $confirmpassword) {
            $errorMessage = 'Password do not match.';
        } else {
            // UPDATE THE USER'S PASSWORD IN THE DATABASE.
            $updateQuery = 'UPDATE admin SET password = :password, password_reset_token = NULL WHERE admin_id = :admin_id';
            $stmt2 = $dbObject->prepare($updateQuery);
            $updateResult = $stmt2->execute([':password' => md5($password), ':admin_id' => $admin_id]);
            if ($updateResult) {
                // REDIRECT TO THE SUCCESS PAGE.
                header("Location: ".$SITE_URL."/admin/reset-success.php");
                exit();
            } else {
                $errorMessage = 'Failed to reset password. Please try again.';
            }
        }
        
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $SITE_NAME;?> | Admin Login</title>
    <!-- Custom styles for this template-->
    <link href="<?php echo $SITE_URL; ?>/admin/assets/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?php echo $SITE_URL; ?>/admin/assets/custom.css" rel="stylesheet">

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
                                    <?php if ($row) { ?>
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Set New Password</h1>
                                        <div class="error-message mb-2"><?php echo $errorMessage; ?></div>
                                    </div>
                                    <form class="user" method="post" action="">
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter new password" required />
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="confirmpassword" class="form-control form-control-user" id="exampleInputPassword" placeholder="Enter confirm password" required />
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" name="set_password_btn" value="Set Password">
                                    </form>
                                    <?php } else { ?>
                                        <p>This is an invalid link!<br><a style="color: blue; text-decoration: underline;" href="<?php echo $SITE_URL; ?>/admin/forget-password.php">Please send new password reset link</a>.</p>
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

</html>