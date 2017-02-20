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
				<div id="content_btns">
					<ul>
						<li><a href="<?php echo get_home_url(); ?>/palvelut"><span class="btn_text">katso palvelut</span><div class="content_btn_arrow"></div></a></li>
						<li><a href="<?php echo get_home_url(); ?>/pyyda-hinta-arviao" class="orange"><span class="btn_text">pyydä tarjous</span><div class="content_btn_arrow"></div></a></li>
						<li><a href="<?php echo get_home_url(); ?>/kommentteja"><span class="btn_text">katso palaute</span><div class="content_btn_arrow"></div></a></li>
					</ul>
				</div>
		</div>
	</div>

<?php get_footer(); ?>