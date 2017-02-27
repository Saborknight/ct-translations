<?php
/**
 * This page will be acting as the homepage for each language
 *
 * @package WordPress
 * @subpackage CT
 * @since 2.0.0
 * @author Saborknight
 */
get_header(); ?>

	<div id="content">
		<div id="backgrounds">
			<div id="background-1" class="bg animated active" style="background: url(<?php echo get_template_directory_uri(); ?>/img/content_bgs/1.jpg) no-repeat center center;"></div>
			<div id="background-2" class="bg animated" style="background: url(<?php echo get_template_directory_uri(); ?>/img/content_bgs/2.jpg) no-repeat center center;"></div>
			<div id="background-3" class="bg animated" style="background: url(<?php echo get_template_directory_uri(); ?>/img/content_bgs/3.jpg) no-repeat center center;"></div>
		</div>
		<div class="container">
			<span id="title">&nbsp;</span>
			<?php do_action('ct_call_to_action_buttons'); ?>
		</div>
	</div>

<?php get_footer(); ?>