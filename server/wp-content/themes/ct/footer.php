<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage CT
 * @since CT 1.0
 */
$directory = get_template_directory() . '/img/clients/';
$clients = glob($directory . "*.{jpg,png,gif}", GLOB_BRACE);
if($clients) {
	$filecount = 0;
	foreach($clients as $logo) {
		++$filecount;
		$client_items[] = sprintf('<li class="clients%d"></li>', $filecount);
	}

	$wrapper_width = $filecount * 200;
}
?>
	<div id="clients">
		
		<div class="clients_line"></div>
		<span id="clients_header"><?php _e('clients', 'ct'); ?></span>
		<div class="clients_line"></div>
		<div id="clients_area">
			<div class="clients_btn left"></div>
			<div id="clients_scrollable">
					<ul style="width: <?php echo $wrapper_width; ?>px">
						<?php echo implode("\n", $client_items); ?>
					</ul>
				</div>
			<div class="clients_btn right"></div>
		</div>
	</div>

		<div id="bottom">
			<div class="container">
				<div id="table">
					<div id="bottom_left">
						<?php
							/* translators: Title for the footer section displaying the contact information */
							_e('Contact', 'ct');
						?>
					</div>
							
					<div id="bottom_center">	
						<div id="round_logo"></div>
						<div id="logo_shadow"></div>
					</div>

					<div id="bottom_right">
							<?php
								// Load up the details
								$company = get_option('ct_company_details');
								$phone_primary = $company['phone_primary'];
								$phone_secondary = $company['phone_secondary'];

								printf('<h5 class="bottom_header">%s %s</h5>', $company['name'], $company['type']);
							?>
						<p class="bottom_text">
							<?php
								printf(
									'%1$s: <a href="tel:+%2$s%3$s">(+%2$s) %3$s</a> (%4$s)<br />
									<a href="tel:+%5$s%6$s">(+%5$s) %6$s</a> (%7$s)<br />
									%8$s: <a href="mailto:%9$s">%9$s</a><br />
									<a href="http://%10$s">%10$s</a>',
									/*1*/_x('Telephone', 'contact-information', 'ct'),
									/*2*/$phone_primary['country_code'],
									/*3*/$phone_primary['number'],
									/*4*/$phone_primary['country'],
									/*5*/$phone_secondary['country_code'],
									/*6*/$phone_secondary['number'],
									/*7*/$phone_secondary['country'],
									/*8*/_x('E-mail', 'contact-information', 'ct'),
									/*9*/$company['email'],
									/*10*/$company['website']
								);
							?>
						</p>
					</div>
				</div>
				<div id="copyright" class="bottom_text"><?php printf( _x('copyright &copy; %s %s %s', 'copyright-statement', 'ct'), $company['name'], $company['type'], $company['copyright_dates']); ?></div>
				<div id="bottom_button"></div>
			</div>
		</div>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>

		<?php wp_footer(); ?>
    </body>
</html>