<h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
<?php the_excerpt(200); ?>
<a href="<?php the_permalink();?>"><?php _e('Read more', 'ct'); ?></a>