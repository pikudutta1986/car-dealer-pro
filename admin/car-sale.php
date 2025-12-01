
<?php
session_start();
include("../config/index.php");

if ($_SESSION['username'] == '') {
    header("Location: ".$SITE_URL."/admin/login.php");
    die();
}

include("./class/Cars.php");
include("./class/User.php");

$cars = new Cars($dbObject);
$user = new User($dbObject);

if (isset($_REQUEST['id'])) {
    $carDetails = $cars->getCarDetailsById($_REQUEST['id']);
    $ownerDetails = $user->getUserRowById($carDetails['owner_id']);
} else {
    header("Location: ".$SITE_URL."/admin/cars.php");
}

include("./layouts/header.php");
include("./layouts/navbar.php");
include("./layouts/sidebar.php");
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Sell Car</h1>
        <form>
            
            <div class="row mb-5">
                <div class="col-md-6 info-text">
                    <h5>Car Information:</h5>
                    <label>VIN</label><span>:</span> <?php echo $carDetails['vin'];?><br/>
                    <label>Make</label><span>:</span> <?php echo $carDetails['make'];?><br/>
                    <label>Model</label><span>:</span> <?php echo $carDetails['model'];?><br/>
                    <label>Year</label><span>:</span> <?php echo $carDetails['year'];?><br/>
                    <label>Owner Price</label><span>:</span> <?php echo $SITE_CURRENCY;?><?php echo number_format($carDetails['owner_price']);?><br/>
                    <label>Website Price</label><span>:</span> <?php echo $SITE_CURRENCY;?><?php echo number_format($carDetails['website_price']);?>
                </div>
                <div class="col-md-6 info-text">
                    <h5>Owner Information:</h5>
                    <label>Name</label><span>:</span> <?php echo $ownerDetails['name'];?><br/>
                    <label>Email</label><span>:</span> <?php echo $ownerDetails['email'];?><br/>
                    <label>Phone</label><span>:</span> <?php echo $ownerDetails['phone'];?><br/>
                    <label>Address</label><span>:</span> <?php echo $ownerDetails['address'];?>
                </div>
            </div>
            <h5>Buyer Information:</h5>
            <input type="hidden" value="<?php echo $carDetails['owner_price'];?>" id="owner_price" />
            <input type="hidden" value="<?php echo $carDetails['website_price'];?>" id="website_price" />
            <input type="hidden" value="<?php echo $carDetails['vin'];?>" id="vin" />
            <div class="row mb-5">
                <div class="col-md-3">
                    <div class="form-floating">
                        <input class="form-control" id="buyername" name="buyername" value="" type="text" placeholder="" />
                        <label for="buyername">Buyer Name</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input class="form-control" id="email" name="email" value="" type="text" placeholder="" />
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input class="form-control" id="phone" name="phone" value="" type="number" placeholder="" maxlength="10" />
                        <label for="phone">Phone</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input class="form-control" id="sale_price" name="sale_price" value="" type="number" placeholder="" />
                        <label for="sale_price">Sell Price (<?php echo $SITE_CURRENCY;?>)</label>
                    </div>
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

    function isValidEmail(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    function isValidPhoneNumber(phone) {
        const regex = /^\d{10}$/; // Adjust digits as needed
        return regex.test(phone);
    }

    disableSaveButton();

    // CHECK FOR INPUT VALUES ON KEYUP EVENT FOR BOTH FIELDS.
    document.getElementById('buyername').addEventListener('keyup', handleInput);
    document.getElementById('email').addEventListener('keyup', handleInput);
    document.getElementById('phone').addEventListener('keyup', handleInput);
    document.getElementById('sale_price').addEventListener('keyup', handleInput);
    document.getElementById('address').addEventListener('keyup', handleInput);

    function handleInput() {
        var buyername = document.getElementById('buyername').value;
        var email = document.getElementById('email').value;
        var phone = document.getElementById('phone').value;
        var sale_price = document.getElementById('sale_price').value;
        
        if (buyername != '' && email != '' && phone != '' && sale_price != '') {
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
        var vin = document.getElementById('vin').value;
        var buyername = document.getElementById('buyername').value;
        var email = document.getElementById('email').value;
        var phone = document.getElementById('phone').value;
        var sale_price = document.getElementById('sale_price').value;
        var address = document.getElementById('address').value;

        if(buyername.trim() == '') {
            showToast('Buyer name is required.', 'error');
            return;
        }

        if(email.trim() == '') {
            showToast('Email is required.', 'error');
            return;
        }

        if(!isValidEmail(email)) {
            showToast('Please enter a valid email.', 'error');
            return;
        }

        if(phone.trim() == '') {
            showToast('Phone is required.', 'error');
            return;
        }
        

        if(!isValidPhoneNumber(phone)) {
            showToast('Please enter a valid phone.', 'error');
            return;
        }

        if(sale_price.trim() == '') {
            showToast('Sale price is required.', 'error');
            return;
        }

        var owner_price = $('#owner_price').val();
        if (sale_price < owner_price)
        {
            showToast('Your Sell price should be more than owner price. Otherwise dashboard will show in loss.', 'error');
            return;
        }

        $.ajax({
            url: "<?php echo $SITE_URL; ?>/admin/ajax/sale_car.php",
            data: {
                vin: vin,
                buyername: buyername,
                email: email,
                phone: phone,
                sale_price: sale_price,
                address: address
            },
            success: function(response) {
                if (response.success == true) {
                    showToast(response.message, 'success');
                    setTimeout(() => {
                        window.location.href = site_url+'/admin/sale_info.php?vin=' + vin;
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