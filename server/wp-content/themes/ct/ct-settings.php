<?php
/**
 * Here are the declarations and functions entrusted with building the settings page
 *
 * @package WordPress
 * @subpackage CT
 * @since 2.0.0
 */
 
/**
 * Register CT Custom Settings page to edit the Company Profile
 *
 * @since 2.0.0
 */
function ct_options_menu() {
	add_options_page(
		_x('CT Custom Settings', 'ct-settings', 'ct'), // Page title
		_x('CT Settings', 'ct-settings', 'ct'), // Menu title
		'manage_options', // Capability
		'ct_settings_page',
		'ct_page_constructor'
	);
}

function ct_options_init() {
	// Declare general variables
	$setting_page = 'ct_settings_page';
	$setting_group = 'ct_company_profile';

	$section_company = 'ct_company_section';

	$option_company = array(
		'id' => 'ct_company_details',
		'name' => 'ct_company_name',
		'type' => 'ct_company_type',
		'email' => 'ct_company_email',
		'website' => 'ct_company_website',
		'copyright_dates' => 'ct_company_copy',
		'phone_primary' => array(
			'country_code' => 'ct_company_phone_primary_country_code',
			'country' => 'ct_company_phone_primary_country',
			'number' => 'ct_company_phone_primary_number'
		),
		'phone_secondary' => array(
			'country_code' => 'ct_company_phone_secondary_country_code',
			'country' => 'ct_company_phone_secondary_country',
			'number' => 'ct_company_phone_secondary_number'
		),
	);

	/**
	 * Register Company Details settings and sections
	 */
	// Fetch existing options
	$option_values = get_option($option_company['id']);

	$default_values = array(
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
	);

	$data = shortcode_atts($default_values, $option_values);

	// Register Settings for ct_company_details
	register_setting(
		$setting_group,
		$option_company['id'],
		'ct_data_validator'
	);

	// Create Section
	add_settings_section(
		$section_company,
		_x('Company Details', 'ct-settings', 'ct'),
		'ct_company_section_contructor',
		$setting_page
	);

	// Create Fields
	add_settings_field(
		$option_company['name'],
		_x('Name', 'ct-settings', 'ct'),
		'ct_company_field_constructor_1',
		$setting_page,
		$section_company,
		array(
			'label_for' => 'company_name',
			'name' => 'name',
			'type' => 'text',
			'class' => '',
			'value' => esc_attr($data['name']),
			'option_name' => $option_company['id'],
		)
	);
	add_settings_field(
		$option_company['type'],
		_x('Type', 'ct-settings', 'ct'),
		'ct_company_field_constructor_2',
		$setting_page,
		$section_company,
		array(
			'label_for' => 'company_type',
			'name' => 'type',
			'type' => 'text',
			'class' => '',
			'value' => esc_attr($data['type']),
			'option_name' => $option_company['id'],
		)
	);
	add_settings_field(
		$option_company['email'],
		_x('E-mail', 'ct-settings', 'ct'),
		'ct_company_field_constructor_3',
		$setting_page,
		$section_company,
		array(
			'label_for' => 'company_email',
			'name' => 'email',
			'type' => 'text',
			'class' => '',
			'value' => esc_attr($data['email']),
			'option_name' => $option_company['id'],
		)
	);
	add_settings_field(
		$option_company['website'],
		_x('Website', 'ct-settings', 'ct'),
		'ct_company_field_constructor_4',
		$setting_page,
		$section_company,
		array(
			'label_for' => 'company_website',
			'name' => 'website',
			'type' => 'text',
			'class' => '',
			'value' => esc_attr($data['website']),
			'option_name' => $option_company['id'],
		)
	);
	add_settings_field(
		$option_company['copyright_dates'],
		_x('Copyright Dates', 'ct-settings', 'ct'),
		'ct_company_field_constructor_5',
		$setting_page,
		$section_company,
		array(
			'label_for' => 'company_copyright_dates',
			'name' => 'copyright_dates',
			'type' => 'text',
			'class' => '',
			'value' => esc_attr($data['copyright_dates']),
			'option_name' => $option_company['id'],
		)
	);
	add_settings_field(
		$option_company['phone_primary']['country_code'],
		_x('Primary Phone Number', 'ct-settings', 'ct'),
		'ct_company_field_constructor_6',
		$setting_page,
		$section_company,
		array(
			'label_for' => 'company_phone_primary_country_code',
			'name' => 'country_code',
			'type' => 'text',
			'class' => 'company_country_code',
			'value' => esc_attr($data['phone_primary']['country_code']),
			'option_name' => $option_company['id'] . '[phone_primary]',
		)
	);
	add_settings_field(
		$option_company['phone_primary']['number'],
		null,
		'ct_company_field_constructor_7',
		$setting_page,
		$section_company,
		array(
			'label_for' => 'company_phone_primary_number',
			'name' => 'number',
			'type' => 'text',
			'class' => 'company_number',
			'value' => esc_attr($data['phone_primary']['number']),
			'option_name' => $option_company['id'] . '[phone_primary]',
		)
	);
	add_settings_field(
		$option_company['phone_primary']['country'],
		_x('Primary Phone Country', 'ct-settings', 'ct'),
		'ct_company_field_constructor_8',
		$setting_page,
		$section_company,
		array(
			'label_for' => 'company_phone_primary_country',
			'name' => 'country',
			'type' => 'text',
			'class' => '',
			'value' => esc_attr($data['phone_primary']['country']),
			'option_name' => $option_company['id'] . '[phone_primary]',
		)
	);
	add_settings_field(
		$option_company['phone_secondary']['country_code'],
		_x('Secondary Phone Number', 'ct-settings', 'ct'),
		'ct_company_field_constructor_9',
		$setting_page,
		$section_company,
		array(
			'label_for' => 'company_phone_secondary_country_code',
			'name' => 'country_code',
			'type' => 'text',
			'class' => 'company_country_code',
			'value' => esc_attr($data['phone_secondary']['country_code']),
			'option_name' => $option_company['id'] . '[phone_secondary]',
		)
	);
	add_settings_field(
		$option_company['phone_secondary']['number'],
		null,
		'ct_company_field_constructor_10',
		$setting_page,
		$section_company,
		array(
			'label_for' => 'company_phone_secondary_number',
			'name' => 'number',
			'type' => 'text',
			'class' => 'company_number',
			'value' => esc_attr($data['phone_secondary']['number']),
			'option_name' => $option_company['id'] . '[phone_secondary]',
		)
	);
	add_settings_field(
		$option_company['phone_secondary']['country'],
		_x('Secondary Phone Country', 'ct-settings', 'ct'),
		'ct_company_field_constructor_11',
		$setting_page,
		$section_company,
		array(
			'label_for' => 'company_phone_secondary_country',
			'name' => 'country',
			'type' => 'text',
			'class' => '',
			'value' => esc_attr($data['phone_secondary']['country']),
			'option_name' => $option_company['id'] . '[phone_secondary]',
		)
	);
}

function ct_page_constructor() {
	if(!current_user_can('manage_options')) {
		wp_die(_x('You do not have sufficient permissions to access this page.', 'status-messages', 'ct'));
	}

	get_template_part('page-templates/settings', 'main');
}

function ct_company_section_contructor() {
	printf(
		'<p><strong>%s</p></strong>', 
		_x('Enter here the Company details to show on the footer, header and on the contacts page of the site.', 'ct-settings', 'ct')
	);
}

function ct_company_field_constructor_1( $args ) { // Name
	printf(
		'<input class="%s" type="%s" name="%s[%s]" id="%s" value="%s">',
		$args['class'],
		$args['type'],
		$args['option_name'],
		$args['name'],
		$args['label_for'],
		$args['value']
	);
}

function ct_company_field_constructor_2( $args ) { // Type
	printf(
		'<input class="%s" type="%s" name="%s[%s]" id="%s" value="%s">',
		$args['class'],
		$args['type'],
		$args['option_name'],
		$args['name'],
		$args['label_for'],
		$args['value']
	);
}

function ct_company_field_constructor_3( $args ) { // E-mail
	printf(
		'<input class="%s" type="%s" name="%s[%s]" id="%s" value="%s">',
		$args['class'],
		$args['type'],
		$args['option_name'],
		$args['name'],
		$args['label_for'],
		$args['value']
	);
}

function ct_company_field_constructor_4( $args ) { // Website
	printf(
		'<input class="%s" type="%s" name="%s[%s]" id="%s" value="%s">',
		$args['class'],
		$args['type'],
		$args['option_name'],
		$args['name'],
		$args['label_for'],
		$args['value']
	);
}

function ct_company_field_constructor_5( $args ) { // Copyright Dates
	printf(
		'<input class="%s" type="%s" name="%s[%s]" id="%s" value="%s">',
		$args['class'],
		$args['type'],
		$args['option_name'],
		$args['name'],
		$args['label_for'],
		$args['value']
	);
}

function ct_company_field_constructor_6( $args ) { // Phone Primary Country Code
	printf(
		'<span class="inline-group-label">+</span><input class="%s" type="%s" name="%s[%s]" id="%s" value="%s">',
		$args['class'],
		$args['type'],
		$args['option_name'],
		$args['name'],
		$args['label_for'],
		$args['value']
	);
}

function ct_company_field_constructor_7( $args ) { // Phone Primary Number
	printf(
		'<input class="%s" type="%s" name="%s[%s]" id="%s" value="%s">',
		$args['class'],
		$args['type'],
		$args['option_name'],
		$args['name'],
		$args['label_for'],
		$args['value']
	);
}

function ct_company_field_constructor_8( $args ) { // Phone Primary Country
	printf(
		'<input class="%s" type="%s" name="%s[%s]" id="%s" value="%s">',
		$args['class'],
		$args['type'],
		$args['option_name'],
		$args['name'],
		$args['label_for'],
		$args['value']
	);
}

function ct_company_field_constructor_9( $args ) { // Phone Secondary Country Code
	printf(
		'<span class="inline-group-label">+</span><input class="%s" type="%s" name="%s[%s]" id="%s" value="%s">',
		$args['class'],
		$args['type'],
		$args['option_name'],
		$args['name'],
		$args['label_for'],
		$args['value']
	);
}

function ct_company_field_constructor_10( $args ) { // Phone Secondary Number
	printf(
		'<input class="%s" type="%s" name="%s[%s]" id="%s" value="%s">',
		$args['class'],
		$args['type'],
		$args['option_name'],
		$args['name'],
		$args['label_for'],
		$args['value']
	);
}

function ct_company_field_constructor_11( $args ) { // Phone Secondary Country
	printf(
		'<input class="%s" type="%s" name="%s[%s]" id="%s" value="%s">',
		$args['class'],
		$args['type'],
		$args['option_name'],
		$args['name'],
		$args['label_for'],
		$args['value']
	);
}

function ct_data_validator( $values ) {
	// Set defaults
	$default_values = array(
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
	);

	if(!is_array($values)) {
		return $default_values;
	}

	$result = array();

	foreach($default_values as $key => $value) {
		if(empty($values[$key])) {
			$result[$key] = $value;
		} else {
			// If there actually has been something added...
			// Validation checks should go here!

			// ...then add that to the result...
			$result[$key] = $values[$key];
		}
	}

	// ...to be stored in the dabase
	return $result;
}
add_action('admin_menu', 'ct_options_menu');
add_action('admin_init', 'ct_options_init');