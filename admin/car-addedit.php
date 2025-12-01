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

$currrent_year = date("Y");

// GET MAKES
$makeArray = $cars->getActiveMake();
// GET BODY STYLES
$bodyStyleArray = $cars->getActiveBodyStyle();

$imagesArray = array();

$carDetails = null;
if (isset($_REQUEST['id'])) {
    $carDetails = $cars->getCarDetailsById($_REQUEST['id']);
}
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><?php echo $carDetails ? 'Edit Cars': 'Add Car';?></h1>
        <div class="card">
            <div class="card-body">
                <form id="car-form">
                    <div class="row">
                        <div class="col-md-6 border-right">
                            <h5>Basic details:</h5>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="vin" name="vin" value="<?php echo isset($carDetails['vin']) ? $carDetails['vin'] : ''; ?>" type="text" placeholder="" required />
                                        <label for="vin">VIN / Vehicle Identification Number</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-control" id="carcondition" name="carcondition" required>
                                            <option value="">Select Car Condition</option>
                                            <option value="USED" <?php if (isset($carDetails['carcondition']) && $carDetails['carcondition'] == 'USED') { ?>selected<?php } ?>>USED</option>
                                            <option value="NEW" <?php if (isset($carDetails['carcondition']) && $carDetails['carcondition'] == 'NEW') { ?>selected<?php } ?>>NEW</option>
                                        </select>
                                        <label for="carcondition">Car Condition</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-control" id="make_id" name="make_id" placeholder="" onChange="ChangeMake(this.value)" required>
                                            <option value="">Select Make</option>
                                            <?php foreach ($makeArray as $carmake) { ?>
                                            <option value="<?php echo $carmake["make_id"]; ?>" <?php if (isset($carDetails['make_id']) && $carDetails['make_id'] == $carmake["make_id"]) { ?>selected<?php } ?>><?php echo strtoupper($carmake["make"]); ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="make">Make</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select id="model_id" class="form-control" name="model_id" placeholder="" required>
                                            <option value="">Select Model</option>
                                            <?php
                                            if ($carDetails['make_id']) {
                                                $modelArray = $cars->getActiveModelByMake($carDetails['make_id']);
                                                foreach ($modelArray as $item) { 
                                                ?>
                                                <option value="<?php echo $item['model_id']; ?>" <?php if (isset($carDetails['model_id']) && $item['model_id'] == $carDetails['model_id']) { ?>selected<?php } ?>><?php echo $item['model']; ?></option>
                                                <?php 
                                                }
                                            } 
                                            ?>
                                        </select>
                                        <label for="model">Model</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select id="bodystyle_id" name="bodystyle_id" class="form-control" placeholder="">
                                            <option value="">Select Bodystyle</option>
                                            <?php foreach ($bodyStyleArray as $bodyStyle) { ?>
                                                <option value="<?php echo $bodyStyle["bodystyle_id"]; ?>" <?php if (isset($carDetails['bodystyle_id']) && $carDetails['bodystyle_id'] == $bodyStyle["bodystyle_id"]) { ?>selected<?php } ?>><?php echo $bodyStyle["bodystyle"]; ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="bodystyle_id">Body Style</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="fuel_type" id="fuel_type" class="form-control" placeholder="">
                                            <option value="">Select Fuel Type</option>
                                            <?php foreach ($FUEL_TYPES as $fuel_type) { ?>
                                                <option value="<?php echo $fuel_type; ?>" <?php if (isset($carDetails['fuel_type']) && $fuel_type == $carDetails['fuel_type']) { ?>selected<?php } ?>><?php echo $fuel_type; ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="fuel_type">Fuel Type</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="year" id="year" class="form-control" placeholder="" required>
                                            <option value="">Select Year</option>
                                            <?php for ($i = $currrent_year; $i > 1959; $i--) { ?>
                                                <option value="<?php echo $i; ?>" <?php if (isset($carDetails['year']) && ($carDetails['year'] == $i)) { ?>selected<?php } ?>><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="year">Year</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="varient" name="varient" value="<?php echo isset($carDetails['varient']) ? $carDetails['varient'] : ''; ?>" type="text" placeholder="" />
                                        <label for="varient">Variant (If Any)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="transmission" id="transmission" class="form-control" placeholder="">
                                            <option value="">Select Transmission</option>
                                            <?php foreach ($TRANSMISSION as $transmission) { ?>
                                                <option value="<?php echo $transmission; ?>" <?php if (isset($carDetails['transmission']) && $transmission == $carDetails['transmission']) { ?>selected<?php } ?>><?php echo $transmission; ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="transmission">Transmission</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="website_price" name="website_price" value="<?php echo isset($carDetails['website_price']) ? $carDetails['website_price'] : ''; ?>" type="number" placeholder="" />
                                        <label for="website_price">Selling Price / Display Price (<?php echo $SITE_CURRENCY;?>)</label>
                                    </div>
                                    <span class="hint">This is the price you want to sell this car.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Additional details:</h5>
                            
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="engine" name="engine" value="<?php echo isset($carDetails['engine']) ? $carDetails['engine'] : ''; ?>" type="number" placeholder="" />
                                        <label for="engine">Engine (CC)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="mileage" name="mileage" value="<?php echo isset($carDetails['mileage']) ? $carDetails['mileage'] : ''; ?>" type="number" placeholder="" />
                                        <label for="mileage">Mileage (<?php echo $DISTANCE_UNIT;?>)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="max_power" name="max_power" value="<?php echo isset($carDetails['max_power']) ? $carDetails['max_power'] : ''; ?>" type="text" placeholder="" />
                                        <label for="max_power">Max Power</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="max_torque" name="max_torque" value="<?php echo isset($carDetails['max_torque']) ? $carDetails['max_torque'] : ''; ?>" type="text" placeholder="" />
                                        <label for="max_torque">Max Torque</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="boot_space" name="boot_space" value="<?php echo isset($carDetails['boot_space']) ? $carDetails['boot_space'] : ''; ?>" type="number" placeholder="" />
                                        <label for="boot_space">Boot Space (<?php echo $BOOTSPACE_UNIT;?>)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="ground_clearance" name="ground_clearance" value="<?php echo isset($carDetails['ground_clearance']) ? $carDetails['ground_clearance'] : ''; ?>" type="number" placeholder="" />
                                        <label for="ground_clearance">Ground Clearance (<?php echo $GROUND_CLEARANCE_UNIT;?>)</label>
                                    </div>
                                </div>
                            </div>
							
							<div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="cylinders" name="cylinders" value="<?php echo isset($carDetails['cylinders']) ? $carDetails['cylinders'] : ''; ?>" type="number" placeholder="" />
                                        <label for="cylinders">No. of Cylinders</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="color" name="color" value="<?php echo isset($carDetails['color']) ? $carDetails['color'] : ''; ?>" type="text" placeholder="" />
                                        <label for="color">Color</label>
                                    </div>
                                </div>
                                
                            </div>
							<div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="seating_capacity" name="seating_capacity" value="<?php echo isset($carDetails['seating_capacity']) ? $carDetails['seating_capacity'] : ''; ?>" type="number" placeholder="" />
                                        <label for="seating_capacity">Seating Capacity</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input class="form-control" id="airbags" name="airbags" value="<?php echo isset($carDetails['airbags']) ? $carDetails['airbags'] : ''; ?>" type="number" placeholder="" />
                                        <label for="airbags">Number of Air Bags</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5>Owner Information:</h5>
                    <div class="row mb-5">
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input class="form-control" id="name" name="name"  value="<?php echo isset($carDetails['owner_info']['name']) ? $carDetails['owner_info']['name'] : ''; ?>" type="text" placeholder="" />
                                <label for="name">Owner Name</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input class="form-control" id="email" name="email"  value="<?php echo isset($carDetails['owner_info']['email']) ? $carDetails['owner_info']['email'] : ''; ?>" type="text" placeholder="" />
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input class="form-control" id="phone" name="phone" value="<?php echo isset($carDetails['owner_info']['phone']) ? $carDetails['owner_info']['phone'] : ''; ?>" type="number" placeholder="" maxlength="10" />
                                <label for="phone">Phone</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating">
                                <input class="form-control" id="owner_price" name="owner_price"  value="<?php echo isset($carDetails['owner_price']) ? $carDetails['owner_price'] : ''; ?>" type="number" placeholder="" />
                                <label for="owner_price">Owner Price (<?php echo $SITE_CURRENCY;?>)</label>
                            </div>
                            <span class="hint">You will pay this price to the owner of the car.</span>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <textarea class="form-control address" id="address" name="address" placeholder=""></textarea>
                                <label for="address">Address</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5>Details:</h5>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <textarea class="form-control ckeditor" rows="8" cols="50" name="details" id="details"><?php echo isset($carDetails['details']) ? $carDetails['details'] : ''; ?></textarea>
                        </div>
                    </div>
                    <h5>Features:</h5>
                    <p><i>Add multiple features separated by <span style="color: red;">|</span> symbol</i></p>
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <textarea class="form-control" rows="8" cols="50" name="features" id="features"><?php echo isset($carDetails['features']) ? $carDetails['features'] : ''; ?></textarea>
                        </div>
                    </div>
                    <h5>Gallery:</h5>
                    <div class="row mb-5">
                        <div class="col-md-4">
                            <div class="upload-section">
                                <div class="upload-area" id="upload-area">
                                    <h2>Drag & Drop Images Here</h2>
                                    <input type="file" id="file-input" multiple>
                                    <button id="upload-button">Or Select Images</button>
                                </div>
                                <div class="spinner-border" id="spinner" role="status">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div id="dragInstruction" class="drag-instruction"></div>
                            <div id="preview">
                                <?php 
                                if (isset($_REQUEST['id'])) 
                                {
                                    $imagesArray = explode('|', $carDetails['images']);
                                    foreach ($imagesArray as $item) 
                                    {
                                        if($item != '' && file_exists($SITE_URL.'/uploaded-images/car-images/'.$carDetails['vin'] . '/' . $item)) 
                                        {
                                            ?>
                                            <div class="preview-image-container" data-file-name="<?php echo $item; ?>">
                                                <img src="<?php echo $SITE_URL; ?>/uploaded-images/car-images/<?php echo $carDetails['vin'] . '/' . $item; ?>" alt="<?php echo $item; ?>" class="preview-image" />
                                                <button class="zoom-button" onclick="zoomImage(event, '<?php echo $item; ?>')">Zoom</button>
                                                <button class="delete-button" onclick="deleteImage(event, '<?php echo $item; ?>')">Delete</button>
                                            </div>
                                            <?php    
                                        }
                                    }
                                } 
                                ?>
                            </div>
                        </div>

                        <div id="image-modal" class="modal">
                            <span class="close" id="close-modal">&times;</span>
                            <img class="modal-content" id="modal-image">
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

    if (paramId && paramId != '') {
        enableSaveButton();
    } else {
        disableSaveButton();
    }

    // SCRIPT FOR FETCH DATA BY VIN AND YEAR STARTS.
    var makeArray = JSON.parse('<?php echo json_encode($makeArray); ?>');

    // CHECK FOR INPUT VALUES ON KEYUP EVENT FOR BOTH FIELDS.
    document.getElementById('vin').addEventListener('keyup', handleInput);
    document.getElementById('year').addEventListener('change', handleInput);
    document.getElementById('make_id').addEventListener('change', handleInput);
    document.getElementById('model_id').addEventListener('change', handleInput);

    function handleInput() {
        var year = document.getElementById('year').value;
        var vin = document.getElementById('vin').value;
        var make_id = document.getElementById('make_id').value;
        var model_id = document.getElementById('model_id').value;

        if (year != '' && vin != '' && make_id != '' && model_id != '') {
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

    // FUNCTION TO FETCH MODELS ACCORDING TO MAKE CHANGES.
    function ChangeMake(make_id) {
        $("#model_id").html('<option value="">Please wait</option>');

        $.ajax({
            url: "<?php echo $SITE_URL; ?>/admin/ajax/model_by_make.php",
            data: {
                make_id: make_id
            },
            success: function(response) {
                var options = '<option value="">Any</option>';
                if (response) {
                    for (var i = 0; i < response.length; i++) 
                    {
                        if (response[i]['model'] && response[i]['model'] != '') 
                        {
                            options += '<option value="' + response[i]['model_id'] + '">' + response[i]['model'] + '</option>';
                        }
                    }
                    $("#model_id").html(options);
                }
            }
        });
    }

    // FUNCTION TO CALL AJAX TO INSERT FORM DATA.
    function onSave(event) {
        event.preventDefault();

        var vin = $('#vin').val();
        var carcondition = $('#carcondition').val();
        var year = $('#year').val();
        var make_id = $('#make_id').val();
        var model_id = $('#model_id').val();

        if(vin.trim() == '') {
            showToast('Vin is required', 'error');
            return;
        }

        if(carcondition.trim() == '') {
            showToast('Car Condition is required', 'error');
            return;
        }

        if(year.trim() == '') {
            showToast('Year is required', 'error');
            return;
        }

        if(make_id.trim() == '') {
            showToast('Make is required', 'error');
            return;
        }

        if(model_id.trim() == '') {
            showToast('Model is required', 'error');
            return;
        }

        var owner_price = $('#owner_price').val();
        var website_price = $('#website_price').val();

        if (website_price < owner_price)
        {
            showToast('Your website price should be more than owner price. Otherwise dashboard will show in loss.', 'error');
            return;
        }


        var details = tinymce.get('details').getContent();

        $.ajax({
            url: "<?php echo $SITE_URL; ?>/admin/ajax/addedit_car.php",
            data: {
                id: '<?php echo isset($_REQUEST['id']) ? $_REQUEST['id'] : ''; ?>',
                username: '<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>',
                vin: $('#vin').val(),
                carcondition: $('#carcondition').val(),
                year: $('#year').val(),
                make_id: $('#make_id').val(),
                model_id: $('#model_id').val(),
                varient: $('#varient').val(),
                bodystyle_id: $('#bodystyle_id').val(),
                mileage: $('#mileage').val(),
                transmission: $('#transmission').val(),
                fuel_type: $('#fuel_type').val(),
                max_power: $('#max_power').val(),
                color: $('#color').val(),
                engine: $('#engine').val(),
                website_price: $('#website_price').val(),
                boot_space: $('#boot_space').val(),
                ground_clearance: $('#ground_clearance').val(),
				cylinders: $('#cylinders').val(),
				max_torque: $('#max_torque').val(),
				seating_capacity: $('#seating_capacity').val(),
                airbags: $('#airbags').val(),
                details: details,
                features: $('#features').val(),
                name: $('#name').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                owner_price: $('#owner_price').val(),
                address: $('#address').val()
            },
            success: function(response) {
                if (response.success == true) {
                    showToast(response.message, 'success');
                    setTimeout(() => {
                        window.location.href = site_url+'/admin/car-addedit.php?id=' + response.edit_id;
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

    // ZOOM IMAGE.
    function zoomImage(event, fileName) {
        event.preventDefault();
        const vin = $('#vin').val();
        const imgSrc = `<?php echo $SITE_URL; ?>/uploaded-images/car-images/${vin}/${fileName}`;
        const modal = document.getElementById('image-modal');
        const modalImage = document.getElementById('modal-image');
        modalImage.src = imgSrc;
        modal.style.display = "block";
    }

    // DELETE IMAGE.
    function deleteImage(event, fileName) {
        showSpinner();
        event.preventDefault();
        const vin = $('#vin').val();

        $.ajax({
            url: "<?php echo $SITE_URL; ?>/admin/ajax/delete_image.php",
            type: 'POST',
            data: {
                fileName: fileName,
                vin: vin
            },
            success: function(response) {
                hideSpinner();
                let responseObj = JSON.parse(response);
                showToast(responseObj.message, 'success');
                let data = responseObj.data;
                createPreviewContainer(data);
            },
            error: function(xhr, status, error) {
                showToast('Failed to delete image.', 'error');
            }
        });
    }

    // CREATE HTML CONTENT FOR PREVIEW IMAGE.
    function createPreviewContainer(data) {
        const preview = document.getElementById('preview');
        const dragInstruction = document.getElementById('dragInstruction');

        preview.innerHTML = '';
        for (let i = 0; i < data.length; i++) {
            htmlContent = `<div class="preview-image-container" data-file-name="${data[i]['imagename']}">
                <img src="${site_url}/uploaded-images/car-images/${data[i]['vin']}/${data[i]['imagename']}" alt="${data[i]['imagename']}" class="preview-image">
                <button class="zoom-button" onclick="zoomImage(event, '${data[i]['imagename']}')">Zoom</button>
                <button class="delete-button" onclick="deleteImage(event, '${data[i]['imagename']}')">Delete</button>
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

    // CALL AJAX TO REARRANGE THE ORDER OF THE IMAGES.
    function reOrderImages(vin, filesArray) {
        showSpinner();
        let fileNamesArray = filesArray.map(file => file.name);
        let filesArrayString = JSON.stringify(fileNamesArray);

        let paramObj = {
            vin: vin,
            filesArray: filesArrayString
        }

        $.ajax({
            url: "<?php echo $SITE_URL; ?>/admin/ajax/update_order_images.php",
            type: 'POST',
            data: paramObj,
            success: function(response) {
                hideSpinner();

                if (response.success == true) {
                    showToast(response.message, 'success');
                } else {
                    showToast(response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                showToast('Something went wrong.', 'error');
            }
        });
    }

    // CALL API TO GET IMAGES BY VIN.
    function getImagesByVin(vin) {
        $.ajax({
            url: "<?php echo $SITE_URL; ?>/admin/ajax/get_images_by_vin.php",
            type: 'POST',
            data: {
                vin: vin
            },
            success: function(response) {
                console.log(response.length, "response");
                if (response.length > 0) {
                    createPreviewContainer(response);

                    let toastmessage = 'Image found!';
                    if (response.length > 1) {
                        toastmessage = 'Images found!';
                    }

                    showToast(toastmessage, '');
                }

            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // SCRIPT FOR IMAGE UPLOAD STARTS.
    document.addEventListener('DOMContentLoaded', () => {
        const uploadArea = document.getElementById('upload-area');
        const fileInput = document.getElementById('file-input');
        const uploadButton = document.getElementById('upload-button');
        const preview = document.getElementById('preview');
        const modal = document.getElementById('image-modal');
        const closeModal = document.getElementById('close-modal');
        var imagesCount = <?php echo count($imagesArray); ?>;
        var dragInstruction = document.getElementById('dragInstruction');
        let filesArray = [];

        if (imagesCount >= 2) {
            dragInstruction.innerHTML = 'Drag to rearrange the order of the images.';
            dragInstruction.classList.add('show');
        } else {
            dragInstruction.classList.remove('show');
            setTimeout(() => {
                dragInstruction.innerHTML = '';
            }, 500);
        }

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
            const vin = $('#vin').val();
            if (!vin) {
                showToast('VIN is required', 'error');
                // alert('VIN value is required');
                return;
            }
            for (const file of files) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        const fileName = file.name;
                        const imgSrc = event.target.result;

                        var chunkDataObj = {
                            fileName,
                            imgSrc,
                            vin
                        };

                        // Add file to filesArray
                        // filesArray.push(file);

                        filesArray.push({ name: fileName});

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
                url: "<?php echo $SITE_URL; ?>/admin/ajax/upload_image.php",
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

        // Initialize SortableJS
        const sortable = new Sortable(preview, {
            animation: 150,
            onEnd: function(evt) {
                const items = Array.from(preview.children);
                const newFilesArray = [];
                items.forEach(item => {
                    const fileName = item.getAttribute('data-file-name');
                    if (fileName) {
                        newFilesArray.push({name: fileName});
                    }
                });

                let vin = $('#vin').val();

                setTimeout(() => {
                    reOrderImages(vin, newFilesArray);
                }, 1000);

            },
        });

    });
    // SCRIPT FOR IMAGE UPLOAD ENDS.
</script>

<?php include("./layouts/footer.php"); ?>