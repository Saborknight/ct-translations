<?php
/**
 * Template Name: Search Page
 *
 * @package WordPress
 * @subpackage CT
 * @since CT 1.0
 */

get_header(); ?>
	
	<div id="wrapper_overflow">
		<div id="wrapper">
			<div class="container wide_paragraph">
				<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php printf( __( 'Otsingutulemused fraasist: %s', 'ct' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'search' ); ?>
				<?php endwhile; ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Tulemusi ei leitud', 'ct' ); ?></h1>
					</header>

					<div class="entry-content">
						<p><?php _e( 'Kahjuks ei leitud teie otsingule vastavaid tulemusi.', 'ct' ); ?></p>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>
			</div>
		</div>
	<div id="wrapper_overflow">

	<div id="content" class="notindex">
		<div class="container">
				<div id="content_btns">
					<ul>
						<li><a href="#"><span class="btn_text">vaata teenuseid</span><div class="content_btn_arrow"></div></a></li>
						<li><a href="#" class="orange"><span class="btn_text">küsi pakkumist</span><div class="content_btn_arrow"></div></a></li>
						<li><a href="#"><span class="btn_text">loe arvamusi</span><div class="content_btn_arrow"></div></a></li>
					</ul>
				</div>
		</div>
	</div>

<?php get_footer(); ?>