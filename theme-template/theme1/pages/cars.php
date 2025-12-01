<?php 
// Setup pagination
$page = isset($_REQUEST['page']) && is_numeric($_REQUEST['page']) ? (int)$_REQUEST['page'] : 1;

$activeMake = $carsClassObject->getActiveMake();
$activeBodyStyle = $carsClassObject->getActiveBodyStyle();
$activeModels = array();
$requestData = $_REQUEST;
if(isset($_REQUEST['make']))
{
	$activeModels = $carsClassObject->getActiveModelByMakeSlug($_REQUEST['make']);
}

$searchCars = $carsClassObject->getSearchCars($requestData);

// echo '<pre>';
// print_r($searchCars);
?>
<!-- Breadcrumb End -->
<div class="breadcrumb-option set-bg" data-setbg="<?php echo $SITE_URL?>/theme-template/theme1/img/breadcrumb-bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Our Latest Cars</h2>
                    <div class="breadcrumb__links">
                        <a href="<?php echo $SITE_URL?>"><i class="fa fa-home"></i> Home</a>
                        <span>Cars</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Breadcrumb Begin -->

<!-- Car Section Begin -->
<section class="car spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="car__sidebar">
                    <div class="car__filter">
                        <h5>Car Filter</h5>
						<form action="" method="get" onsubmit="return applyFilters(event);">
                            <select name="make" id="make" onchange="ChangeMake(this.value,'model')">
                                <option data-display="Make" value="">Select Make</option>
                                <?php
									foreach($activeMake as $item)
									{ 
									?>
                                    <option value='<?php echo $item['make_slug'];?>' <?php if($requestData['make'] == $item['make_slug']){?>selected<?php } ?>><?php echo $item['make'];?></option>
									<?php
									}
								?>
							</select>
                            <select name="model" id="model">
                                <option data-display="Model" value="">Select Model</option>
								<?php
									foreach($activeModels as $item)
									{ 
									?>
                                    <option value='<?php echo $item['model_slug'];?>' <?php if($requestData['model'] == $item['model_slug']){?>selected<?php } ?>><?php echo $item['model'];?></option>
									<?php
									}
								?>
							</select>
                            <select name="body_style" id="body_style">
                                <option data-display="Body Style" value="">Select Body Style</option>
                                <?php
                                    foreach($activeBodyStyle as $item)
                                    { 
									?>
									<option value='<?php echo $item['slug'];?>' <?php if($requestData['body_style'] == $item['slug']){?>selected<?php } ?>><?php echo $item['bodystyle'];?></option>
									<?php
									}
								?>
							</select>
                            <select name="fuel_type" id="fuel_type">
                                <option data-display="Fuel Type" value="">Select Fuel Type</option>
                                <?php
									foreach ($FUEL_TYPES as $item) {?>
									<option value='<?php echo $item;?>'  <?php if($requestData['fuel_type'] == $item){?>selected<?php } ?>><?php echo $item;?></option>
								<?php } ?>
							</select>
                            <select name="transmisson" id="transmisson">
                                <option value="">Select Transmisson</option>
                                <?php
									foreach ($TRANSMISSION as $item) {?>
									<option value='<?php echo $item;?>'  <?php if($requestData['transmisson'] == $item){?>selected<?php } ?>><?php echo $item;?></option>
								<?php } ?>
								
							</select>
                            <select name="mileage" id="mileage">
                                <option data-display="Mileage" value="">Select Mileage</option>
								<?php
									foreach ($MILEAGE_ARRAY as $item) {?>
									<option value='<?php echo $item;?>' <?php if($requestData['mileage'] == $item){?>selected<?php } ?>><?php echo number_format($item);?></option>
								<?php } ?>
							</select>
                            <div class="filter-price">
                                <p>Price:</p>
                                <div class="price-range-wrap">
                                    <div class="price-range"></div>
                                    <div class="range-slider">
                                        <div class="price-input">
                                            <input type="text" id="amount">
										</div>
									</div>
								</div>
								<input type="hidden" id="filterAmount" />
							</div>
                            <div class="car__filter__btn">
                                <button class="site-btn" type="submit">FIlter</button>
							</div>
						</form>
					</div>
				</div>
			</div>
            <div class="col-lg-9">
                <div class="car__filter__option">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
							<div class="car__filter__option__item car__filter__option__item--left" style="padding-top: 10px;">
								<h6>Total Cars : <?php echo $searchCars['totalRows'];?></h6>
							</div>
						</div>
                        <div class="col-lg-6 col-md-6">
                            <div class="car__filter__option__item car__filter__option__item--right">
                                <h6>Sort By</h6>
                                <select id="sort_by" name="sort_by" onchange="return applySort(event);">
									<option value="asc" <?php if(!isset($requestData['sort_by']) || (isset($requestData['sort_by']) && ($requestData['sort_by'] == '' || $requestData['sort_by'] == 'asc'))){?>selected<?php } ?>>Price: Lowest Fist</option>
                                    <option value="desc" <?php if(isset($requestData['sort_by']) && $requestData['sort_by'] == 'desc'){?>selected<?php } ?>>Price: Highest Fist</option>
								</select>
							</div>
						</div>
					</div>
				</div>
                <div class="row">
					<?php foreach($searchCars['data'] as $carItem){ 
					?>
					<div class="col-lg-4 col-md-6">
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
									<ul><li><img class="list-icon" src="<?php echo $SITE_URL ?>/theme-template/<?php echo $ACTIVE_THEME; ?>/img/mileage.svg" />
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
				
				<?php
					// Copy current GET params
					$currentParams = $_GET;
					
					// Remove 'page' if set, so we can override it for each link
					unset($currentParams['page']);
				?>
				<div class="pagination__option">
					<?php if ($page > 1): ?>
					<a href="?<?= http_build_query(array_merge($currentParams, ['page' => $page - 1])) ?>">«</a>
					<?php endif; ?>
					
					<?php for ($p = 1; $p <= $searchCars['totalPages']; $p++): ?>
					<a href="?<?= http_build_query(array_merge($currentParams, ['page' => $p])) ?>"
					class="<?= $p === $page ? 'active' : '' ?>"
					<?= $p === $page ? 'style="font-weight:bold;"' : '' ?>>
						<?= $p ?>
					</a>
					<?php endfor; ?>
					
					<?php if ($page < $searchCars['totalPages']): ?>
					<a href="?<?= http_build_query(array_merge($currentParams, ['page' => $page + 1])) ?>">»</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<style>
	.pagination__option a.active {
    background-color: #007bff;
    color: white;
    padding: 0;
    border-radius: 4px;
    border-color: #007bff;
	}
</style>
<script>
	function applySort(event)
	{
		event.preventDefault(); // Prevent default form submission
		const url = new URL(window.location.href);
		const params = new URLSearchParams(url.search);

		let sort_by = jQuery('#sort_by').val();
		if(sort_by != '')
		{
			params.set('sort_by', sort_by);	
		}
		else 
		{
			params.delete('sort_by');  // Remove empty fields
		}
		params.delete('page');

			window.location.href = url.pathname + '?' + params.toString();
		return false;
	}
	function applyFilters(event)
	{
		event.preventDefault(); // Prevent default form submission
		const url = new URL(window.location.href);
		const params = new URLSearchParams(url.search);
		
		let make = jQuery('#make').val();
		if(make != '') {
			params.set('make', make);	
		} else {
			params.delete('make');
		}
		
		let model = jQuery('#model').val();
		if(model != '') {
			params.set('model', model);	
		} else {
			params.delete('model');
		}
	
		let body_style = jQuery('#body_style').val();
		if(body_style != '') {
			params.set('body_style', body_style);	
		} else {
			params.delete('body_style');
		}
		
		let fuel_type = jQuery('#fuel_type').val();
		if(fuel_type != '')
		{
			params.set('fuel_type', fuel_type);	
		} else {
			params.delete('fuel_type'); 
		}
		
		let transmisson = jQuery('#transmisson').val();
		if(transmisson != '') {
			params.set('transmisson', transmisson);	
		} else {
			params.delete('transmisson');
		}
		
		let mileage = jQuery('#mileage').val();
		if(mileage != '') {
			params.set('mileage', mileage);	
		} else {
			params.delete('mileage');
		}
		
		let filterAmount = jQuery('#filterAmount').val();
		
		if(filterAmount != '') {
			//console.log('filterAmount', filterAmount);
			params.set('filterAmount', filterAmount);	
		} else {
			params.delete('filterAmount');      // Remove empty fields
		}
		
		let sort_by = jQuery('#sort_by').val();
		if(sort_by != '')
		{
			params.set('sort_by', sort_by);	
		}else {
			params.delete('sort_by');      // Remove empty fields
		}
		params.delete('page');
		// Redirect to the same path with updated params
		window.location.href = url.pathname + '?' + params.toString();
		return false;
	}
</script>