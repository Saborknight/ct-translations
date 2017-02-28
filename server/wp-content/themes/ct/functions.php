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
 * Theme setup for all the nice features of WordPress to be enabled!
 *
 * @since 2.0.0
 *
 * @return nothing
 */
function ct_setup() {
	// Make theme available for translation
	load_theme_textdomain('ct');

	// This is for RSS links to be managed by WordPress for posts and such
	add_theme_support('automatic-feed-links');

	// Register menus for editing
	register_nav_menus(array(
		'main' => __('Main Menu', 'ct'),
	));

	// Make default WP markup HTML5!
	add_theme_support('html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	));
}
add_action('after_setup_theme', 'ct_setup');

/**
 * Setup init options into the database if this is the first time the
 * theme has been activated. This is sort of like a quick setup for CT.
 *
 * @since 2.0.0
 *
 * @return nothing
 */
function ct_init() {
	if(!get_option('ct_company_details')) {
		update_option(
			'ct_company_details',
			array(
				'name' => 'Correct Translations',
				'type' => 'Ltd.',
				'email' => 'ct@ct.ee',
				'website' => 'www.ct.ee',
				'copyright_dates' => '2004-' . date('Y'),
				'phone_primary' => array(
					'country_code' => '353',
					'country' => 'Ireland',
					'number' => '86 394 6391'
				),
				'phone_secondary' => array(
					'country_code' => '372',
					'country' => 'Estonia',
					'number' => '5346 4931'
				),
			)
		);
	}
}
add_action('after_switch_theme', 'ct_init');

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

/**
 * Centralised structure of the Call to Actions panel just above the footer.
 * To be called on a page between a `<div class="container"></div>` wrapper.
 *
 * @since 2.0.0
 *
 * @return Structured call to action panel.
 */
function ct_call_to_action_buttons() {
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
add_action('ct_call_to_action_buttons', 'ct_call_to_action_buttons');

/**
 * Generate language switch dropdown
 * If the language is current, take it to the top of the list (and therefore the opening button for the dropdown)
 *
 * @since 2.0.0
 *
 * @return Structured language dropdown.
 */
function ct_language_dropdown_list_dropdown(){
	$languages = icl_get_languages('skip_missing=0');
	if(!empty($languages)){
		foreach($languages as $l){
			$item = sprintf(
				'<li %s><a href="%s"><img class="lang_icon" src="%s" alt="%s flag" />%s%s</a></li>',
				$l['active'] ? 'class="active"' : null,
				$l['url'],
				$l['country_flag_url'],
				$l['translated_name'],
				$l['language_code'],
				$l['active'] ? '<div id="arrow"></div>' : null
			);

			if($l['active'] && isset($language_items)) {
				array_unshift($language_items, $item);
			} else {
				$language_items[] = $item;
			}
		}

		printf('<div id="language"><ul>%s</ul></div>', implode("\n", $language_items));
	}
}
add_action('ct_language_dropdown', 'ct_language_dropdown_list_dropdown');

function ct_enqueue_scripts() {
		wp_enqueue_script('ct_settings_js', get_template_directory_uri() . '/js/ct-settings.js', array('jquery'), '20153');
		wp_enqueue_style('ct_settings_css', get_template_directory_uri() . '/css/ct-settings.css');
}
add_action('admin_enqueue_scripts', 'ct_enqueue_scripts');

include('ct-settings.php');
?>
