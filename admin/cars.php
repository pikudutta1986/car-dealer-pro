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

$listings = $cars->getCarsLists();
?> 
<main>
    <div class="container-fluid px-4">
        
        <div class="row">
            <div class="col-md-6">
                <h1 class="mt-4">Cars</h1>
            </div>
            <div class="col-md-6 text-right">
                <!-- <a class="btn btn-primary mt-4" href="<?php echo $SITE_URL; ?>/inventory/<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>.txt" target="_blank">Download CSV</a> -->
                <a class="btn btn-primary mt-4" href="<?php echo $SITE_URL; ?>/admin/car-addedit.php">Add New</a>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i> Cars
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Car Info</th>
                            <th>Date</th>
                            <th>Price</th>
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
                                <td>
                                    <?php if (isset($item['image']) && file_exists($SITE_URL.'/uploaded-images/car-images/'.$item['vin'] . '/' . $item['image'])) { ?>
                                    <img class="table-car-image" src="<?php echo $SITE_URL; ?>/uploaded-images/car-images/<?php echo $item['vin'] . '/' . $item['image'];?>" alt="<?php echo $item['image'];?>" />
                                    <?php } else { ?>
                                    <img class="table-car-image" src="<?php echo $SITE_URL; ?>/assets/images/car-no-photo.jpg" alt="<?php echo $item['image'];?>" />  
                                    <?php } ?>
                                </td>
                                <td>
                                    Condition: <?php echo ($item['carcondition'] == 'NEW') ? '<b>NEW</b>' : 'USED'; ?><br>
                                    VIN: <?php echo $item['vin']; ?><br>
                                    Make: <?php echo $item['make']; ?><br>
                                    Model: <?php echo $item['model']; ?><br>
                                    Body Style: <?php echo $item['bodystyle']; ?><br>
                                    Year: <?php echo $item['year']; ?><br>
                                    Mileage: <?php echo $item['mileage'].' '.$DISTANCE_UNIT; ?>
                                </td>
                                <td>
                                    Added: <?php echo $cars->displayDate($item['dateadded']); ?><br>
                                    <?php if ($item['status'] == 'SOLD OUT') { ?><span class="sold-price">Sold: <?php echo $cars->displayDate($item['saledate']);?><span><?php } ?>
                                </td>
                                <td>
                                    <?php if ($item['owner_price'] != '') { ?>Owner price: <?php echo $SITE_CURRENCY;?><?php echo number_format($item['owner_price']);?><br><?php } ?>
                                    Website Price: <?php echo $SITE_CURRENCY;?><?php echo number_format($item['website_price']);?><br>
                                    <?php if ($item['status'] == 'SOLD OUT') { ?><span class="sold-price">Sold price: <?php echo $SITE_CURRENCY;?><?php echo number_format($item['sale_price']);?><span><?php } ?>
                                </td>
                                <td><span class="<?php echo str_replace(' ', '-', strtolower($item['status']));?>"><?php echo $item['status'];?><span></td>
                                <td>
                                    <?php if ($item['status'] == 'AVAILABLE') { ?><a class="btn btn-primary edit-button" href="<?php echo $SITE_URL; ?>/admin/car-addedit.php?id=<?php echo $item['id']; ?>">EDIT</a><?php } ?>
                                    <?php if ($item['status'] == 'AVAILABLE') { ?><a class="btn btn-dark edit-button" href="<?php echo $SITE_URL; ?>/admin/car-delete.php?id=<?php echo $item['id']; ?>">DELETE</a><?php } ?>
                                    <?php if ($item['status'] == 'AVAILABLE') { ?><a class="btn btn-danger edit-button" href="<?php echo $SITE_URL; ?>/admin/car-sale.php?id=<?php echo $item['id']; ?>">SELL IT</a><?php } ?>
                                    <?php if ($item['status'] == 'SOLD OUT') { ?><a class="btn btn-danger edit-button" href="<?php echo $SITE_URL; ?>/admin/sale_info.php?vin=<?php echo $item['vin']; ?>">VIEW SALE INFO</a><?php } ?>
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
