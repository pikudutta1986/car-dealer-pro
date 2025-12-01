<?php
include("./class/User.php");
$user = new User($dbObject);
$homePageSetting = $user->getAdminHomePageSettings();
?>
<div class="card">
    <div class="card-body">
        <form method="post" action="">
            <div class="text-success mb-3 height-25"><?php echo isset($profileMessage) ? $profileMessage : ''; ?></div>
            <h5>Banner image: <span class="tooltip-wrapper">
				<i class="fa fa-info-circle info-icon" onclick="toggleTooltip(this)"></i>
				<span class="tooltip-box">Recommended image size: 1400x500px</span>
			</span></h5>
            <div class="row mb-5">
                <div class="col-md-6">
                    <div class="upload-section">
                        <div class="upload-area" id="upload-area">
                            <h2>Drag & Drop Images Here</h2>
                            <input type="file" id="file-input">
                            <button id="upload-button">Or Select Image</button>
						</div>
                        <div class="spinner-border" id="spinner" role="status">
                            <span class="sr-only"></span>
						</div>
					</div>
				</div>
                <div class="col-md-6">
                    <div id="dragInstruction" class="drag-instruction"></div>
                    <div id="preview">
                        <?php if($homePageSetting['banner_image'] && $homePageSetting['banner_image'] != '') { ?>
                            <div class="preview-image-container logo-preview" data-file-name="<?php echo $homePageSetting['banner_image']; ?>">
                                <img src="<?php echo $SITE_URL; ?>/uploaded-images/<?php echo $homePageSetting['banner_image']; ?>" alt="<?php echo $homePageSetting['banner_image']; ?>" class="logo-preview-image" />
                                <button class="zoom-button" onclick="zoomImage(event, '<?php echo $homePageSetting['banner_image']; ?>')">Zoom</button>
                                <button class="delete-button" onclick="deleteImage(event, '<?php echo $homePageSetting['banner_image']; ?>')">Delete</button>
							</div>
						<?php } ?>
					</div>
				</div>
                
                <div id="image-modal" class="modal">
                    <span class="close" id="close-modal">&times;</span>
                    <img class="modal-content" id="modal-image">
				</div>
			</div>
            <h5>Banner Text:</h5>
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input class="form-control" name="banner_heading1" id="banner_heading1" value="<?php echo isset($homePageSetting['banner_heading1']) ? $homePageSetting['banner_heading1'] : ''; ?>" type="text" placeholder="" />
                        <label for="banner_heading1">Heading 1</label>
					</div>
				</div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input class="form-control" name="banner_heading2" id="banner_heading2" value="<?php echo isset($homePageSetting['banner_heading2']) ? $homePageSetting['banner_heading2'] : ''; ?>" type="text" placeholder="" />
                        <label for="banner_heading2">Heading 2</label>
					</div>
				</div>
			</div>
            <div class="row mb-5">
                <div class="col-md-12">
                    <input type="checkbox" name="show_bodystyle" id="show_bodystyle" value="Y" <?php echo isset($homePageSetting['show_bodystyle']) && $homePageSetting['show_bodystyle'] == 'Y' ? 'checked' : ''; ?> /> Show Body styles
				</div>
			</div>
            <h5>Cars Grid:</h5>
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input class="form-control" name="cargrid_heading" id="cargrid_heading" value="<?php echo isset($homePageSetting['cargrid_heading']) ? $homePageSetting['cargrid_heading'] : ''; ?>" type="text" placeholder="" />
                        <label for="cargrid_heading">Heading</label>
					</div>
				</div>
                <div class="col-md-4">
                    <div class="form-floating">
						<select class="form-control" name="numberofcars" id="numberofcars">
							<option value="0" <?php if($homePageSetting['numberofcars'] == 0){?>selected<?php } ?>>Select numbers</option>	
							<option value="4" <?php if($homePageSetting['numberofcars'] == 4){?>selected<?php } ?>>4</option>	
							<option value="8" <?php if($homePageSetting['numberofcars'] == 8){?>selected<?php } ?>>8</option>	
							<option value="12" <?php if($homePageSetting['numberofcars'] == 12){?>selected<?php } ?>>12</option>	
							<option value="16" <?php if($homePageSetting['numberofcars'] == 16){?>selected<?php } ?>>16</option>	
							<option value="20" <?php if($homePageSetting['numberofcars'] == 20){?>selected<?php } ?>>20</option>		
						</select>
                        <label for="numberofcars">Number of cars</label>
					</div>
				</div>
                <div class="col-md-4">
				</div>
			</div>
            <h5>Content:</h5>
            <div class="row mb-5">
                <div class="col-md-12">
                    <textarea class="form-control ckeditor" rows="8" cols="50" name="content" id="content"><?php echo isset($homePageSetting['content']) ? $homePageSetting['content'] : ''; ?></textarea>
				</div>
			</div>
            <div class="row mb-5">
                <div class="col-md-12">
                    <input type="checkbox" name="show_make" id="show_make" value="Y" <?php echo isset($homePageSetting['show_make']) && $homePageSetting['show_make'] == 'Y' ? 'checked' : ''; ?> /> Show Makes Carousel
				</div>
			</div>
            <div class="row">
                <div class="col-md-12">
				<a class="btn btn-dark btn-block" name="save_business_info" onclick="onSave(event)">Save</a>
			</div>
		</div>
		<div id="dynamic-toast" class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
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
	</form>
</div>
</div>
<style>
	.tooltip-wrapper {
	position: relative;
	display: inline-block;
	}
	
	.info-icon {
	color: #0d6efd;
	cursor: pointer;
	font-size: 16px;
	}
	
	/* Tooltip Box */
	.tooltip-box {
	position: absolute;
	top: 50%;
	left: 130%; /* shift right side */
	transform: translateY(-50%);
	min-width: 220px;
	background: #fff;
	border: 1px solid #ccc;
	padding: 10px 12px;
	border-radius: 6px;
	box-shadow: 0 4px 8px rgba(0,0,0,0.1);
	color: #333;
	font-size: 14px;
	display: none;
	z-index: 1000;
	}
	
	/* Show it when class is added */
	.tooltip-box.show {
	display: block;
	}
</style>
<script>
	
    var site_url = '<?php echo $SITE_URL; ?>';
    var uploadArea = document.getElementById('upload-area');
    var spinner = document.getElementById('spinner');
	
	function toggleTooltip(el) {
		// Close any open tooltips first
		document.querySelectorAll('.tooltip-box').forEach(box => box.classList.remove('show'));
		
		const tooltip = el.nextElementSibling;
		tooltip.classList.toggle('show');
		
		// Close on outside click
		document.addEventListener('click', function outsideClick(e) {
			if (!el.contains(e.target) && !tooltip.contains(e.target)) {
				tooltip.classList.remove('show');
				document.removeEventListener('click', outsideClick);
			}
		});
	}
	
    // SCRIPT FOR IMAGE UPLOAD STARTS.
    document.addEventListener('DOMContentLoaded', () => 
    {
        const uploadArea = document.getElementById('upload-area');
        const fileInput = document.getElementById('file-input');
        const uploadButton = document.getElementById('upload-button');
        const preview = document.getElementById('preview');
        const modal = document.getElementById('image-modal');
        const closeModal = document.getElementById('close-modal');
        var dragInstruction = document.getElementById('dragInstruction');
        let filesArray = [];
        
        uploadArea.addEventListener('dragover', (event) => 
        {
            event.preventDefault();
            uploadArea.classList.add('dragging');
		});
        
        uploadArea.addEventListener('dragleave', () => 
        {
            uploadArea.classList.remove('dragging');
		});
        
        uploadArea.addEventListener('drop', (event) => 
        {
            event.preventDefault();
            uploadArea.classList.remove('dragging');
            const files = event.dataTransfer.files;
            handleFiles(files);
		});
        
        uploadButton.addEventListener('click', (event) => 
        {
            event.preventDefault();
            fileInput.click();
		});
        
        fileInput.addEventListener('change', () => 
        {
            const files = fileInput.files;
            handleFiles(files);
            fileInput.value = '';
		});
        
        closeModal.addEventListener('click', () => 
        {
            modal.style.display = "none";
		});
        
        // THIS FUNCTION WILL HANDLE IMAGE FILES.
        function handleFiles(files) 
        {
            for (const file of files) 
            {
                if (file.type.startsWith('image/')) 
                {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        const fileName = file.name;
                        const imgSrc = event.target.result;
						
						// Create a temporary Image object to get width and height
						const img = new Image();
						
						img.onload = () => {
							const width = img.width;
							const height = img.height;
							
							console.log(`Image: ${fileName}, Width: ${width}, Height: ${height}`);
							
							// OPTIONAL: Validate dimensions
							const minWidth = 1400;
							const minHeight = 500;
							
							if (width < minWidth || height < minHeight) {
								showToast('Image minimum width and height schould be 1400px, 500px;', 'error');
								return;
							}
							
							var chunkDataObj = {
								fileName,
								imgSrc,
								user_id: <?php echo $_SESSION['user_id'];?>
							};
							
							// Upload the image using AJAX
							uploadImage(chunkDataObj);
						}
                        
						img.src = imgSrc;
					};
					
					reader.readAsDataURL(file);
					}else{
					showToast('Only image type file allow.', 'error');
				}
			}
		}
		
        
        // UPLOAD IMAGE ON SERVER.
        function uploadImage(chunkDataObj) {
            showSpinner();
            $.ajax({
                url: "<?php echo $SITE_URL; ?>/admin/ajax/upload_home_page_banner_image.php",
                type: 'POST',
                data: chunkDataObj,
                success: function(response) {
                    let responseObj;
                    try {
                        responseObj = JSON.parse(response);
                        setTimeout(() => {
                            location.reload();
						}, 2000);
					} catch (e) {
                        showToast('Invalid response from server.', 'error');
                        return;
					}
                    if (responseObj && responseObj.data) {
                        hideSpinner();
                        let data = responseObj.data;
                        createPreviewContainer(data);
                        showToast(responseObj.message, 'success');
					} else {
                        hideSpinner();
                        showToast(responseObj.message, 'error');
					}
				},
                error: function(xhr, status, error) {
                    showToast('Failed to upload the image.', 'error');
				}
			});
		}
        
        window.addEventListener('click', (event) => {
            if (event.target == modal) {
                modal.style.display = "none";
			}
		});
		
	});
    
    // CREATE HTML CONTENT FOR PREVIEW IMAGE.
    function createPreviewContainer(data) 
    {
        const preview = document.getElementById('preview');
        const dragInstruction = document.getElementById('dragInstruction');
        
        preview.innerHTML = '';
        for (let i = 0; i < data.length; i++) 
        {
            htmlContent = `<div class="preview-image-container" data-file-name="${data[i]['business_logo']}">
            <img src="${site_url}/uploaded-images/${data[i]['business_logo']}" alt="${data[i]['business_logo']}" class="preview-image">
            <button class="zoom-button" onclick="zoomImage(event, '${data[i]['business_logo']}')">Zoom</button>
            <button class="delete-button" onclick="deleteImage(event, '${data[i]['business_logo']}')">Delete</button>
            </div>`;
            
            preview.insertAdjacentHTML('beforeend', htmlContent);
		}
        
        if (data.length >= 2) 
        {
            dragInstruction.innerHTML = 'Drag to rearrange the order of the images.';
            dragInstruction.classList.add('show');
        } 
        else 
        {
            dragInstruction.classList.remove('show');
            setTimeout(() => 
            {
                dragInstruction.innerHTML = '';
			}, 500);
		}
	}
    
    // DELETE IMAGE.
    function deleteImage(event, fileName) 
    {
        showSpinner();
        event.preventDefault();
        const vin = $('#vin').val();
        
        $.ajax
        ({
            url: "<?php echo $SITE_URL; ?>/admin/ajax/delete_homepage_banner_image.php",
            type: 'POST',
            data: 
            {
                fileName: fileName,
                user_id: <?php echo $_SESSION['user_id'];?>
			},
            success: function(response) 
            {
                hideSpinner();
                $('#preview').html('');
                setTimeout(() => 
                {
                    location.reload();
				}, 2000);
			},
            error: function(xhr, status, error) 
            {
                showToast('Failed to delete image.', 'error');
			}
		});
	}
    
    
    // ZOOM IMAGE.
    function zoomImage(event, fileName) 
    {
        event.preventDefault();
        const imgSrc = `<?php echo $SITE_URL; ?>/uploaded-images/${fileName}`;
        const modal = document.getElementById('image-modal');
        const modalImage = document.getElementById('modal-image');
        modalImage.src = imgSrc;
        modal.style.display = "block";
	}
    
    // FUNCTION FOR TOASTER.
    function showToast(message, type) 
    {
        const toast = new bootstrap.Toast(document.getElementById('dynamic-toast'));
        const toastBody = document.getElementById('toast-body');
        const toastElement = document.getElementById('dynamic-toast');
        
        // SET MESSAGE TEXT.
        toastBody.textContent = message;
        
        // SET BACKGROUND COLOR BASED ON TYPE.
        if (type === 'success')
        {
            toastElement.classList.remove('bg-danger', 'bg-primary');
            toastElement.classList.add('bg-success');
		} 
        else if (type === 'error') 
        {
            toastElement.classList.remove('bg-success', 'bg-primary');
            toastElement.classList.add('bg-danger');
		} 
        else 
        {
            toastElement.classList.remove('bg-success', 'bg-danger');
            toastElement.classList.add('bg-primary');
		}
        
        // SHOW THE TOAST.
        toast.show();
	}
    
    // FUNCTION TO SHOW GLOBAL LOADER.
    function showLoader() 
    {
        document.getElementById('global-loader').classList.remove('loader-hidden');
	}
    
    // FUNCTION TO HIDE GLOBAL LOADER.
    function hideLoader() 
    {
        document.getElementById('global-loader').classList.add('loader-hidden');
	}
    
    // FUNCTION TO SHOW SPINNER.
    function showSpinner() 
    {
        uploadArea.style.opacity = '0.3';
        spinner.style.display = 'block';
	}
    
    // FUNCTION TO HIDE SPINNER.
    function hideSpinner() 
    {
        uploadArea.style.opacity = '1';
        spinner.style.display = 'none';
	}
	
	function onSave(event) 
    {
		event.preventDefault();
		var banner_heading1 = $('#banner_heading1').val();
        var banner_heading2 = $('#banner_heading2').val();
		// var show_bodystyle = $('#show_bodystyle').val();
		var show_bodystyle = document.getElementById("show_bodystyle").checked ? document.getElementById("show_bodystyle").value : 'N';
		var cargrid_heading = $('#cargrid_heading').val();
		var numberofcars = $('#numberofcars').val();
		//var show_make = $('#show_make').val();
		var show_make = document.getElementById("show_make").checked ? document.getElementById("show_make").value : 'N';
		
        let content = tinymce.get('content').getContent();
		
        if(banner_heading1.trim() == '') 
        {
            showToast('Heading 1 is required', 'error');
            return;
		}
		
		if(banner_heading2.trim() == '') 
        {
            showToast('Heading 2 is required', 'error');
            return;
		}
		
		if(cargrid_heading.trim() == '') 
        {
            showToast('Car grid Heading is required', 'error');
            return;
		}
		
		if(content.trim() == '') 
        {
            showToast('Content is required', 'error');
            return;
		}
		
		showSpinner();
		$.ajax
        ({
            url: "<?php echo $SITE_URL; ?>/admin/ajax/save-home-setting.php",
            type: 'POST',
            data: 
            {
                banner_heading1: banner_heading1,
				banner_heading2: banner_heading2,
				show_bodystyle: show_bodystyle,
				cargrid_heading: cargrid_heading,
				numberofcars: numberofcars,
				show_make: show_make,
				content: content,
                user_id: <?php echo $_SESSION['user_id'];?>
			},
            success: function(response) 
            {
                hideSpinner();
				showToast(response.message, 'success');
                setTimeout(() => 
                {
                    location.reload();
				}, 2000);
			},
            error: function(xhr, status, error) 
            {
				console.log(error);
                showToast('Failed to save data.', 'error');
			}
		});
	}
</script>	
