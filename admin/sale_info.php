
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

if (isset($_REQUEST['vin'])) {
    $saleDetails = $cars->getSaleDetailsByVIN($_REQUEST['vin']);
    $sellerData = $user->getUserRowById($saleDetails['owner_id']);
    $buyerData = $user->getUserRowById($saleDetails['buyer_id']);
    $carDetails = $cars->getCarDetailsByVIN($_REQUEST['vin']);
} else {
    header("Location: ".$SITE_URL."/admin/cars.php");
}

include("./layouts/header.php");
include("./layouts/navbar.php");
include("./layouts/sidebar.php");
?>

<main>
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-md-6">
                <h1 class="mt-4">Sale Details</h1>
            </div>
            <div class="col-md-6">
                <div class="create-button-div text-right">
                    <a class="btn btn-dark btn-block" id="saveButton" onclick="gotoCars(event)">Back to car list</a>
                </div>
            </div>
        </div>
        
        <form>
            <div class="row mb-5">
                <div class="col-md-4 info-text">
                    <h5>Car Information:</h5>
                    VIN: <?php echo $carDetails['vin'];?><br/>
                    Make: <?php echo $carDetails['make'];?><br/>
                    Model: <?php echo $carDetails['model'];?><br/>
                    Year: <?php echo $carDetails['year'];?><br/>
                    Owner Price: <?php echo $SITE_CURRENCY;?><?php echo number_format($carDetails['owner_price']);?><br/>
                    Website Price: <?php echo $SITE_CURRENCY;?><?php echo number_format($carDetails['website_price']);?>
                </div>
                <div class="col-md-4 info-text">
                    <h5>Last Seller Information:</h5>
                    <label>Name</label><span>:</span> <?php echo $sellerData['name'];?><br/>
                    <label>Email</label><span>:</span> <?php echo $sellerData['email'];?><br/>
                    <label>Phone</label><span>:</span> <?php echo $sellerData['phone'];?><br/>
                    <label>Address</label><span>:</span> <?php echo $sellerData['address'];?>
                </div>
                <div class="col-md-4 info-text">
                    <h5>Last Buyer Information:</h5>
                    <label>Name</label><span>:</span> <?php echo $buyerData['name'];?><br/>
                    <label>Email</label><span>:</span> <?php echo $buyerData['email'];?><br/>
                    <label>Phone</label><span>:</span> <?php echo $buyerData['phone'];?><br/>
                    <label>Address</label><span>:</span> <?php echo $buyerData['address'];?>
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

    function gotoCars()
    {
        window.location.href = site_url+'/admin/cars.php';
    }
</script>

<?php include("./layouts/footer.php"); ?>