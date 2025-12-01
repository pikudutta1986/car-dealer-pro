

<?php
session_start();
include("../config/index.php");

if ($_SESSION['username'] == '') {
    header("Location: ".$SITE_URL."/admin/login.php");
    die();
}

include("./class/Cars.php");
$cars = new Cars($dbObject);

include("./layouts/header.php");
include("./layouts/navbar.php");
include("./layouts/sidebar.php");

$bodyDetails = null;
if (isset($_REQUEST['id'])) {
    $bodyDetails = $cars->getBodyStyleById($_REQUEST['id']);
}
?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><?php echo $bodyDetails ? 'Edit Body Style': 'Add Body Style';?></h1>
        <form id="bodystyle-form" class="bodystyle-form">
            <div class="row mb-5">
                <div class="col-md-3">
                    <div class="form-floating">
                        <input class="form-control" onkeyup="handleInput()" id="bodystyle" name="bodystyle" value="<?php echo isset($bodyDetails['bodystyle']) ? $bodyDetails['bodystyle'] : ''; ?>" type="text" placeholder="" required />
                        <label for="male">Body Style Name</label>
                    </div>
                </div>
            </div>
            <h5>Image:</h5>
            <div class="row mb-5">
                <div class="col-md-3">
                    <div class="upload-section">
                        <div class="upload-area" id="upload-area">
                            <h2>Drag & Drop Image Here</h2>
                            <input type="file" id="file-input">
                            <button id="upload-button">Or Select Image</button>
                        </div>
                        <div class="spinner-border" id="spinner" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="hidden" id="image" name="image" value="<?php echo $bodyDetails['image']; ?>" />
                    <div id="preview">
                        <?php 
                        if (isset($_REQUEST['id']) && $bodyDetails['image'] != '') 
                        {
                            $imagePath = '../uploaded-images/bodystyle-images/' . $bodyDetails['image'];
                            
                            if (file_exists($imagePath)) {
                            ?>
                            <div class="preview-image-container">
                                <img src="<?php echo $SITE_URL; ?>/uploaded-images/bodystyle-images/<?php echo $bodyDetails['image']; ?>" alt="<?php echo $bodyDetails['bodystyle']; ?>" class="preview-image" />
                                <button class="delete-button" onclick="deleteImage(event, <?php echo $_REQUEST['id']; ?>, '<?php echo $bodyDetails['image']; ?>')">Delete</button>
                            </div>
                            <?php
                            } 
                        } 
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="create-button-div">
                        <a class="btn btn-dark btn-block" id="saveButton" onclick="onSave(event)">Save</a>
                    </div>
                </div>
            </div>
        </form>

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
    </div>
</main>

<script>
    var site_url = '<?php echo $SITE_URL; ?>';
    var spinner = document.getElementById('spinner');
    const uploadArea = document.getElementById('upload-area');
    const fileInput = document.getElementById('file-input');
    const uploadButton = document.getElementById('upload-button');
    const preview = document.getElementById('preview');

    // SCRIPT FOR IMAGE UPLOAD STARTS.
    document.addEventListener('DOMContentLoaded', () => {
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

        // THIS FUNCTION WILL HANDLE IMAGE FILES.
        function handleFiles(files) 
        {
            let file = files[0];
            if (file.type.startsWith('image/')) 
            {
                const reader = new FileReader();
                reader.onload = (event) => 
                {
                    const fileName = file.name;
                    const imgSrc = event.target.result;

                    var chunkDataObj = {
                        fileName,
                        imgSrc
                    };
                    // Upload the image using AJAX
                    uploadImage(chunkDataObj);
                };
                reader.readAsDataURL(file);
            }
        }
    });
    // SCRIPT FOR IMAGE UPLOAD ENDS.

    // UPLOAD IMAGE ON SERVER.
    function uploadImage(chunkDataObj) {
        showSpinner();
        $.ajax({
            url: "<?php echo $SITE_URL; ?>/admin/ajax/upload_bodystyle_image.php",
            type: 'POST',
            data: chunkDataObj,
            success: function(response) {
                let responseObj;
                try {
                    responseObj = JSON.parse(response);
                } catch (e) {
                    showToast('Invalid response from server.', 'error');
                    return;
                }
                if (responseObj && responseObj.imagename) {
                    hideSpinner();
                    let imagename = responseObj.imagename;
                    createPreviewContainer(imagename);
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
    
    // DELETE IMAGE.
    function deleteImage(event, id, fileName) {
        showSpinner();
        event.preventDefault();
        $.ajax({
            url: "<?php echo $SITE_URL; ?>/admin/ajax/delete_bodystyle_image.php",
            type: 'POST',
            data: {
                fileName: fileName,
                id: id
            },
            success: function(response) {
                let responseObj;
                try {
                    responseObj = JSON.parse(response);
                } catch (e) {
                    showToast('Invalid response from server.', 'error');
                    return;
                }
                hideSpinner();
                showToast(responseObj.message, 'success');
                createPreviewContainer('');
            },
            error: function(xhr, status, error) {
                showToast('Failed to delete image.', 'error');
            }
        });
    }

    // CREATE HTML CONTENT FOR PREVIEW IMAGE.
    function createPreviewContainer(imagename) {
        const preview = document.getElementById('preview');
        const imageInput = document.getElementById('image');
        
        imageInput.value = '';
        preview.innerHTML = '';
        if (imagename != '')
        {
            imageInput.value = imagename;
            htmlContent = `<div class="preview-image-container"><img src="${site_url}/uploaded-images/bodystyle-images/${imagename}" alt="${imagename}" class="preview-image"></div>`;
            preview.insertAdjacentHTML('beforeend', htmlContent);
        }
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

    var paramId = '<?php echo isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; ?>';

    if (paramId && paramId != '') {
        enableSaveButton();
    } else {
        disableSaveButton();
    }

    function handleInput() {
        var bodystyle = $('#bodystyle').val();
        if (bodystyle != '') {
            enableSaveButton();
        } else {
            disableSaveButton();
        }
    }

    function disableSaveButton() {
        var saveButton = document.getElementById('saveButton');
        saveButton.disabled = true;
        saveButton.style.opacity = '0.5';
        saveButton.style.cursor = 'not-allowed';
    }

    function enableSaveButton() {
        var saveButton = document.getElementById('saveButton');
        saveButton.disabled = false;
        saveButton.style.opacity = '1';
        saveButton.style.cursor = 'pointer';
    }

    // FUNCTION TO CALL AJAX TO INSERT FORM DATA.
    function onSave(event) {
        event.preventDefault();

        var bodystyle = $('#bodystyle').val();
        var image = $('#image').val();

        if(bodystyle.trim() == '') {
            showToast('Body style is required', 'error');
            return;
        }

        $.ajax({
            url: "<?php echo $SITE_URL; ?>/admin/ajax/addedit_bodystle.php",
            data: {
                id: '<?php echo isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; ?>',
                bodystyle: bodystyle,
                image: image
            },
            success: function(response) {
                if (response.success == true) {
                    showToast(response.message, 'success');
                    setTimeout(() => {
                        window.location.href = site_url+'/admin/bodystyle-addedit.php?id=' + response.edit_id;
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
</script>

<?php include("./layouts/footer.php"); ?>