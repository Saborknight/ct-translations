<?php
/**
 * Template Name: Avaleht
 *
 * @package WordPress
 * @subpackage CT
 * @since CT 1.0
 */

get_header(); ?>

	<div id="content">
		<div id="backgrounds">
			<div id="background-1" class="bg animated active" style="background: url(http://www.ct.ee/wp-content/themes/ct_fi/img/content_bgs/1.jpg) no-repeat center center;"></div>
			<div id="background-2" class="bg animated" style="background: url(http://www.ct.ee/wp-content/themes/ct_fi/img/content_bgs/2.jpg) no-repeat center center;"></div>
			<div id="background-3" class="bg animated" style="background: url(http://www.ct.ee/wp-content/themes/ct_fi/img/content_bgs/3.jpg) no-repeat center center;"></div>
		</div>
		<div class="container">
			<span id="title"><span id="title_640"></span></span>
				<div id="content_btns">
					<ul>
						<li><a href="<?php echo get_home_url(); ?>/services"><span class="btn_text">view services</span><div class="content_btn_arrow"></div></a></li>
						<li><a href="<?php echo get_home_url(); ?>/price-quotation" class="orange"><span class="btn_text">request a quote</span><div class="content_btn_arrow"></div></a></li>
						<li><a href="<?php echo get_home_url(); ?>/clients-comments"><span class="btn_text">view feedback</span><div class="content_btn_arrow"></div></a></li>
					</ul>
				</div>
		</div>
	</div>

<?php get_footer(); ?>