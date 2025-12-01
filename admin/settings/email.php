<?php
$formMessage  = '';
if(isset($_POST['save_email_setting'])) {
    $smtp_host = (isset($_POST['smtp_host'])) ? trim($_POST['smtp_host']) : '';
    $smtp_port = (isset($_POST['smtp_port'])) ? trim($_POST['smtp_port']) : '';
    $username = (isset($_POST['username'])) ? trim($_POST['username']) : '';
    $password = (isset($_POST['password'])) ? trim($_POST['password']) : '';

    $send_add_inventory = (isset($_POST['send_add_inventory'])) ? trim($_POST['send_add_inventory']) : 'N';
    $send_sold_out = (isset($_POST['send_sold_out'])) ? trim($_POST['send_sold_out']) : 'N';
    $send_sold_out_buyer = (isset($_POST['send_sold_out_buyer'])) ? trim($_POST['send_sold_out_buyer']) : 'N';

    
    // GET EMAIL SETTING FROM DATABASE
    $email_setting_sql = "SELECT * FROM email_setting WHERE id = 1";
    $email_setting_query = $dbObject->prepare($email_setting_sql);
    $email_setting_query->execute();
    $emailSetting = $email_setting_query->fetch(PDO::FETCH_ASSOC);

    if ($emailSetting) 
    {
        $updateSql = 'UPDATE email_setting SET 
        smtp_host = :smtp_host, 
        smtp_port = :smtp_port, 
        username = :username, 
        password = :password,
        send_add_inventory = :send_add_inventory,
        send_sold_out = :send_sold_out,
        send_sold_out_buyer = :send_sold_out_buyer
        WHERE id = 1';
        $stmt = $dbObject->prepare($updateSql);
        $result = $stmt->execute([
            ':smtp_host' => $smtp_host,
            ':smtp_port' => $smtp_port,
            ':username' => $username,
            ':password' => $password,
            ':send_add_inventory' => $send_add_inventory,
            ':send_sold_out' => $send_sold_out,
            ':send_sold_out_buyer' => $send_sold_out_buyer
        ]);
    }
    else
    {
        $insertSql = 'INSERT INTO email_setting
        (smtp_host, smtp_port, username, `password`, send_add_inventory, send_sold_out, send_sold_out_buyer)
        VALUES 
        (:smtp_host, :smtp_port, :username, :password, :send_add_inventory, :send_sold_out, :send_sold_out_buyer)';
        $stmt = $dbObject->prepare($insertSql);
        $result = $stmt->execute([
            ':smtp_host' => $smtp_host,
            ':smtp_port' => $smtp_port,
            ':username' => $username,
            ':password' => $password,
            ':send_add_inventory' => $send_add_inventory,
            ':send_sold_out' => $send_sold_out,
            ':send_sold_out_buyer' => $send_sold_out_buyer
        ]);
    }

    if($result) {
        $success = true;
        $formMessage = 'Email setting saved successfully.';
    }else {
        $formMessage = 'Error occured during email setting save.';
    }
}

// GET EMAIL SETTING FROM DATABASE
$email_setting_sql = "SELECT * FROM email_setting WHERE id = 1";
$email_setting_query = $dbObject->prepare($email_setting_sql);
$email_setting_query->execute();
$emailSetting = $email_setting_query->fetch(PDO::FETCH_ASSOC);

?>
<div class="card">
    <div class="card-body">
        <form method="post" action="" id="email-settings-form" class="email-settings-form" onsubmit="return validateDomainEmail();">
            <div class="change-password-form-container">
                <div id="email_message" class="<?php echo $success ? 'text-success' : 'text-danger'; ?> mb-3 height-25"><?php echo $formMessage; ?></div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating mb-5">
                            <input class="form-control" name="smtp_host" id="smtp_host" type="text" placeholder="" value="<?php echo $emailSetting ? $emailSetting['smtp_host'] : '';?>" />
                            <label for="smtp_host">SMTP Host</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-5">
                            <input class="form-control" name="smtp_port" id="smtp_port" type="text" placeholder="" value="<?php echo $emailSetting ? $emailSetting['smtp_port'] : '';?>" />
                            <label for="smtp_port">SMTP Port</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-floating mb-5">
                            <input class="form-control" name="username" id="username" type="text" placeholder="" value="<?php echo $emailSetting ? $emailSetting['username'] : '';?>" />
                            <label for="username">SMTP Username (Sender email)</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating mb-5">
                            <input class="form-control" name="password" id="password" type="text" placeholder="" value="<?php echo $emailSetting ? $emailSetting['password'] : '';?>" />
                            <label for="password">SMTP Password (Email password)</label>
                        </div>
                    </div>
                </div>
                
                
                <div class="row mb-4">
                    <div class="col-md-12">
                        <input type="checkbox" name="send_add_inventory" id="send_add_inventory" value="Y" <?php echo isset($emailSetting['send_add_inventory']) && $emailSetting['send_add_inventory'] == 'Y' ? 'checked' : ''; ?> /> Send email to the car owner on car added to the inventory. 
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <input type="checkbox" name="send_sold_out" id="send_sold_out" value="Y" <?php echo isset($emailSetting['send_sold_out']) && $emailSetting['send_sold_out'] == 'Y' ? 'checked' : ''; ?> /> Send email to the car owner on car sold out from the inventory. 
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-md-12">
                        <input type="checkbox" name="send_sold_out_buyer" id="send_sold_out_buyer" value="Y" <?php echo isset($emailSetting['send_sold_out_buyer']) && $emailSetting['send_sold_out_buyer'] == 'Y' ? 'checked' : ''; ?> /> Send email to the car buyer on car sold out from the inventory. 
                    </div>
                </div>
                <div class="col-md-12">
                    <input type="submit" class="btn btn-dark btn-block" name="save_email_setting" value="Save" />
                </div>
            </div>
        </form>
    </div>
</div>
<style>
.change-password-form-container {
    padding: 0 20px;
}

</style>
<script>
function isValidEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

function validateDomainEmail()
{
    var username = $('#username').val();
    $('#email_message').html('');
    if (!isValidEmail(username))
    {
        $('#email_message').html('Please enter a valid email address.');
        $('#email_message').removeClass('text-success').addClass('text-danger');
        return false;
    }
    return true;
}
</script>