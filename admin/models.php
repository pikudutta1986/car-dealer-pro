<?php 
//error_reporting(0);
session_start();
include("../config/index.php");

if($_SESSION['username'] =='')
{
    header("Location: ".$SITE_URL."/admin/login.php");
    die();
}



include("./class/Cars.php");
$cars = new Cars($dbObject);

include ("./layouts/header.php");
include ("./layouts/navbar.php");
include ("./layouts/sidebar.php");

if(isset($_SESSION['username'])) {
    $listings = $cars->getAllMakeModels();
}

?> 
<main>
    <div class="container-fluid px-4">
        
        <div class="row">
            <div class="col-md-6">
                <h1 class="mt-4">Models</h1>
            </div>
            <div class="col-md-6 text-right">
                <a class="btn btn-primary mt-4" href="<?php echo $SITE_URL; ?>/admin/model-addedit.php">Add New</a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> Models
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Model</th>
                            <th>Make</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($listings as $item) 
                        {
                            ?>
                            <tr>
                                <td><?php echo $item['model']; ?></td>
                                <td><?php echo $item['make']; ?></td>
                                <td><span class="<?php echo str_replace(' ', '-', strtolower($item['status']));?>"><?php echo $item['status'];?><span></td>
                                <td>
                                    <a class="btn btn-primary edit-button" href="<?php echo $SITE_URL; ?>/admin/model-addedit.php?id=<?php echo $item['model_id']; ?>">EDIT</a>
                                    <a class="btn btn-dark edit-button" href="<?php echo $SITE_URL; ?>/admin/model-delete.php?id=<?php echo $item['model_id']; ?>">DELETE</a>
                                </td>
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
