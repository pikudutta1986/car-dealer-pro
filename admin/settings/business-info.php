<?php
include("./class/User.php");
$user = new User($dbObject);

if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != '') {
    $userData = $user->getAdminRowById($_SESSION['user_id']);
}

// GET CURRENCY
$currencyArray = $user->getAllCurrency();
$distanceArray = array('KM', 'MILES');
?>
<div class="card">
    <div class="card-body">
        <form method="post" action="" id="settings-form" class="settings-form">
            <div class="text-success mb-3 height-25"><?php echo isset($profileMessage) ? $profileMessage : ''; ?></div>
            <h5>Business Logo:</h5>
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
                        <?php if($userData['business_logo'] && $userData['business_logo'] != '') { ?>
                            <div class="preview-image-container logo-preview" data-file-name="<?php echo $userData['business_logo']; ?>">
                                <img src="<?php echo $SITE_URL; ?>/uploaded-images/<?php echo $userData['business_logo']; ?>" alt="<?php echo $userData['business_logo']; ?>" class="logo-preview-image" />
                                <button class="zoom-button" onclick="zoomImage(event, '<?php echo $userData['business_logo']; ?>')">Zoom</button>
                                <button class="delete-button" onclick="deleteImage(event, '<?php echo $userData['business_logo']; ?>')">Delete</button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                
                <div id="image-modal" class="modal">
                    <span class="close" id="close-modal">&times;</span>
                    <img class="modal-content" id="modal-image">
                </div>
            </div>
            <h5>Business Information:</h5>
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input class="form-control" required name="username" value="<?php echo isset($userData['username']) ? $userData['username'] : ''; ?>" type="text" placeholder="" />
                        <label for="username">Username</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input class="form-control" required name="email" value="<?php echo isset($userData['email']) ? $userData['email'] : ''; ?>" type="text" placeholder="" />
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input class="form-control" required name="phone" value="<?php echo isset($userData['phone']) ? $userData['phone'] : ''; ?>" type="text" placeholder="" />
                        <label for="phone">Phone</label>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md-8">
                    <div class="form-floating">
                        <input class="form-control" required name="businessname" value="<?php echo isset($userData['businessname']) ? $userData['businessname'] : ''; ?>" type="text" placeholder="" />
                        <label for="businessname">Business Name</label>
                    </div>
                </div>
                <div class="col-md-4">
                    
                </div>
            </div>
            <h5>Business Address:</h5>
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input class="form-control" name="address" value="<?php echo isset($userData['address']) ? $userData['address'] : ''; ?>" type="text" placeholder="" />
                        <label for="address">Address</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input class="form-control" name="city" value="<?php echo isset($userData['city']) ? $userData['city'] : ''; ?>" type="text" placeholder="" />
                        <label for="city">City</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input class="form-control" name="state" value="<?php echo isset($userData['state']) ? $userData['state'] : ''; ?>" type="text" placeholder="" />
                        <label for="state">State</label>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="form-floating">
                        <input class="form-control" name="country" value="<?php echo isset($userData['country']) ? $userData['country'] : ''; ?>" type="text" placeholder="" />
                        <label for="country">Country</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <input class="form-control" name="zip" value="<?php echo isset($userData['zip']) ? $userData['zip'] : ''; ?>" type="text" placeholder="" />
                        <label for="zip">Zip</label>
                    </div>
                </div>
            </div>
            <h5>Additional Settings:</h5>
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-control" name="currency" placeholder="" required>
                            <option value="">Select</option>
                            <?php foreach ($currencyArray as $currency) { ?>
                                <option value="<?php echo $currency["symbol"]; ?>" <?php if (isset($userData['currency']) && $userData['currency'] == $currency["symbol"]) { ?>selected<?php } ?>><?php echo $currency["symbol"]; ?> - <?php echo $currency["name"]; ?></option>
                            <?php } ?>
                        </select>
                        <label for="currency">Currency</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating">
                        <select class="form-control" name="distance_unit" placeholder="" required>
                            <option value="">Select</option>
                            <?php foreach ($distanceArray as $distance) { ?>
                                <option value="<?php echo $distance; ?>" <?php if (isset($userData['distance_unit']) && $userData['distance_unit'] == $distance) { ?>selected<?php } ?>><?php echo $distance; ?></option>
                            <?php } ?>
                        </select>
                        <label for="distance_unit">Distance</label>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-dark btn-block" name="save_business_info" value="Save" />
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

<script>
    var site_url = '<?php echo $SITE_URL; ?>';
    var uploadArea = document.getElementById('upload-area');
    var spinner = document.getElementById('spinner');

    // SCRIPT FOR IMAGE UPLOAD STARTS.
    document.addEventListener('DOMContentLoaded', () => {
        const uploadArea = document.getElementById('upload-area');
        const fileInput = document.getElementById('file-input');
        const uploadButton = document.getElementById('upload-button');
        const preview = document.getElementById('preview');
        const modal = document.getElementById('image-modal');
        const closeModal = document.getElementById('close-modal');
        var dragInstruction = document.getElementById('dragInstruction');
        let filesArray = [];
        
        uploadArea.addEventListener('dragover', (event) => {
            event.preventDefault();
            uploadArea.classList.add('dragging');
        });
        
        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragging');
        });
        
        uploadArea.addEventListener('drop', (event) => {
            event.preventDefault();
            uploadArea.classList.remove('dragging');
            const files = event.dataTransfer.files;
            handleFiles(files);
        });
        
        uploadButton.addEventListener('click', (event) => {
            event.preventDefault();
            fileInput.click();
        });
        
        fileInput.addEventListener('change', () => {
            const files = fileInput.files;
            handleFiles(files);
            fileInput.value = '';
        });
        
        closeModal.addEventListener('click', () => {
            modal.style.display = "none";
        });
        
        // THIS FUNCTION WILL HANDLE IMAGE FILES.
        function handleFiles(files) {
            for (const file of files) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        const fileName = file.name;
                        const imgSrc = event.target.result;
                        
                        var chunkDataObj = {
                            fileName,
                            imgSrc,
                            user_id: <?php echo $_SESSION['user_id'];?>
                        };
                        
                        // Upload the image using AJAX
                        uploadImage(chunkDataObj);
                    };
                    reader.readAsDataURL(file);
                }
            }
        }
        
        // UPLOAD IMAGE ON SERVER.
        function uploadImage(chunkDataObj) {
            showSpinner();
            $.ajax({
                url: "<?php echo $SITE_URL; ?>/admin/ajax/upload_profile_logo.php",
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
    function createPreviewContainer(data) {
        const preview = document.getElementById('preview');
        const dragInstruction = document.getElementById('dragInstruction');
        
        preview.innerHTML = '';
        for (let i = 0; i < data.length; i++) {
            htmlContent = `<div class="preview-image-container" data-file-name="${data[i]['business_logo']}">
            <img src="${site_url}/uploaded-images/${data[i]['business_logo']}" alt="${data[i]['business_logo']}" class="preview-image">
            <button class="zoom-button" onclick="zoomImage(event, '${data[i]['business_logo']}')">Zoom</button>
            <button class="delete-button" onclick="deleteImage(event, '${data[i]['business_logo']}')">Delete</button>
            </div>`;
            
            preview.insertAdjacentHTML('beforeend', htmlContent);
        }
        
        if (data.length >= 2) {
            dragInstruction.innerHTML = 'Drag to rearrange the order of the images.';
            dragInstruction.classList.add('show');
            } else {
            dragInstruction.classList.remove('show');
            setTimeout(() => {
                dragInstruction.innerHTML = '';
            }, 500);
        }
    }
    
    // DELETE IMAGE.
    function deleteImage(event, fileName) {
        showSpinner();
        event.preventDefault();
        const vin = $('#vin').val();
        
        $.ajax({
            url: "<?php echo $SITE_URL; ?>/admin/ajax/delete_profile_logo.php",
            type: 'POST',
            data: {
                fileName: fileName,
                user_id: <?php echo $_SESSION['user_id'];?>
            },
            success: function(response) {
                hideSpinner();
                $('#preview').html('');
                setTimeout(() => {
                    location.reload();
                }, 2000);
            },
            error: function(xhr, status, error) {
                showToast('Failed to delete image.', 'error');
            }
        });
    }
    
    
    // ZOOM IMAGE.
    function zoomImage(event, fileName) {
        event.preventDefault();
        const imgSrc = `<?php echo $SITE_URL; ?>/uploaded-images/${fileName}`;
        const modal = document.getElementById('image-modal');
        const modalImage = document.getElementById('modal-image');
        modalImage.src = imgSrc;
        modal.style.display = "block";
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
        uploadArea.style.opacity = '0.3';
        spinner.style.display = 'block';
    }
    
    // FUNCTION TO HIDE SPINNER.
    function hideSpinner() {
        uploadArea.style.opacity = '1';
        spinner.style.display = 'none';
    }
</script>	
