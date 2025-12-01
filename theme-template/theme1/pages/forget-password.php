<?php
include($SITE_ROOT.'class/MailClass.php');
$mailClass = new MailClass($dbObject, $SITE_NAME, $SITE_LOGO);

$errorMessage = '';
$successMessage = '';
if (isset($_SESSION['agent_id']) && $_SESSION['agent_id'] != '') 
{
    ?>
    <script>
        window.location = '<?php echo $SITE_URL;?>/agent/dashboard.php';
    </script>
    <?php
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

        $query = "SELECT * FROM agent WHERE email = :email";
        $stmt = $dbObject->prepare($query);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $emailResult = $mailClass->sentResetPasswordMailForAgent($user['agent_id'], $email, $SITE_URL);
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
<!-- Breadcrumb Begin -->
<div class="breadcrumb-option set-bg" data-setbg="<?php echo $SITE_URL?>/theme-template/theme1/img/breadcrumb-bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Forgot Password</h2>
                    <div class="breadcrumb__links">
                        <a href="<?php echo $SITE_URL?>"><i class="fa fa-home"></i> Home</a>
                        <span>Forgot Password</span>
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
                    <?php if ($errorMessage != '') { ?>
                        <div class="error-message mb-2 btn-danger" style="border-radius: 5px; color: white; margin-bottom: 20px; padding: 3px;"><?php echo $errorMessage; ?></div>
                    <?php } ?>
                    <?php if ($successMessage != '') { ?>
                        <div class="success-message mb-2 btn-success" style="border-radius: 5px; color: white; margin-bottom: 20px; padding: 3px;"><?php echo $successMessage; ?></div>
                    <?php } ?>
                    <form class="user" method="post" action="">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Enter email address..." required />
                        </div>
                        <button type="submit" class="site-btn btn-block" name="password_btn">Send Password Reset Link</button>
                    </form>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-right primary">
                                <a class="site-btn-outline btn-block" href="<?php echo $SITE_URL;?>/login">
                                    Go back to Login
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