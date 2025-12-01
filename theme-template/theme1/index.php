
<?php
include('common/header.php');


if ($_REQUEST['mod'] == 'home') {
    include('pages/home.php');
}
// register page
if ($_REQUEST['mod'] == 'register') {
    include('pages/registration.php');
}
// login page
if ($_REQUEST['mod'] == 'login') {
    include('pages/login.php');
}
// forget password page
if ($_REQUEST['mod'] == 'forget-password') {
    include('pages/forget-password.php');
}
// set password page
if ($_REQUEST['mod'] == 'set-password') {
    include('pages/set-password.php');
}
// car list page
else if ($_REQUEST['mod'] == 'search') {
    include('pages/cars.php');
}
// car details page
else if ($_REQUEST['mod'] == 'details') {
    include('pages/car-details.php');
}
// any static page
else if ($_REQUEST['mod'] == 'static') {
    include('pages/static.php');
}

// any static page
else if ($_REQUEST['mod'] == 'notfound') {
    include('pages/404.php');
}

include('common/footer.php');