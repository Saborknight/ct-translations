<div class="wrap">
	<h1><?php _ex('CT Custom Settings', 'ct-settings', 'ct'); ?></h1>
	<form method="POST" action="options.php">
		<?php
			// Output the settings sections (using page slug)
			do_settings_sections('ct_settings_page');

			// Output the fields (using settings group)
			settings_fields('ct_company_profile');
			submit_button();
		?>
	</form>
</div>