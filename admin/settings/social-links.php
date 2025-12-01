<?php
	include("./class/User.php");
	$user = new User($dbObject);
	$socialLinks = $user->getAllSocialLinks();
?>

<div class="card">
	<div class="card-body">
		<form method="post" action="" id="social-links-form" class="social-links-form">
			<div class="social-form-container">
				
				<div class="<?php echo $success ? 'text-success' : 'text-danger'; ?> mb-3 height-25"></div>
				<div class="form-floating mb-5">
					<input class="form-control" name="fb_page_link" type="text" id="fb_page_link" placeholder="" value="<?php echo $socialLinks['fb_page_link'];?>" />
					<label for="fb_page_link">Facebook Page Link</label>
				</div>
				<div class="form-floating mb-5">
					<input class="form-control" name="twitter_page_link" type="text" id="twitter_page_link" placeholder="" value="<?php echo $socialLinks['twitter_page_link'];?>" />
					<label for="twitter_page_link">Twitter Page Link</label>
				</div>
				<div class="form-floating mb-5">
					<input class="form-control" name="yt_page_link" type="text" id="yt_page_link" placeholder="" value="<?php echo $socialLinks['yt_page_link'];?>" />
					<label for="yt_page_link">Youtube Page Link</label>
				</div>
				<div class="form-floating mb-5">
					<input class="form-control" name="insta_page_link" type="text" id="insta_page_link" placeholder="" value="<?php echo $socialLinks['insta_page_link'];?>" />
					<label for="insta_page_link">Instagram Page Link</label>
				</div>
				<div class="col-md-12">
					<a class="btn btn-dark btn-block" id="saveButton" onclick="onSave(event)">Save</a>
				</div>
			</div>
		</form>
		<div class="d-flex">
			<div id="toast-body" class="toast-body"></div>
				<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
		</div>
		<div id="global-loader" class="loader-hidden">
			<div class="bounce">
				<div></div>
				<div></div>
				<div></div>
			</div>
		</div>
	</div>
</div>

	
<style>
	.social-form-container {
		padding: 0 20px;
		width: 500px;
	}
</style>
<script>
	var site_url = '<?php echo $SITE_URL; ?>';
	var spinner = document.getElementById('spinner');

	
	// FUNCTION TO CALL AJAX TO INSERT FORM DATA.
	function onSave(event) {
		event.preventDefault();

		var fb_page_link = $('#fb_page_link').val();
		var twitter_page_link = $('#twitter_page_link').val();
		var yt_page_link = $('#yt_page_link').val();
		var insta_page_link = $('#insta_page_link').val();

		$.ajax({
			url: "<?php echo $SITE_URL; ?>/admin/ajax/save_social_links.php",
			data: {
				fb_page_link: fb_page_link,
				twitter_page_link: twitter_page_link,
				yt_page_link: yt_page_link,
				insta_page_link: insta_page_link
			},
			success: function(response) {
				if (response.success == true) {
					showToast(response.message, 'success');
					setTimeout(() => {
						window.location.href = site_url+'/admin/social-links.php';
					}, 500);
				} else {
					showToast(response.message, 'error');
				}
			},
			error: function(xhr, status, error) {
				showToast('Something went wrong.', 'error');
			}
		});
	}
	
	// FUNCTION FOR TOASTER.
	function showToast(message, type) {
		const toast = new bootstrap.Toast(document.getElementById('dynamic-toast'));
		const toastBody = document.getElementById('toast-body');
		const toastElement = document.getElementById('dynamic-toast');
		
		// SET MESSAGE TEXT.
		toastBody.textContent = message;
		
		// SET BACKGROUND COLOR BASED ON TYPE.
		if (type === 'success') {
			toastElement.classList.remove('bg-danger', 'bg-primary');
			toastElement.classList.add('bg-success');
		} else if (type === 'error') {
			toastElement.classList.remove('bg-success', 'bg-primary');
			toastElement.classList.add('bg-danger');
		} else {
			toastElement.classList.remove('bg-success', 'bg-danger');
			toastElement.classList.add('bg-primary');
		}
		
		// SHOW THE TOAST.
		toast.show();
	}
	
	// FUNCTION TO SHOW GLOBAL LOADER.
	function showLoader() {
		document.getElementById('global-loader').classList.remove('loader-hidden');
	}
	
	// FUNCTION TO HIDE GLOBAL LOADER.
	function hideLoader() {
		document.getElementById('global-loader').classList.add('loader-hidden');
	}
	
	// FUNCTION TO SHOW SPINNER.
	function showSpinner() {
		spinner.style.display = 'block';
	}
	
	// FUNCTION TO HIDE SPINNER.
	function hideSpinner() {
		spinner.style.display = 'none';
	}
</script>	
	
<?php include("./layouts/footer.php"); ?>