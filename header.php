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
<div class="container-fluid">
	<div class="row content">
		<div id="header" class="col-sm-12">
			<img src='<?php echo get_template_directory_uri(); ?>/img/bbohol-logo.png' />
		</div>
	</div>
	<div class="row content">
		