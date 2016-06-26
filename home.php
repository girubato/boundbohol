<?php
    if (!is_user_logged_in()) {
        echo "<div style='height:100%;'><div style='position:relative;top:40%'><center><img src='".get_template_directory_uri()."/img/coming_soon.png' /></center></div></div>";
        exit;
    }
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
    <meta name="author" content="">
	
	<link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">
    <?php wp_enqueue_script("jquery"); ?>
	<?php wp_head(); ?>
</head>

<body>
<div id="wrapper">

	<header id="header">
	
		<div class="container group">
			<div class="container-inner">
			
				<div class="group">
					<img src='<?php echo get_template_directory_uri(); ?>/img/bbohol-logo.png' />
				</div>
				
			</div><!--/.container-inner-->
		</div><!--/.container-->
	
	</header><!--/#header-->
	
	<div class="home-container">
		<div class="home-container-inner">	
				<div class="group">
					<form class="form-inline" action="<?php echo rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9).rand(0, 9) ?>" method="post">
						<div class="form-group">
							<select class="form-control" name="input_origin" id="input_origin" style="width: 200px; color: gray;">
								<option selected hidden disabled>Origin</option>
								<option>SeaPort</option>
								<option>Airport</option>
							</select>
						</div>
						<div class="form-group">
							<input class="form-control" name="input_arrival" id="input_arrival" placeholder="Arrival Date">
						</div>
						<div class="form-group">
							<input class="form-control" name="input_departure" id="input_departure" placeholder="Departure Date">
						</div>
						<div class="form-group">
							<input type="number" class="form-control" name="input_number" id="input_number" placeholder="No. of Guests">
						</div>
						<button type="submit" class="btn btn-default">Explore Bohol</button>
					</form>
                    <script type="text/javascript">
                        jQuery(function () {
                            jQuery('#input_arrival').datetimepicker();
                            jQuery('#input_departure').datetimepicker();
                        });
                    </script>
				</div>
				
		</div>
	</div>
	
	<div class="how-it-works-container">
		<div class="container group">
			<div class="container-inner">
				<div class="how-it-works">How it works</div>
				<nav class="how-it-works-nav">
					<ul class="how-it-works-ul">
						<li class="how-it-works-li">
							<div class="step">1. Input</div>
							<div class="desc">Find places to discover in Bohol by inputting your travel details</div>
						</li>
						<li class="how-it-works-li">
							<div class="step">2. Choose</div>
							<div class="desc">Choose the places you would like to explore by choosing from the lists</div>
						</li>
						<li class="how-it-works-li">
							<div class="step">3. Customize</div>
							<div class="desc">An itinerary of your stay in Bohol is automatically created which you can edit based on your preference</div>
						</li>
						<li class="how-it-works-li">
							<div class="step">4. Pay</div>
							<div class="desc">Pay fast and secure online or money delivery to finalize itinerary</div>
						</li>
						<li class="how-it-works-li">
							<div class="step">5. Travel</div>
							<div class="desc">Final itinerary is sent and you are now ready to enjoy Bohol</div>
						</li>
					</ul>
				</nav>

			</div>
		</div>
	</div>
	
	<footer id="footer">
		<section class="container">
			<div class="container-inner">
				
				<div class="pad group">

				</div><!--/.pad-->
				
			</div><!--/.container-inner-->
		</section><!--/.container-->
	</footer><!--/#footer-->
	
</div><!-- #wrapper -->

</body>
</html>
