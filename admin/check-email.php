<?php 
session_start();
include("../config/index.php");
if($_SESSION['username'] =='')
{
    header("Location: ".$SITE_URL."/admin/login.php");
    die();
}

include("./class/User.php");
$user = new User($dbObject);


if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $userData = $user->getUserRowById($user_id);

    if ($userData) {
        $isTokenExpired = $user->isTokenExpired($userData['id']);
        $token = null;

        if ($isTokenExpired) {
            // TOKEN IS EXPIRED AND GENERATE NEW TOKEN.
            $token = $user->generateToken($userData['id']);
            if ($token) {
                $isMailSent = $user->sendResetLinkMail($userData['email'], $token, $SITE_URL);
                if ($isMailSent) {
                    $successMessage = 'A new reset link has been sent to your email.';
                } else {
                    $errorMessage = 'Failed to send the email. Please try again.';
                }
            } else {
                $errorMessage = 'Failed to generate a new token. Please try again.';
            }
        } else {
            // TOKEN IS NOT EXPIRED SO USING SAME TOKEN.
            $token = $user->getCurrentToken($userData['id']);
            if ($token) {
                $isMailSent = $user->sendResetLinkMail($userData['email'], $token, $SITE_URL);
                if ($isMailSent) {
                    $successMessage = 'A reset link has been sent to your email.';
                } else {
                    $errorMessage = 'Failed to send the email. Please try again.';
                }
            } else {
                $errorMessage = 'Failed to retrieve the token. Please try again.';
            }
        }
    } else {
        $errorMessage = "User not found.";
    }
} else {
    $errorMessage = "Invalid user ID.";
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
    <title><?php echo $SITE_NAME;?></title>
    <!-- Custom styles for this template-->
    <link href="<?php echo $SITE_URL; ?>/assets/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?php echo $SITE_URL; ?>/assets/custom.css" rel="stylesheet">

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
                            <div class="col-lg-6 logo-div d-none d-lg-block bg-login-image">
                                <img src="<?php echo $SITE_URL; ?>/assets/images/logo.png" alt="Autobuyers logo"/>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-7">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Check your email</h1>
                                        <?php if (isset($successMessage)) { echo "<div class='mb-2 text-success height-25'>{$successMessage}</div>"; } ?>
                                        <?php if (isset($errorMessage)) { echo "<div class='mb-2 text-danger height-25'>{$errorMessage}</div>"; } ?>
                                        <div class="mb-2">We sent a password reset link to <?php echo $userData['email']; ?></div>
                                    </div>
                                    <form method="post" action="">
                                        <input type="submit" class="btn btn-primary btn-user btn-block" name="resend_btn" value="Resend email"/>
                                    </form>
                                        <hr>
                                        <div class="text-center">
                                            <div class="mb-1">Don't recieve the email? Click to resend</div>
                                            <a href="<?php echo $SITE_URL; ?>/login.php">
                                                <- Back to login
                                            </a>
                                        </div>
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