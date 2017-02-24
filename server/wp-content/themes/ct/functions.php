<?php
/**
 * CT functions and definitions.
 *
 *
 * @package WordPress
 * @subpackage CT
 * @since CT 1.0
 */


/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function ct_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'ct' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'ct_wp_title', 10, 2 );

function call_to_action_buttons() {
	printf('
		<div id="content_btns">
			<ul>
				<li>
					<a href="%2$s">
						<span class="btn_text">%1$s</span>
						<div class="content_btn_arrow"></div>
					</a>
				</li>
				<li>
					<a href="%4$s" class="orange">
						<span class="btn_text">%3$s</span>
						<div class="content_btn_arrow"></div>
					</a>
				</li>
				<li>
					<a href="%6$s">
						<span class="btn_text">%5$s</span>
						<div class="content_btn_arrow"></div>
					</a>
				</li>
			</ul>
		</div>',
		_x('view services', 'call-to-actions', 'ct'),
		get_permalink(icl_object_id(9, 'page')),
		_x('request a quote', 'call-to-actions', 'ct'),
		get_permalink(icl_object_id(19, 'page')),
		_x('view feedback', 'call-to-actions', 'ct'),
		get_permalink(icl_object_id(17, 'page'))
	);
}
add_action('call_to_action_buttons', 'call_to_action_buttons');
?>