<?php
$changePasswordMessage = '';
if(isset($_POST['change_password_btn'])) {
    $current_password = (trim($_POST['current_password'])) ? trim($_POST['current_password']) : '';
    $new_password = (trim($_POST['new_password'])) ? trim($_POST['new_password']) : '';
    $confirm_password = (trim($_POST['confirm_password'])) ? trim($_POST['confirm_password']) : '';
    
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $changePasswordMessage = 'Password fields must not be blank.';
    } else {
        
        if($new_password == $confirm_password) {
            // Fetch admin and verify with password_verify, fallback to md5 then upgrade
            $userQuery = "SELECT * FROM admin WHERE admin_id = :admin_id";
            $userStmt = $dbObject->prepare($userQuery);
            $userStmt->execute([':admin_id' => $_SESSION['user_id']]);
            $userRow = $userStmt->fetch(PDO::FETCH_ASSOC);
            $ok = false;
            if ($userRow) {
                $stored = $userRow['password'];
                if (strlen($stored) >= 60 && (strpos($stored, '$2y$') === 0 || strpos($stored, '$argon2') === 0)) {
                    $ok = password_verify($current_password, $stored);
                } else if ($stored === md5($current_password)) {
                    $ok = true;
                }
            }
            
            if($userRow && $ok) {
                $passwordUpdateQuery = "UPDATE admin SET password = :password WHERE admin_id = :admin_id";
                $stmt = $dbObject->prepare($passwordUpdateQuery);
                $updateResult = $stmt->execute([':password' => password_hash($new_password, PASSWORD_DEFAULT), ':admin_id' => $userRow['id']]);
                
                if($updateResult) {
                    $success = true;
                    $changePasswordMessage = 'Password changed successfully.';
                }else {
                    $changePasswordMessage = 'Error occured during password change.';
                }
                
            }else {
                $changePasswordMessage = 'Your current password is wrong.';
            }
        }else {
            $changePasswordMessage = 'Passwords do not match.';
        }
    }
}

?>
<div class="card">
    <div class="card-body">
        <form method="post" action="" id="password-form" class="password-form">
            <div class="change-password-form-container">
                <div class="<?php echo $success ? 'text-success' : 'text-danger'; ?> mb-3 height-25"><?php echo $changePasswordMessage; ?></div>
                <?php if ($SITE_INFO['password_changed'] == 'Y') { ?>
                <h5>Change password:</h5>
                <div class="form-floating mb-5">
                    <input class="form-control" name="current_password" type="text" placeholder="" />
                    <label for="current_password">Current password</label>
                </div>
                <?php } ?>
                <?php if ($SITE_INFO['password_changed'] == 'N') { ?>
                <div class="form-floating mb-5">
                    <strong>Username: <?php echo $_SESSION['username'];?></strong> 
                </div>
                <div class="text-danger"><?php if(isset($setPasswordMessage)) echo $setPasswordMessage; ?></div>
                <?php } ?>  
                <div class="form-floating mb-5">
                    <input class="form-control" name="new_password" type="text" placeholder="" />
                    <label for="new_password">New password</label>
                </div>
                <div class="form-floating mb-5">
                    <input class="form-control" name="confirm_password" type="text" placeholder="" />
                    <label for="confirm_password">Confirm password</label>
                </div>
                <?php if ($SITE_INFO['password_changed'] == 'N') { ?>
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-dark btn-block" name="set_password_btn" value="Set New password" />
                    </div>
                <?php } ?> 
                <?php if ($SITE_INFO['password_changed'] == 'Y') { ?>
                <div class="col-md-12">
                    <input type="submit" class="btn btn-dark btn-block" name="change_password_btn" value="Change password" />
                </div>
                <?php } ?> 
            </div>
        </form>
    </div>
</div>
<style>
.change-password-form-container {
    padding: 0 20px;
    width: 300px;
}
</style>