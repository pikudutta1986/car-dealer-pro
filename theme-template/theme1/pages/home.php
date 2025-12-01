<!-- Hero Section Begin -->
<?php
	$homePageSetting = $pageClassObject->getAdminHomePageSettings();
	$activeBodyStyle = $carsClassObject->getActiveBodyStyle();
	$homepageCars = $carsClassObject->getHomePageCars($homePageSetting['numberofcars']);
	$activeMakes = $carsClassObject->getActiveMake();
	
	// SET THE DEFAULT BANNER IMAGE
	$banner_image = $SITE_URL.'/theme-template/'.$ACTIVE_THEME.'/img/buick-1400243_1920.jpg';

	if ($homePageSetting['banner_image'] != '' && file_exists($SITE_ROOT.'uploaded-images/'.$homePageSetting['banner_image'])) {
		$banner_image = $SITE_URL.'/uploaded-images/'.$homePageSetting['banner_image'];
	}
?>
<section class="hero spad set-bg" data-setbg="<?php echo $banner_image;?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="hero__text">
                    <div class="hero__text__title">
                        <span><?php echo $homePageSetting['banner_heading1'];?></span>
                        <h2><?php echo $homePageSetting['banner_heading2'];?></h2>
					</div>
                    <div class="hero__text__price">
                        <a href="#" class="primary-btn"><img src="<?php echo $SITE_URL?>/theme-template/<?php echo $ACTIVE_THEME;?>/img/wheel.png" alt=""> <?php echo $lowestCar['year'];?> <?php echo $lowestCar['make'] ?> <?php echo $lowestCar['model']; ?></a>
                        <h2 style="font-size: 30px; margin: 20px 0"><span>Starts @ </span> <?php echo $SITE_CURRENCY;?><?php echo number_format($lowestCar['website_price']); ?></h2>
					</div>
				</div>
			</div>
            <div class="col-lg-5">
                <div class="hero__tab">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="hero__tab__form">
                                <h2>Find Your Dream Car</h2>
                                <form action="<?php echo $SITE_URL?>/cars" method="get">
                                    <div class="select-list">
                                        <div class="select-list-item">
                                            <select name="make" id="make" onchange="ChangeMake(this.value,'model')">
                                                <option value="">Select Make</option>
												<?php
													foreach($globalCarMakes as $item)
													{ 
													?>
                                                    <option  value='<?php echo $item['make_slug'];?>'><?php echo $item['make'];?></option>
                                                    <?php
													}
												?>
											</select>
										</div>
                                        <div class="select-list-item">
                                            <select name="model" id="model">
                                                <option  value="">Select Model</option>
											</select>
										</div>
                                        <div class="select-list-item">
                                            <select name="year" id="year">
                                                <option value="">Select Year</option>  
												<?php
													$currentYear = date("Y");
													$startYear = $currentYear - 15;
													for ($year = $currentYear; $year >= $startYear; $year--) {
                                                        echo "<option value='$year'>$year</option>";
													}
												?>
											</select>
										</div>
                                        <div class="select-list-item">
                                            <select name="body_style" id="body_style">
                                                <option value="">Select Bodystyle</option>
												<?php
													foreach($activeBodyStyle as $item)
													{ 
													?>
                                                    <option  value='$item'><?php echo $item['bodystyle'];?></option>
                                                    <?php
													}
												?>
											</select>
										</div>
									</div>
                                    <div class="car-price">
                                        <p>Price Range:</p>
                                        <div class="price-range-wrap">
                                            <div class="price-range"></div>
                                            <div class="range-slider">
                                                <div class="price-input">
                                                    <input type="text" id="amount">
												</div>
											</div>
										</div>
										<input type="hidden" id="filterAmount" name="filterAmount" />
									</div>
                                    <button type="submit" class="site-btn">Search</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php if($homePageSetting['show_bodystyle'] == 'Y'){?>
	<section class="latest-body-style">
		<div class="body-style">
			<?php foreach($activeBodyStyle as $item){?>	
				<?php if($item['image'] && $item['image'] != ''){ ?>
					<a class="link-decoration" href="<?php echo $SITE_URL?>/body-style/<?php echo $item['slug'];?>">
						<img class="bodystyle_image" src="<?php echo $SITE_URL?>/uploaded-images/bodystyle-images/<?php echo $item['image'];?>" alt="<?php echo $item['image'];?>">
					</a>
				<?php } ?>
			<?php } ?>
		</div>
	</section>
<?php } ?>
<!-- Hero Section End -->

<!-- Car Section Begin -->
<section class="car spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
					<h2><?php echo $homePageSetting['cargrid_heading'];?></h2>
				</div>
			</div>
		</div>
        <div class="row car-filter">
			<?php foreach($homepageCars as $carItem){?>
				<div class="col-lg-3 col-md-6 col-sm-6 mix sale">
					<div class="car__item">
						<?php if($carItem['carcondition'] == 'NEW'){?>
							<img class="new-icon" src="<?php echo $SITE_URL?>/theme-template/<?php echo $ACTIVE_THEME;?>/img/new.png" /> 
						<?php } ?>
						<div class="car__item__pic__slider owl-carousel">
							<?php foreach($carItem['carimages'] as $itemImage){?>
								<a href="<?php echo $carsClassObject->getCarLink($SITE_URL, $carItem);?>"><img src="<?php echo $SITE_URL?>/uploaded-images/car-images/<?php echo $carItem['vin'];?>/<?php echo $itemImage['imagename'];?>" alt=""></a>
							<?php } ?>
						</div>
						<div class="car__item__text">
							<div class="car__item__text__inner">
								<div class="label-date"><?php echo $carItem['year'];?></div>
								<h5><a href="<?php echo $carsClassObject->getCarLink($SITE_URL, $carItem);?>"><?php echo $carItem['make'];?> <?php echo $carItem['model'];?></a></h5>
								<ul>
									<li>
										<img class="list-icon" src="<?php echo $SITE_URL ?>/theme-template/<?php echo $ACTIVE_THEME; ?>/img/mileage.svg" />
										<span>
											<?php 
											echo $carItem['mileage'] 
												? number_format($carItem['mileage']) . ' ' . $DISTANCE_UNIT 
												: '<span class="unavailable">Unavailable</span>'; 
											?>
										</span>
										</li>
									<li><img class="list-icon" src="<?php echo $SITE_URL?>/theme-template/<?php echo $ACTIVE_THEME;?>/img/engine.svg" /> <span><?php echo $carItem['engine'] ? $carItem['engine'].' CC' : '<span class="unavailable">Unavailable</span>';?></span></li>
									<li><img class="list-icon" src="<?php echo $SITE_URL?>/theme-template/<?php echo $ACTIVE_THEME;?>/img/fueltype.svg" /> <span><?php echo $carItem['fuel_type'] ? $carItem['fuel_type'] : '<span class="unavailable">Unavailable</span>';?></span></li>
									<li><img class="list-icon" src="<?php echo $SITE_URL?>/theme-template/<?php echo $ACTIVE_THEME;?>/img/transmission.svg" /> <span><?php echo $carItem['transmission'] ? $carItem['transmission'] : '<span class="unavailable">Unavailable</span>';?></span></li>
									<li><img class="list-icon" src="<?php echo $SITE_URL?>/theme-template/<?php echo $ACTIVE_THEME;?>/img/airbag.svg" /> <span><?php echo $carItem['airbags'] ? $carItem['airbags'].' Airbags' : '<span class="unavailable">Unavailable</span>';?></span></li>
									<li><img class="list-icon" src="<?php echo $SITE_URL?>/theme-template/<?php echo $ACTIVE_THEME;?>/img/seats.svg" /> <span><?php echo $carItem['seating_capacity'] ? $carItem['seating_capacity'].' Seater' : '<span class="unavailable">Unavailable</span>';?></span></li>
								</ul>
							</div>
							<div class="car__item__price row">
								<div class="col-md-6 car-option"><a class="white-link" href="<?php echo $carsClassObject->getCarLink($SITE_URL, $carItem);?>">View Details</a></div>
								<div class="col-md-6 car-option2"><?php echo $SITE_CURRENCY;?><?php echo number_format($carItem['website_price']);?></div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			
		</div>
	</div>
</section>
<!-- Car Section End -->

<div class="home-content">
	<div class="container text-center">
		<?php echo $homePageSetting['content'];?>
	</div>
<!-- content Section End -->
</div> 

<!-- Latest Blog Section End -->
<?php if($homePageSetting['show_make'] == 'Y'){?>
	<div class="container">
		<div class="logo-carousel owl-carousel">
			<?php foreach($activeMakes as $make){?>
				<?php if($make['image'] && $make['image'] != ''){?>
					<div class="logo-item"><a href="<?php echo $SITE_URL?>/make/<?php echo $make['make_slug'];?>"><img src="<?php echo $SITE_URL?>/uploaded-images/make-images/<?php echo $make['image'];?>" alt="<?php echo $make['make'];?>"></a></div>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
<?php } ?>