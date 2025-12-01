

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

// GET MAKES
$makeArray = $cars->getActiveMake();

$modelDetails = null;
if (isset($_REQUEST['id'])) {
    $modelDetails = $cars->getModelById($_REQUEST['id']);
}
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><?php echo $modelDetails ? 'Edit Model': 'Add Model';?></h1>
        <form id="model-form" class="model-form">
            <div class="row mb-5">
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-control" id="make_id" name="make_id" placeholder="" onChange="handleInput()" required>
                            <option value="">Any</option>
                            <?php foreach ($makeArray as $carmake) { ?>
                            <option value="<?php echo $carmake["make_id"]; ?>" <?php if (isset($modelDetails['make_id']) && $modelDetails['make_id'] == $carmake["make_id"]) { ?>selected<?php } ?>><?php echo strtoupper($carmake["make"]); ?></option>
                            <?php } ?>
                        </select>
                        <label for="male">Make</label>
                    </div>
                </div>
            </div>
            <div class="row  mb-5">
                <div class="col-md-3">
                    <div class="form-floating">
                        <input class="form-control" onkeyup="handleInput()" id="model" name="model" value="<?php echo isset($modelDetails['model']) ? $modelDetails['model'] : ''; ?>" type="text" placeholder="" required />
                        <label for="male">Model Name</label>
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
        var make_id = $('#make_id').val();
        var model = $('#model').val();
        if (make_id != '' && model != '') {
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

        var make_id = $('#make_id').val();
        var model = $('#model').val();

        if(make_id.trim() == '') {
            showToast('Make is required', 'error');
            return;
        }

        if(model.trim() == '') {
            showToast('Model is required', 'error');
            return;
        }

        $.ajax({
            url: "<?php echo $SITE_URL; ?>/admin/ajax/addedit_model.php",
            data: {
                id: '<?php echo isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; ?>',
                make_id: make_id,
                model: model
            },
            success: function(response) {
                if (response.success == true) {
                    showToast(response.message, 'success');
                    setTimeout(() => {
                        window.location.href = site_url+'/admin/model-addedit.php?id=' + response.edit_id;
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