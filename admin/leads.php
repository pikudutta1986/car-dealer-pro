<?php 
//error_reporting(0);
session_start();
include("../config/index.php");

if($_SESSION['username'] =='')
{
    header("Location: ".$SITE_URL."/admin/login.php");
    die();
}

include("./class/User.php");
$user = new User($dbObject);

include("./class/Cars.php");
$cars = new Cars($dbObject);

include ("./layouts/header.php");
include ("./layouts/navbar.php");
include ("./layouts/sidebar.php");

if(isset($_SESSION['username'])) {
    $userdata = $user->getAllLeads();
}

?> 
<main>
    <div class="container-fluid px-4">
        
        <div class="row">
            <div class="col-md-6">
                <h1 class="mt-4">Leads</h1>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> All leads from website that looking for cars.
            </div>

            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Car</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($userdata as $item) 
                        {
                            $carData = $cars->getCarDetailsByVIN($item['vin']);
                            $carLink = $cars->getCarLink($SITE_URL, $carData);
                            ?>
                            <tr>
                                <td><a target="_blank" href="<?php echo $carLink;?>"><u><?php echo $item['vin'];?></u></a></td>
                                <td><?php echo $item['name']; ?></td>
                                <td><?php echo $item['email']; ?></td>
                                <td><?php echo $item['phone']; ?></td>
                                <td><?php echo $item['message']; ?></td>
                            </tr>
                            <?php 
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
</main>

<?php include("./layouts/footer.php"); ?>
