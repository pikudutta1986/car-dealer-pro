<?php 
$carsData = array();
//echo $_GET['vin'];
if(isset($_GET['vin']))
{
	$carsData = $carsClassObject->getCarDetailsByvinid($_GET['vin']);
}
$images = explode('|', $carsData['images']);
// echo '<pre>';
// print_r($images);
$features = explode('|', $carsData['features']);
?>
<div class="breadcrumb-option set-bg" data-setbg="<?php echo $SITE_URL?>/theme-template/<?php echo $ACTIVE_THEME;?>/img/breadcrumb-bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2><?php echo $carsData['year'];?> <?php echo $carsData['make'];?> <?php echo $carsData['model'];?></h2>
                    <div class="breadcrumb__links">
                        <a href="/"><i class="fa fa-home"></i> Home</a>
                        <a href="/cars">Car</a>
                        <span><?php echo $carsData['year'];?> <?php echo $carsData['make'];?> <?php echo $carsData['model'];?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Breadcrumb Begin -->

<!-- Car Details Section Begin -->
<section class="car-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
				<?php if (count($images) > 0) { ?>
                <div class="car__details__pic">
					<?php if($carsData['carcondition'] == 'NEW'){?>
						<img class="new-icon" src="<?php echo $SITE_URL?>/theme-template/<?php echo $ACTIVE_THEME;?>/img/new.png" /> 
					<?php } ?>
					<div class="car__details__pic__large">
						<img class="car-big-img" src="<?php echo $SITE_URL?>/uploaded-images/car-images/<?php echo $carsData['vin'];?>/<?php echo $images[0];?>" alt="">
					</div>
					<?php if (count($images) > 1) { ?>
					<div class="car-thumbs">
						<div class="car-thumbs-track car__thumb__slider owl-carousel">
							<?php foreach($images as $img) { ?>
								<div class="ct" data-imgbigurl="<?php echo $SITE_URL?>/uploaded-images/car-images/<?php echo $carsData['vin'];?>/<?php echo $img;?>"><img
								src="<?php echo $SITE_URL?>/uploaded-images/car-images/<?php echo $carsData['vin'];?>/<?php echo $img;?>" alt=""></div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>
				</div>
				<?php } ?>
                <div class="car__details__tab">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
							Overview</a>
						</li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Features</a>
						</li>
					</ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="car__details__tab__info">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="car__details__tab__info__item">
											<p><?php echo $carsData['details'];?></p>	
										</div>
									</div>
								</div>
							</div>
						</div>
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="car__details__tab__info">
                                <div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="car__details__tab__info__item">
											<ul class="col-2-row">
												<?php foreach($features as $item) { 
													if($item != '') { ?>
														<li><i class="fa fa-check"></i> <?php echo $item;?></li>
													<?php }  
												} ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="col-lg-3">
                <div class="car__details__sidebar">
                    <div class="car__details__sidebar__model">
						<a class="primary-btn w-100" style="border:none;border-radius:8px;" href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $SITE_INFO['address'];?>, <?php echo $SITE_INFO['city'];?>, <?php echo $SITE_INFO['state'];?>" target="_blank"><i class="fa fa-map-marker"></i> Get Directions</a>

						<h4 class="padding">Car Details</h4>
						<ul>
							<li>Condition :<span><?php echo $carsData['carcondition'];?></span></li>
							<li>Vin :<span><?php echo $carsData['vin'];?></span></li>
							<li>Year :<span><?php echo $carsData['year'];?></span></li>
							<li>
								<img class="list-icon" src="<?php echo $SITE_URL ?>/theme-template/<?php echo $ACTIVE_THEME; ?>/img/mileage.svg" /> &nbsp;
								Mileage :
								<span>
									<?php
										if ($carsData['mileage']) {
											echo number_format($carsData['mileage']) . ' ' . $DISTANCE_UNIT;
										} else {
											echo '<span class="unavailable">Unavailable</span>';
										}
									?>
								</span>
							</li>
							<li><img class="list-icon" src="<?php echo $SITE_URL?>/theme-template/<?php echo $ACTIVE_THEME;?>/img/engine.svg" /> &nbsp; Engine : <span><?php echo $carsData['engine'] ? $carsData['engine'].' CC' : '<span class="unavailable">Unavailable</span>';?></span></li>
							<li><img class="list-icon" src="<?php echo $SITE_URL?>/theme-template/<?php echo $ACTIVE_THEME;?>/img/fueltype.svg" /> &nbsp; Fuel Type :<span><?php echo $carsData['fuel_type'] ? $carsData['fuel_type'].'' : '<span class="unavailable">Unavailable</span>';?></span></li>
							<li><img class="list-icon" src="<?php echo $SITE_URL?>/theme-template/<?php echo $ACTIVE_THEME;?>/img/transmission.svg" /> &nbsp; Transmission :<span> <?php echo $carsData['transmission'] ? $carsData['transmission'].'' : '<span class="unavailable">Unavailable</span>';?></span></li>
							<li><img class="list-icon" src="<?php echo $SITE_URL?>/theme-template/<?php echo $ACTIVE_THEME;?>/img/seats.svg" /> &nbsp; Seating Capacity :<span> <?php echo $carsData['seating_capacity'] ? $carsData['seating_capacity'].' Seater' : '<span class="unavailable">Unavailable</span>';?></span></li>
							<li><img class="list-icon" src="<?php echo $SITE_URL?>/theme-template/<?php echo $ACTIVE_THEME;?>/img/airbag.svg" /> &nbsp; Airbags : <span><?php echo $carsData['airbags'] ? $carsData['airbags'].' ' : '<span class="unavailable">Unavailable</span>';?></span></li>
						</ul>
					</div>
					<div class="car__details__sidebar__model">
						<h4>Aditional Info</h4>
						<ul>
							<li>Body Style : <span><?php echo $carsData['bodystyle'] ? $carsData['bodystyle'].'' : '<span class="unavailable">Unavailable</span>';?></span></li>
							<li>Max Torque : <span><?php echo $carsData['max_torque'] ? $carsData['max_torque'].'' : '<span class="unavailable">Unavailable</span>';?></span></li>
							<li>Cylinders : <span><?php echo $carsData['cylinders'] ? $carsData['cylinders'].'' : '<span class="unavailable">Unavailable</span>';?></span></li>
							<li>Ground Clearance :<span><?php echo $carsData['ground_clearance'] ? $carsData['ground_clearance'].'' : '<span class="unavailable">Unavailable</span>';?></span></li>
							<li>Boot Space : <span><?php echo $carsData['boot_space'] ? $carsData['boot_space'].'' : '<span class="unavailable">Unavailable</span>';?></span></li>
							<li>Color :<span><?php echo $carsData['color'] ? $carsData['color'].'' : '<span class="unavailable">Unavailable</span>';?></span></li>
							<li>Max Power: <span><?php echo $carsData['max_power'] ? $carsData['max_power'].'' : '<span class="unavailable">Unavailable</span>';?></span></li>
							
						</ul>
					</div>
					<div class="car__details__sidebar__payment">
						<ul>
							<li>Price <span>₹<?php echo number_format($carsData['website_price']);?></span></li>
						</ul>
						<div class="car__details__sidebar__quote">
							<a class="primary-btn w-100" href="tel:<?php echo $carsData['owner_info']['phone'];?>" style="border:none;border-radius:8px;"> <i class="fa fa-phone"></i>Call Now</a>
						</div>
						<div class="car__details__sidebar__quote">
							<h4>Get a Quote</h4>
							<form action="" method="post" class="mt-4" id="quoteForm">
								<input type="hidden" name="vin" value="<?php echo $carsData['vin']; ?>">
								<div class="form-group">
									<input type="text" class="form-control" name="name" placeholder="Your Name" required>
								</div>
								<div class="form-group">
									<input type="email" class="form-control" name="email" placeholder="Your Email" required>
								</div>
								<div class="form-group">
									<input type="tel" class="form-control" name="phone" placeholder="Phone Number" required>
								</div>
								<div class="form-group">
									<textarea class="form-control" name="message" rows="3" placeholder="Your Message"></textarea>
								</div>
								<button type="submit" class="primary-btn w-100" style="border:none;border-radius:8px;"><i class="fa fa-envelope"></i> Request Quote</button>
								<div id="quoteStatus" class="mt-2"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<style>
	.col-2-row
	{
		columns: 2; -webkit-columns: 2; -moz-columns: 2;
	}
	@media only screen and (max-width: 600px) {
		.col-2-row
		{
			columns: 1; -webkit-columns: 1; -moz-columns: 1;
		}
	}
	</style>
<script>
	document.getElementById('quoteForm').addEventListener('submit', function(e) {
		e.preventDefault();
		const form = e.target;
		const formData = new FormData(form);
		
		fetch('<?php echo $SITE_URL; ?>/ajax/send-quote-email.php', {
			method: 'POST',
			body: formData
		})
		.then(response => response.text())
		.then(data => {
			if(data == 'success')
			{
				document.getElementById('quoteStatus').innerHTML = '<div class="alert alert-success">Quote sent successfully!</div>';
				form.reset();
			}else{
				document.getElementById('quoteStatus').innerHTML = '<div class="alert alert-danger">Failed to send quote.</div>';
			}
		})
		.catch(error => {
			console.error('Error:', error);
			document.getElementById('quoteStatus').innerHTML = '<div class="alert alert-danger">Failed to send quote.</div>';
		});
	});
</script>
<!-- Car Details Section End -->
