<?php
session_start();
include("../config/index.php");

if ($_SESSION['username'] == '') {
    header("Location: ".$SITE_URL."/admin/login.php");
    die();
}

include("./class/Page.php");

$pageObject = new Page($dbObject);

include("./layouts/header.php");
include("./layouts/navbar.php");
include("./layouts/sidebar.php");

$currrent_year = date("Y");

$pageDetails = null;
if (isset($_REQUEST['id'])) {
    $pageDetails = $pageObject->getpageDetailsById($_REQUEST['id']);
}
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><?php echo $pageDetails ? 'Edit Page': 'Add Page';?></h1>
        <div class="card">
            <div class="card-body">
                <form id="page-form" class="page-form">
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input class="form-control" id="title" name="title" value="<?php echo isset($pageDetails['title']) ? $pageDetails['title'] : ''; ?>" type="text" placeholder="" />
                                <label for="title">Page Title</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input class="form-control" id="slug" name="slug" value="<?php echo isset($pageDetails['slug']) ? $pageDetails['slug'] : ''; ?>" type="text" placeholder="" />
                                <label for="slug">Page Slug</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <input type="checkbox" name="showonmenu" id="showonmenu" value="1" <?php echo isset($pageDetails['showonmenu']) && $pageDetails['showonmenu'] == 'Y' ? 'checked' : ''; ?> /> Show on Menu
                        </div>
                    </div>
					<div class="row mb-5">
                        <div class="col-md-12">
                            <input type="checkbox" name="showcontactform" id="showcontactform" value="Y" <?php echo isset($pageDetails['showcontactform']) && $pageDetails['showcontactform'] == 'Y' ? 'checked' : ''; ?> /> Show Contact Form
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <label for="content">Page Content</label>
                            <textarea class="form-control ckeditor" rows="8" cols="50" name="content" id="content"><?php echo isset($pageDetails['content']) ? $pageDetails['content'] : ''; ?></textarea>
                        </div>
                    </div>
                    <div class="create-button-div">
                        <a class="btn btn-dark btn-block" id="saveButton" onclick="onSave(event)">Save</a>
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
        </div>
</main>
<script>
    // Function to convert title to slug
    function generateSlug(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/[\s\W-]+/g, '-') // Replace spaces and non-word characters with dash
            .replace(/^-+|-+$/g, '');  // Remove starting/ending dashes
    }

    // Add event listener to title field
    document.addEventListener('DOMContentLoaded', function () {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        if (titleInput && slugInput) {
            titleInput.addEventListener('blur', function () {
                // Only update slug if it's currently empty
                if (!slugInput.value.trim()) {
                    slugInput.value = generateSlug(titleInput.value);
                }
            });
        }
    });
</script>
<script>
    var site_url = '<?php echo $SITE_URL; ?>';
    var uploadArea = document.getElementById('upload-area');
    var spinner = document.getElementById('spinner');

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

    /*if (paramId && paramId != '') {
        enableSaveButton();
    } else {
        disableSaveButton();
    }*/

    // CHECK FOR INPUT VALUES ON KEYUP EVENT FOR BOTH FIELDS.
    document.getElementById('title').addEventListener('keyup', handleInput);
    //document.getElementById('content').addEventListener('change', handleInput);

    function handleInput() {
        var title = document.getElementById('title').value;
        var content = document.getElementById('content').value;

        if (title != '' && content != '') {
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
    
    // STATIC FUNCTION TO SLUGIFY STRING.
    function slugify(str) {

        if (str == null || str.trim() === '') {
            return '';
        }

        str = str.replace(/^\s+|\s+$/g, ''); // trim leading/trailing white space
        str = str.toLowerCase(); // convert string to lowercase
        str = str.replace(/[^a-z0-9 -]/g, '') // remove any non-alphanumeric characters
            .replace(/\s+/g, '-') // replace spaces with hyphens
            .replace(/-+/g, '-'); // remove consecutive hyphens
        return str;
    }

    // FUNCTION TO CALL AJAX TO INSERT FORM DATA.
    function onSave(event) {
        event.preventDefault();

        var title = $('#title').val();
        var slug = $('#slug').val();
        //var showonmenu = $('#showonmenu').val();
		//var showcontactform = $('#showcontactform').val();
        let content = tinymce.get('content').getContent();
		var showonmenu = document.getElementById("showonmenu").checked ? document.getElementById("showonmenu").value : 'N';
		var showcontactform = document.getElementById("showcontactform").checked ? document.getElementById("showcontactform").value : 'N';
        if(title.trim() == '') {
            showToast('Title is required', 'error');
            return;
        }

        $.ajax({
            url: "<?php echo $SITE_URL; ?>/admin/ajax/addedit_page.php",
            data: {
                page_id: '<?php echo isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; ?>',
                title: title,
                slug: slug,
                showonmenu: showonmenu,
				showcontactform: showcontactform,
                content: content
            },
            success: function(response) {
                if (response.success == true) {
                    showToast(response.message, 'success');
                    setTimeout(() => {
                        //window.location.href = site_url+'/admin/page-creator.php?id=' + response.edit_id;
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