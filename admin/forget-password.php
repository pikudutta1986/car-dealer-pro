<?php
session_start();
include("../config/index.php");
include('../class/MailClass.php');
$mailClass = new MailClass($dbObject, $SITE_NAME, $SITE_LOGO);

$errorMessage = '';
$successMessage = '';
if (isset($_SESSION['username']) && $_SESSION['username'] != '') 
{
    header("Location: ".$SITE_URL."/admin/dashboard.php");
    exit();
}

if (isset($_POST['password_btn'])) 
{

    $emailquery = "SELECT * FROM email_setting WHERE id = 1";
    $email_stmt = $dbObject->prepare($emailquery);
    $email_stmt->execute();
    $email_setting = $email_stmt->fetch(PDO::FETCH_ASSOC);

    if 
    (
        $email_setting && 
        $email_setting['username'] != '' &&
        $email_setting['password'] != '' && 
        $email_setting['smtp_host'] != '' && 
        $email_setting['smtp_port'] != ''
    ) 
    {
        $email = $_POST['email'];

        $query = "SELECT * FROM admin WHERE email = :email";
        $stmt = $dbObject->prepare($query);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $emailResult = $mailClass->sentResetPasswordMail($user['admin_id'], $email, $SITE_URL);
            if ($emailResult['success']) {
                $successMessage = 'Password reset link is sent to your email.';
            } else {
                $errorMessage = $emailResult['message'];
            }
        }
        else
        {
            $errorMessage = "This email is not registered";
        }
    }
    else
    {
        $errorMessage = "Your email sending setting is not configured!";
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
    <title><?php echo $SITE_NAME;?> | Forgot Password</title>
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
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Forgot Password</h1>
                                        <div class="error-message mb-2"><?php echo $errorMessage; ?></div>
                                        <div class="success-message mb-2"><?php echo $successMessage; ?></div>
                                    </div>
                                    <?php if ($successMessage == '') { ?>
                                    <form class="user" method="post" action="">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Enter email address..." required />
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" name="password_btn" value="Send Password Reset Link">
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="text-right primary">
                                                    <a href="<?php echo $SITE_URL; ?>/admin/login.php">
                                                        Go back to Login
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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