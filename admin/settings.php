<?php
session_start();
include("../config/index.php");

if($_SESSION['username'] =='')
{
	header("Location: ".$SITE_URL."/admin/login.php");
	die();
}

if (isset($_GET['tab'])){
	$tab = $_GET['tab'];
} else {
	$tab = 'profile';
}

include("./layouts/header.php");

if ($SITE_INFO['password_changed'] == 'Y') {
	include("./layouts/navbar.php");
	include("./layouts/sidebar.php");
}
?>
<main>
    <div class="container-fluid px-4">
		<?php if ($SITE_INFO['password_changed'] == 'Y') { ?>
        <h1 class="mt-4">Settings</h1>
		<?php } ?>
		<?php if ($SITE_INFO['password_changed'] == 'N' && $tab == 'profile') { ?>
			<h1 class="mt-4 text-center">Setup your business information</h1>
		<?php } ?>
		<?php if ($SITE_INFO['password_changed'] == 'N' && $tab == 'password') { ?>
			<h1 class="mt-4 text-center">Change your password</h1>
		<?php } ?>
		<div class="row">
			<?php if ($SITE_INFO['password_changed'] == 'Y') { ?>
			<ul class="account-menu">
				<li class="<?php echo ($tab == 'profile') ? 'active':'';?>"><a href="<?php echo $SITE_URL; ?>/admin/settings.php?tab=profile">Business Information</a></li>
				<li class="<?php echo ($tab == 'social') ? 'active':'';?>"><a href="<?php echo $SITE_URL; ?>/admin/settings.php?tab=social">Social Links</a></li>
				<li class="<?php echo ($tab == 'home') ? 'active':'';?>"><a href="<?php echo $SITE_URL; ?>/admin/settings.php?tab=home">Home Page Setting</a></li>
				<li class="<?php echo ($tab == 'email') ? 'active':'';?>"><a href="<?php echo $SITE_URL; ?>/admin/settings.php?tab=email">Email Setting</a></li>
				<li class="<?php echo ($tab == 'password') ? 'active':'';?>"><a href="<?php echo $SITE_URL; ?>/admin/settings.php?tab=password">Change Password</a></li>
			</ul>
			<?php } ?>
            <div class="account-tab-content <?php echo ($SITE_INFO['password_changed'] == 'N') ? 'centered-account':'';?>">
                <?php
				if ($tab == 'profile') {
					include('./settings/business-info.php');
				} else if($tab == 'social') {
					include('./settings/social-links.php');
				} else if($tab == 'home') {
					include('./settings/home.php');
				} else if($tab == 'email') {
					include('./settings/email.php');
				} else if($tab == 'password') {
					include('./settings/change-password.php');
				}
				?> 
            </div>
		</div>
	</div>
</main>
<?php 
if ($SITE_INFO['password_changed'] == 'Y') {
	include("./layouts/footer.php");
}
?>