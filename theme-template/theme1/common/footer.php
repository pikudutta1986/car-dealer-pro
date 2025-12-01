
<!-- Footer Section Begin -->
<footer class="footer set-bg" data-setbg="<?php echo $SITE_URL?>/theme-template/theme1/img/footer-bg.jpg">
	<div class="container">
		<div class="footer__contact">
			<div class="row">
				<div class="col-lg-6 col-md-6">
					<div class="footer__contact__title">
						<h2>Contact Us Now!</h2>
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
					<div class="footer__contact__option">
						<div class="option__item"><i class="fa fa-phone"></i> <?php echo $SITE_INFO['phone'];?></div>
						<div class="option__item email"><i class="fa fa-envelope-o"></i> <?php echo $SITE_INFO['email'];?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 col-md-4">
				<div class="footer__about">
					<div class="footer__logo">
						<a href="<?php echo $SITE_URL;?>"><img src="<?php echo $SITE_LOGO;?>" alt="<?php echo $SITE_NAME;?>"></a>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-3">
				<div class="footer__widget">
					<p>Any questions? Let us know in <?php echo $SITE_INFO['address'];?>, <?php echo $SITE_INFO['city'];?>, <?php echo $SITE_INFO['state'];?> or call us
					on <?php echo $SITE_INFO['phone'];?>.</p>
					<div class="footer__social">
						<a target="_blank" href="<?php echo $socialLinks['fb_page_link'];?>" class="facebook"><i class="fa fa-facebook"></i></a>
						<a target="_blank" href="<?php echo $socialLinks['twitter_page_link'];?>" class="twitter"><i class="fa fa-twitter"></i></a>
						<a target="_blank" href="<?php echo $socialLinks['yt_page_link'];?>" class="google"><i class="fa fa-youtube"></i></a>
						<a target="_blank" href="<?php echo $socialLinks['insta_page_link'];?>" class="skype"><i class="fa fa-instagram"></i></a>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="footer__brand">
					<h5>Top Brand</h5>
					<ul class="two-column-list">
						<?php $i=0; foreach($globalCarMakes as $item){ ?>
							<li><a href="<?php echo $SITE_URL?>/make/<?php echo $item['make_slug'];?>"><i class="fa fa-angle-right"></i> <?php echo $item['make'];?></a></li>
							<?php if($i == 5){
								break;
							} ?>
						<?php $i++;} ?>
					</ul>
					
				</div>
			</div>
		</div>
		<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
		<div class="footer__copyright__text">
			<p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</p>
		</div>
		<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
	</div>
</footer>
<!-- Footer Section End -->

<!-- Search Begin -->
<div class="search-model">
	<div class="h-100 d-flex align-items-center justify-content-center">
		<div class="search-close-switch">+</div>
		<form class="search-model-form">
			<input type="text" id="search-input" placeholder="Search here.....">
		</form>
	</div>
</div>
<!-- Search End -->

<!-- Js Plugins -->
<script src="<?php echo $SITE_URL?>/theme-template/theme1/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo $SITE_URL?>/theme-template/theme1/js/bootstrap.min.js"></script>
<script src="<?php echo $SITE_URL?>/theme-template/theme1/js/jquery.nice-select.min.js"></script>
<script src="<?php echo $SITE_URL?>/theme-template/theme1/js/jquery-ui.min.js"></script>
<script src="<?php echo $SITE_URL?>/theme-template/theme1/js/jquery.magnific-popup.min.js"></script>
<script src="<?php echo $SITE_URL?>/theme-template/theme1/js/mixitup.min.js"></script>
<script src="<?php echo $SITE_URL?>/theme-template/theme1/js/jquery.slicknav.js"></script>
<script src="<?php echo $SITE_URL?>/theme-template/theme1/js/owl.carousel.min.js"></script>
<script src="<?php echo $SITE_URL?>/theme-template/theme1/js/main.js"></script>

<script>
    var SITE_URL = '<?php echo $SITE_URL;?>';    
</script>
<!-- IMPORT THE GLOBAL JS ON ALL THEME -->
<script src="<?php echo $SITE_URL?>/js/global.js"></script>
<!-- Form Validation Script -->
<script src="<?php echo $SITE_URL?>/js/form-validation.js"></script>

<script>
	$(document).ready(function(){
		$('.logo-carousel').owlCarousel({
			loop: true,
			margin: 30,
			autoplay: true,
			autoplayTimeout: 2000,
			autoplayHoverPause: true,
			responsive:{
				0:{ items:2 },
				600:{ items:4 },
				1000:{ items:8 }
			}
		});
		
		$('.body-style-carousel').owlCarousel({
			loop: true,
			margin: 30,
			autoplay: true,
			autoplayTimeout: 2000,
			autoplayHoverPause: true,
			responsive:{
				0:{ items:2 },
				600:{ items:3 },
				1000:{ items:6 }
			}
		});
	});

	
    /*-----------------------
		Range Slider
	------------------------ */
	var SITE_CURRENCY = '<?php echo $SITE_CURRENCY;?>';
	var LOWEST_PRICE = '<?php echo $lowestCar['website_price'];?>';
	var HIGHEST_PRICE = '<?php echo $highestCar['website_price'];?>';
	var START_VALUE = LOWEST_PRICE;
	var END_VALUE = HIGHEST_PRICE;
	const formatterUS = new Intl.NumberFormat('en-US');

	var filterAmount = '<?php echo isset($_GET['filterAmount']) ? $_GET['filterAmount'] : '';?>';

	if (filterAmount != '')
	{
		var amountArray = filterAmount.split('-');
		START_VALUE = amountArray[0];
		END_VALUE = amountArray[1];
	}

    var rangeSlider = $(".price-range");
    rangeSlider.slider({
        range: true,
        min: parseInt(LOWEST_PRICE),
        max: parseInt(HIGHEST_PRICE),
        values: [START_VALUE, END_VALUE],
        slide: function (event, ui) {
			// CHANGE DISPLAY AMOUNT ON SLIDER CHANGE
            $("#amount").val(SITE_CURRENCY + formatterUS.format(ui.values[0]) + " - "+ SITE_CURRENCY + formatterUS.format(ui.values[1]));

			// CHANGE RAW AMOUNT ON SLIDER CHANGE
			$("#filterAmount").val(ui.values[0]+"-"+ui.values[1]);
        }
    });
	// DISPLAY AMOUNT ON SLIDER ON PAGE LOAD
    $("#amount").val(SITE_CURRENCY + formatterUS.format($(".price-range").slider("values", 0)) + " - " + SITE_CURRENCY + formatterUS.format($(".price-range").slider("values", 1)));
	// HOLD RAW AMOUNT ON PAGE LOAD
    $("#filterAmount").val($(".price-range").slider("values", 0)+"-"+$(".price-range").slider("values", 1));

</script>
</body>
</html>