<?php 
// Registration form handling
$registrationMessage = '';
$registrationSuccess = false;
$name = '';
$email = '';
$phone = '';
$address = '';
$city = '';
$state = '';
$country = '';
$zip = '';
$account_type = '';

// on registration form submit.
if (isset($_POST['register_submit'])) 
{
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $city = isset($_POST['city']) ? trim($_POST['city']) : '';
    $state = isset($_POST['state']) ? trim($_POST['state']) : '';
    $country = isset($_POST['country']) ? trim($_POST['country']) : '';
    $zip = isset($_POST['zip']) ? trim($_POST['zip']) : '';
    $account_type = isset($_POST['account_type']) ? trim($_POST['account_type']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
    
    // Validation
    if (empty($name)) {
        $registrationMessage = 'Name is required.';
    } elseif (empty($email)) {
        $registrationMessage = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $registrationMessage = 'Please enter a valid email address.';
    } elseif (empty($phone)) {
        $registrationMessage = 'Phone is required.';
    } elseif (empty($address)) {
        $registrationMessage = 'Address is required.';
    } elseif (empty($city)) {
        $registrationMessage = 'City is required.';
    } elseif (empty($state)) {
        $registrationMessage = 'State is required.';
    } elseif (empty($country)) {
        $registrationMessage = 'Country is required.';
    } elseif (empty($zip)) {
        $registrationMessage = 'ZIP code is required.';
    } elseif (empty($account_type)) {
        $registrationMessage = 'Please select an account type.';
    } elseif (empty($password)) {
        $registrationMessage = 'Password is required.';
    } elseif (strlen($password) < 8) {
        $registrationMessage = 'Password must be at least 8 characters long.';
    } elseif ($password !== $confirm_password) {
        $registrationMessage = 'Passwords do not match.';
    } else {
        // Check if email already exists
        try {
            $checkEmailSql = "SELECT * FROM agent WHERE email = :email";
            $checkEmailStmt = $dbObject->prepare($checkEmailSql);
            $checkEmailStmt->execute([':email' => $email]);
            $existingAgent = $checkEmailStmt->fetch(PDO::FETCH_ASSOC);
            
            if ($existingAgent) {
                $registrationMessage = 'This email is already registered.';
            } else {
                // Insert new agent
                $hashedPassword = md5($password);
                $insertSql = 'INSERT INTO agent (name, email, phone, address, city, state, country, zip, account_type, password, businessname, business_logo, password_reset_token, created_at) VALUES (:name, :email, :phone, :address, :city, :state, :country, :zip, :account_type, :password, :businessname, :business_logo, :password_reset_token, NOW())';
                $insertStmt = $dbObject->prepare($insertSql);
                $insertResult = $insertStmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':phone' => $phone,
                    ':address' => $address,
                    ':city' => $city,
                    ':state' => $state,
                    ':country' => $country,
                    ':zip' => $zip,
                    ':account_type' => $account_type,
                    ':password' => $hashedPassword,
                    ':businessname' => '',
                    ':business_logo' => '',
                    ':password_reset_token' => ''
                ]);
                
                if ($insertResult) {
                    $registrationSuccess = true;

                    // Clear form fields
                    $name = $email = $phone = $address = $city = $state = $country = $zip = $account_type = $password = $confirm_password = '';

                    $_SESSION['agent_id'] = $user['agent_id'];
                    $_SESSION['agent_name'] = $user['name'];
                    $_SESSION['agent_email'] = $user['email'];
                    $_SESSION['agent_type'] = $user['account_type'];
                    
                    ?>
                    <script>
                        window.location = '<?php echo $SITE_URL;?>/agent/add-car.php';
                    </script>
                    <?php
                    
                } else {
                    $registrationMessage = 'Registration failed. Please try again.';
                }
            }
        } catch (PDOException $e) {
            error_log("Database error in registration: " . $e->getMessage());
            // Show more specific error in development, generic in production
            $registrationMessage = 'An error occurred. Please try again later.';
            if (ini_get('display_errors')) {
                $registrationMessage .= ' Error: ' . htmlspecialchars($e->getMessage());
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
                    <h2>Create account to sell your car</h2>
                    <div class="breadcrumb__links">
                        <a href="<?php echo $SITE_URL?>"><i class="fa fa-home"></i> Home</a>
                        <span>Registration</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Registration Section Begin -->
<section class="contact spad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="contact__form">
                    <?php if ($registrationMessage): ?>
                        <?php if ($registrationSuccess) { ?>
                            <div class="success-message mb-2 btn-success" style="border-radius: 5px; color: white; margin-bottom: 20px; padding: 3px;"><?php echo htmlspecialchars($registrationMessage); ?></div>
                        <?php } else { ?>
                            <div class="error-message mb-2 btn-danger" style="border-radius: 5px; color: white; margin-bottom: 20px; padding: 3px;"><?php echo htmlspecialchars($registrationMessage); ?></div>
                        <?php } ?>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?php echo $SITE_URL; ?>/registration.php" id="registrationForm">
                        <!-- Personal Information Section -->
                        <h3 style="margin-bottom: 20px; color: #333; font-size: 20px; font-weight: 600; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">Personal Information</h3>
                        <div class="row">
                            <div class="col-lg-12">
                                <label style="display: block; margin-bottom: 10px; font-weight: bold; color: #333;">Account Type *</label>
                                <div style="margin-bottom: 20px;">
                                    <label style="display: inline-block; margin-right: 30px; cursor: pointer;">
                                        <input type="radio" name="account_type" class="account_type" value="individual" <?php echo (isset($account_type) && $account_type == 'individual') ? 'checked' : ''; ?> required style="margin-right: 5px;">
                                        <span>Individual</span>
                                    </label>
                                    <label style="display: inline-block; cursor: pointer;">
                                        <input type="radio" name="account_type" class="account_type" value="agent" <?php echo (isset($account_type) && $account_type == 'agent') ? 'checked' : ''; ?> required style="margin-right: 5px;">
                                        <span>Dealer</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="agentMessage" style="display: none; margin-bottom: 15px; padding: 10px; background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 5px; color: #856404;">
                            <strong>Note:</strong> Dealer accounts have additional privileges for managing multiple cars in the inventory.
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="text" name="name" id="name" placeholder="Full Name *" value="<?php echo (isset($name) && $name) ? htmlspecialchars($name) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="email" name="email" id="email" placeholder="Email Address *" value="<?php echo (isset($email) && $email) ? htmlspecialchars($email) : ''; ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <input type="tel" name="phone" id="phone" placeholder="Phone Number *" value="<?php echo (isset($phone) && $phone) ? htmlspecialchars($phone) : ''; ?>" required>
                            </div>
                        </div>
                        
                        <!-- Address Information Section -->
                        <h3 style="margin-top: 30px; margin-bottom: 20px; color: #333; font-size: 20px; font-weight: 600; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">Address Information</h3>
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="text" name="address" id="address" placeholder="Street Address *" value="<?php echo (isset($address) && $address) ? htmlspecialchars($address) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="city" id="city" placeholder="City *" value="<?php echo (isset($city) && $city) ? htmlspecialchars($city) : ''; ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="state" id="state" placeholder="State/Province *" value="<?php echo (isset($state) && $state) ? htmlspecialchars($state) : ''; ?>" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" name="country" id="country" placeholder="Country *" value="<?php echo (isset($country) && $country) ? htmlspecialchars($country) : ''; ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="zip" id="zip" placeholder="ZIP/Postal Code *" value="<?php echo (isset($zip) && $zip) ? htmlspecialchars($zip) : ''; ?>" required>
                            </div>
                        </div>
                        
                        <!-- Password Section -->
                        <h3 style="margin-top: 30px; margin-bottom: 20px; color: #333; font-size: 20px; font-weight: 600; border-bottom: 2px solid #e0e0e0; padding-bottom: 10px;">Password</h3>
                        <div class="row">
                            <div class="col-lg-12">
                                <input type="password" class="password" name="password" id="password" placeholder="Password (Minimum 8 characters) *" minlength="8" required>
                                <small style="display: block; margin-top: 5px; color: #666;">Password must be at least 8 characters long</small>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 30px;">
                            <div class="col-lg-12">
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password *" minlength="8" required>
                            </div>
                        </div>
                        
                        <button type="submit" name="register_submit" class="site-btn" style="margin-top: 20px;">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Registration Section End -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show message when agent is selected
    const accountTypeInputs = document.querySelectorAll('input[name="account_type"]');
    const agentMessage = document.getElementById('agentMessage');
    
    accountTypeInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            if (this.value === 'agent') {
                agentMessage.style.display = 'block';
            } else {
                agentMessage.style.display = 'none';
            }
        });
    });
    
    // Check if agent was already selected
    const agentSelected = document.querySelector('input[name="account_type"][value="agent"]');
    if (agentSelected && agentSelected.checked) {
        agentMessage.style.display = 'block';
    }
    
    // Password validation
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const form = document.getElementById('registrationForm');
    
    form.addEventListener('submit', function(e) {
        if (password && password.value.length < 8) {
            e.preventDefault();
            return false;
        }
        
        if (password && confirmPassword && password.value !== confirmPassword.value) {
            e.preventDefault();
            return false;
        }
    });
    
    // Real-time password match validation
    if (confirmPassword) {
        confirmPassword.addEventListener('input', function() {
            if (this.value && password && this.value !== password.value) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    }
});
</script>
<style>
.account_type{
    width: auto !important;
    height: auto !important;
}
</style>