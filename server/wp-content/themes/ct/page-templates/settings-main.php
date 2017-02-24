<div class="wrap">
	<h1><?php _ex('CT Custom Settings', 'custom-settings-page', 'ct'); ?></h1>
	<form method="POST" action="options.php">
		<?php
			do_settings_sections('ct-contact-details');
			submit_button();
		?>
	</form>
</div>