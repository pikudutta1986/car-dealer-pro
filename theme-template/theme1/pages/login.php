<?php 

$errorMessage = '';
if (isset($_SESSION['agent_id']) && $_SESSION['agent_id'] != '') {
    ?>
    <script>
        window.location = '<?php echo $SITE_URL;?>/agent/dashboard.php';
    </script>
    <?php
    exit();
}

$successMessage = '';
if (isset($_GET['reset']) && $_GET['reset'] == 'success') {
    $successMessage = "Your password has been successfully reset.";
}

if (isset($_POST['login_btn'])) {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    if (empty($email) || empty($password)) {
        $errorMessage = "Please enter both email and password.";
    } else {
        try {
            $query = "SELECT * FROM agent WHERE email = :email LIMIT 1";
            $stmt = $dbObject->prepare($query);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                // Verify password
                if ($user['password'] === md5($password)) {
                    $_SESSION['agent_id'] = $user['agent_id'];
                    $_SESSION['agent_name'] = $user['name'];
                    $_SESSION['agent_email'] = $user['email'];
                    $_SESSION['agent_type'] = $user['account_type'];
                    
                    // Redirect to add-car page after login
                    ?>
                    <script>
                        window.location = '<?php echo $SITE_URL;?>/agent/add-car.php';
                    </script>
                    <?php
                    exit();
                } else {
                    $errorMessage = "Invalid email or password.";
                }
            } else {
                $errorMessage = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            $errorMessage = "An error occurred. Please try again.";
        }
    }
}
?>
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option set-bg" data-setbg="<?php echo $SITE_URL?>/theme-template/theme1/img/breadcrumb-bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Login to your account</h2>
                    <div class="breadcrumb__links">
                        <a href="<?php echo $SITE_URL?>"><i class="fa fa-home"></i> Home</a>
                        <span>Login</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Login Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="contact__form">
                <div class="text-center">
                    <?php if ($errorMessage != '') { ?>
                        <div class="error-message mb-2 btn-danger" style="border-radius: 5px; color: white; margin-bottom: 20px; padding: 3px;"><?php echo $errorMessage;?></div>
                    <?php } ?>
                    <?php if ($successMessage != '') { ?>
                        <div class="success-message mb-2 btn-success" style="border-radius: 5px; color: white; margin-bottom: 20px; padding: 3px;"><?php echo $successMessage;?></div>
                    <?php } ?>
                </div>
                <form class="user login-form" method="post" action="">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control form-control-user" placeholder="Enter Email Address..." required />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-user" placeholder="Enter Password" required />
                    </div>
                    <button type="submit" class="site-btn btn-block" name="login_btn">Login</button>
                </form>
                <hr>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12" style="margin-top: 10px;">
                        <div class="text-center primary">
                            <a class="site-btn-outline btn-block" href="<?php echo $SITE_URL; ?>/forget-password">
                                Forget password?
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 10px;">
                        <div class="text-center primary">
                            <a class="site-btn-outline btn-block" href="<?php echo $SITE_URL; ?>/register">
                                Don't have an account? Register here
                            </a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Login Section End -->
