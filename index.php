<?php
    if (!is_user_logged_in()) {
        echo "<div style='height:100%;'><div style='position:relative;top:40%'><center><img src='".get_template_directory_uri()."/img/coming_soon.png' /></center></div></div>";
        exit;
    }
?>
<?php get_header(); ?>

    <section class="content">
		<div class="content-search-box-div">
			<div id="attractions-search-box-div">
				<?php
					$search = new WP_Advanced_Search('attractions-search-form-search-box');
					$search->the_form();
				?>
			</div>
			<div id="accommodations-search-box-div" class="display-none">
				<?php
					$search = new WP_Advanced_Search('accommodations-search-form-search-box');
					$search->the_form();
				?>
			</div>
			<div id="restaurants-search-box-div" class="display-none">
				<?php
					$search = new WP_Advanced_Search('restaurants-search-form-search-box');
					$search->the_form();
				?>
			</div>
			<div id="transportations-search-box-div" class="display-none">
				<?php
					$search = new WP_Advanced_Search('transportations-search-form-search-box');
					$search->the_form();
				?>
			</div>
		</div>
		
        <div id="wpas-results" class="group pad"></div>

    </section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
