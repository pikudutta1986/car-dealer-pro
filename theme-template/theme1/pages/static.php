<?php
$pagedata = $pageClassObject->getpageDetailsBySlug($_REQUEST['slug']);
?>
<div class="breadcrumb-option set-bg" data-setbg="<?php echo $SITE_URL?>/theme-template/theme1/img/breadcrumb-bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2><?php echo $pagedata['title'];?></h2>
                    <div class="breadcrumb__links">
                        <a href="<?php echo $SITE_URL?>"><i class="fa fa-home"></i> Home</a>
                        <span><?php echo $pagedata['title'];?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Breadcrumb Begin -->


<!-- About Us Section Begin -->
<section class="about spad">
    <div class="container">
		<?php if($pagedata['showcontactform'] == 'Y'){ ?>
			<div class="row">
				<div class="col-lg-6 col-md-6">
					<?php echo $pagedata['content'];?>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="contact__form">
						<form id="contactForm" class="contact-form">
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<input type="text" name="name" class="form-control" placeholder="Name" required>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<input type="email" name="email" class="form-control" placeholder="Email" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<input type="text" name="subject" class="form-control" placeholder="Subject" required>
							</div>
							<div class="form-group">
								<textarea name="message" class="form-control" placeholder="Your Question" required></textarea>
							</div>
							<button type="submit" class="site-btn">Submit Now</button>
						</form>
						<!-- Success/Fail message -->
						<div id="formResult" class="mt-2"></div>
					</div>
				</div>
			</div>
			<?php } else { ?>
			<?php echo $pagedata['content'];?>
		<?php } ?>
	</div>
</section>
<script>
	// Wait for jQuery and validation system to load
	function initContactForm() {
		if (typeof $ === 'undefined' || !window.FormValidator) {
			setTimeout(initContactForm, 100);
			return;
		}
		
		// Only add the custom submit handler if validation passes
		document.getElementById('contactForm').addEventListener('submit', function(e) {
			// Let validation system run first
			if (window.FormValidator) {
				const form = e.target;
				const formId = window.FormValidator.getFormId(form);
				const formConfig = window.FormValidator.getFormConfig(formId);
				
				if (formConfig) {
					// Run validation
					let isValid = true;
					const errors = [];
					
					// Validate individual fields
					Object.keys(formConfig.fields).forEach(fieldName => {
						const field = form.querySelector(`[name="${fieldName}"]`);
						if (field) {
							const fieldError = window.FormValidator.validateField(field, formConfig.fields[fieldName]);
							if (fieldError) {
								isValid = false;
								errors.push(fieldError);
							}
						}
					});
					
					// If validation fails, prevent submission
					if (!isValid) {
						e.preventDefault();
						window.FormValidator.showFormErrors(errors);
						return false;
					}
				}
			}
			
			// If validation passes, proceed with custom submission
			e.preventDefault();
			const form = e.target;
			const formData = new FormData(form);
			
			fetch('<?php echo $SITE_URL; ?>/ajax/send_mail.php', {
				method: 'POST',
				body: formData
			})
			.then(response => response.text())
			.then(data => {
				if(data == 'Message sent successfully!')
				{
					document.getElementById('formResult').innerHTML = '<div class="alert alert-success">Mail sent successfully!</div>';
					form.reset();
					// Clear validation states after successful submission
					if (window.FormValidator) {
						window.FormValidator.clearAllValidationStates(form);
					}
				}else{
					document.getElementById('formResult').innerHTML = '<div class="alert alert-danger">There was an error sending the message.</div>';
				}
			})
			.catch(error => {
				console.error('Error:', error);
				document.getElementById('formResult').innerHTML = '<div class="alert alert-danger">There was an error sending the message.</div>';
			});
		});
	}
	
	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initContactForm);
	} else {
		initContactForm();
	}
</script>
<!-- About Us Section End -->
