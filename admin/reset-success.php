<?php 
session_start();
include("../config/index.php");

// Database connection


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $SITE_NAME;?> | Admin Reset Success</title>
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
                            <div class="col-lg-6 logo-div d-none d-lg-block bg-login-image">
                                <img src="<?php echo $SITE_URL; ?>/assets/images/logo.png" alt="Autobuyers logo"/>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-7">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Password reset</h1>
                                        <div class="mb-2 text-success">Your password has been successfully reset.</div>
                                    </div>               
                                    <a href="<?php echo $SITE_URL; ?>/admin/login.php" class="btn btn-primary btn-user btn-block">Back to login</a>
                                    <hr>
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