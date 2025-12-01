<div class="car__sidebar">
    <div class="car__filter">
        <h5>Car Filter</h5>
        <form action="" method="get">
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
                    <div class="filter-price-range"></div>
                    <div class="range-slider">
                        <div class="price-input">
                            <input type="text" id="filterAmount">
                        </div>
                    </div>
                </div>
            </div>
            <div class="car__filter__btn">
                <button type="submit" class="site-btn">FIlter</button>
            </div>
        </form>
    </div>
</div>