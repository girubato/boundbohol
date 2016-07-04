<?php 

/**
 * content.php
 * This file should be created in the root of your theme directory
 */
if (have_posts()) :             
    while ( have_posts() ) : the_post(); 
    ?>
    <article class="content-pad">
      <?php

        $cat = get_the_category();
        if (!empty($cat)) {
            get_template_part('parts/'.$cat[0]->category_nicename);
        }

    ?>
    </article>
    <?php 
    endwhile; 
else :
   echo '<p>Sorry, no results found.</p>';
endif; 
wp_reset_query();

?>
