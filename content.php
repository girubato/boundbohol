<?php 

/**
 * content.php
 * This file should be created in the root of your theme directory
 */
if ( have_posts() ) :             
   while ( have_posts() ) : the_post(); 
   ?>
      <article>
         <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail(array(200, 200)); ?>
         <?php endif; ?>
         <h4><?php the_title(); ?></h4>
         <?php the_content(); ?>
         <?php more_info_modal(get_the_ID(), get_the_title()); ?>
      </article>

   <?php 
   endwhile; 

else :
   echo '<p>Sorry, no results found.</p>';
endif; 
wp_reset_query();

?>
