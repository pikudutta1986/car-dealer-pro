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

$errorMessage = '';
$token = $_REQUEST['token'];

// Check if the token is valid and not expired
$query = 'SELECT * FROM agent WHERE password_reset_token = :token';
$stmt = $dbObject->prepare($query);
$stmt->execute([':token' => $token]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $agent_id = $row['agent_id'];

    if (isset($_POST['set_password_btn'])) {
    
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];

        if ($password !== $confirmpassword) {
            $errorMessage = 'Password do not match.';
        } else {
            // UPDATE THE USER'S PASSWORD IN THE DATABASE.
            $updateQuery = 'UPDATE agent SET password = :password, password_reset_token = NULL WHERE agent_id = :agent_id';
            $stmt2 = $dbObject->prepare($updateQuery);
            $updateResult = $stmt2->execute([':password' => md5($password), ':agent_id' => $agent_id]);
            if ($updateResult) {
                // REDIRECT TO THE SUCCESS PAGE.

                ?>
                <script>
                    window.location = '<?php echo $SITE_URL;?>/login?reset=success';
                </script>
                <?php
                exit();
            } else {
                $errorMessage = 'Failed to reset password. Please try again.';
            }
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
                    <h2>Set New Password</h2>
                    <div class="breadcrumb__links">
                        <a href="<?php echo $SITE_URL?>"><i class="fa fa-home"></i> Home</a>
                        <span>Set New Password</span>
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
                <?php if ($row) { ?>
                <div class="text-center">
                    <?php if ($errorMessage != '') { ?>
                        <div class="error-message mb-2 btn-danger" style="border-radius: 5px; color: white; margin-bottom: 20px; padding: 3px;"><?php echo $errorMessage; ?></div>
                    <?php } ?>
                </div>
                <form class="user" method="post" action="">
                    <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter new password" required />
                    </div>
                    <div class="form-group">
                        <input type="password" name="confirmpassword" class="form-control form-control-user" id="exampleInputPassword" placeholder="Enter confirm password" required />
                    </div>
                    <button type="submit" class="site-btn btn-block" name="set_password_btn">Set Password</button>
                </form>
                <?php } else { ?>
                    <p>This is an invalid link!<br><a style="color: blue; text-decoration: underline;" href="<?php echo $SITE_URL; ?>/admin/forget-password.php">Please send new password reset link</a>.</p>
                <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Login Section End -->