<?php
    if (!is_user_logged_in()) {
        echo "<div style='height:100%;'><div style='position:relative;top:40%'><center><img src='".get_template_directory_uri()."/img/coming_soon.png' /></center></div></div>";
        exit;
    }
?>
<?php get_header(); ?>
<?php get_sidebar('left'); ?>
<div class="col-sm-6 nopadding">
<!--    <section class="content">
		<div class="content-search-box-div"> -->
		<div class="row">
		<div class="col-sm-12">
			<div class="container-fluid">
			<!-- <div id="attractions-search-box-div"> -->
				<?php
					$search = new WP_Advanced_Search('attractions-search-form-search-box');
					$search->the_form();
				?>
			</div>
			<div class="container-fluid hide">
				<?php
					$search = new WP_Advanced_Search('accommodations-search-form-search-box');
					$search->the_form();
				?>
			</div>
			<div class="container-fluid hide">
				<?php
					$search = new WP_Advanced_Search('restaurants-search-form-search-box');
					$search->the_form();
				?>
			</div>
			<div class="container-fluid hide">
				<?php
					$search = new WP_Advanced_Search('transportations-search-form-search-box');
					$search->the_form();
				?>
			</div>
		</div>
		</div>
        <div id="wpas-results"></div>
 <!--   </section><!--/.content-->
</div>
<?php get_sidebar('right'); ?>
<?php get_footer(); ?>
