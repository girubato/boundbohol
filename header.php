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

<body onload="load_attractions();">
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
	
	<div class="container">
		<div class="container-inner">			
			<div class="main">
				<div class="main-inner group">