<?php
/**
 * 
 * @package WordPress
 * @subpackage CT
 * @since CT 1.0
 */

get_header(); ?>
	<div id="wrapper_overflow">
		<div id="wrapper">
			<div class="container">
				<?php while ( have_posts() ) : the_post(); ?> 
					<?php get_template_part( 'content', 'page' ); ?>
				<?php endwhile; // end of the loop. ?>
			</div>
		</div>
	</div>

	<div id="content" class="notindex">
		<div class="container">
			<?php do_action('ct_call_to_action_buttons'); ?>
		</div>
	</div>

<?php get_footer(); ?>