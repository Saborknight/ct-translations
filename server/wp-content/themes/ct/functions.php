<?php
/**
 * CT functions and definitions.
 *
 *
 * @package WordPress
 * @subpackage CT
 * @since CT 1.0
 */

function ct_init() {
	update_option(
		'ct_phone_primary',
		array(
			'country_code' => '353',
			'country' => 'Ireland',
			'number' => '86 394 6391'
		)
	);

	update_option(
		'ct_company_details',
		array(
			'name' => 'Correct Translations Ltd.',
		)
	);
}

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

function ct_options_init() {
	// Create Setting
	$settings_group = 'ct_custom_settings';
	$setting_name = 'ct_phone_primary';
	register_setting( $settings_group, $setting_name );

	// Create section of Page
	$settings_section = 'contact_details';
	$page = $settings_group;
	add_settings_section(
		$settings_section,
		__('CT Contact Details', 'ct-settings-page', 'ct'),
		'Some text?',
		$page
	);

	// Add fields to that section
	add_settings_field(
		$section_name,
		__('Primary Phone Number', 'ct-settings-page'),
		'settings_constructor',
		$page,
		$settings_section
	);
}

function ct_options_menu() {
	add_options_page(
		__('CT Custom Settings', 'custom-settings-page', 'ct'),
		__('CT Settings', 'custom-settings-page', 'ct'),
		'manage_options',
		'ct-custom-settings-page',
		'ct_options_page_constructor'
	);
}

function ct_options_page_constructor() {
	if(!current_user_can('manage_options')) {
		wp_die(_x('You do not have sufficient permissions to access this page.', 'status-messages', 'ct'));
	}

	get_template_part('page-templates/settings', 'main');
}

function ct_options_section_contructor() {
	echo '<div>Section</div>';
}

function ct_options_field_constructor() {
	$option = '<p>Yo</p>';
	echo $option;
}
add_action('admin_menu', 'ct_options_menu');
add_action('admin_init', 'ct_options_init');

// function ct_options_page() {
// 	add_options_page(
// 		__('CT Custom Settings', 'custom-settings-page', 'ct'),
// 		__('CT Settings', 'custom-settings-page', 'ct'),
// 		'manage_options',
// 		'ct-custom-settings-page',
// 		'ct_options_page_contructor'
// 	);
// }

// function ct_options_page_init() {
// 	register_setting('ct-contact-details', 'phone-number');
// 	add_settings_section('ct-contact-details', _x('CT Contact Details', 'custom-settings-page', 'ct'), '', 'ct-custom-settings-page');
// 	add_settings_field('ct-contact-details', _x('Primary Phone Number', 'custom-settings-page', 'ct'), '', 'ct-custom-settings-page');
// }

// function ct_options_page_contructor() {
// 	if(!current_user_can('manage_options')) {
// 		wp_die(_x('You do not have sufficient permissions to access this page.', 'status-messages', 'ct'));
// 	}

// 	settings_fields('ct-contact-details');

// 	printf(
// 		'<div class="wrap">
// 			<h1>%s</h1>
// 			<form method="POST" action="options.php">
// 				%s
// 				%s
// 			</form>
// 		</div>',
// 		__('CT Custom Settings', 'custom-settings-page', 'ct'),
// 		do_settings_sections('ct-contact-details'),
// 		submit_button()
// 	);
// }
// add_action('admin_menu', 'ct_options_page');
// add_action('admin_init', 'ct_options_page_init');

// function ct_field_renderer() {
// 	echo '<input type="number" name="ct_phone_primary_number" value="' . get_option('ct_phone_primary', '')['number'] . '">';
// }
?>
