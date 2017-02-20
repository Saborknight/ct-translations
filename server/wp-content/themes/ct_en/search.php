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
					<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'ct' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'search' ); ?>
				<?php endwhile; ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'No results found', 'ct' ); ?></h1>
					</header>

					<div class="entry-content">
						<p><?php _e( 'Unfortunately your search has not returned any results.', 'ct' ); ?></p>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>
			</div>
		</div>
	</div>
	
	<div id="content" class="notindex">
		<div class="container">
				<div id="content_btns">
					<ul>
						<li><a href="#"><span class="btn_text">see services</span><div class="content_btn_arrow"></div></a></li>
						<li><a href="#" class="orange"><span class="btn_text">get an offer</span><div class="content_btn_arrow"></div></a></li>
						<li><a href="#"><span class="btn_text">see comments</span><div class="content_btn_arrow"></div></a></li>
					</ul>
				</div>
		</div>
	</div>
		
<?php get_footer(); ?>