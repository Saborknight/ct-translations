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
?>
	<div id="clients">
		
		<div class="clients_line"></div>
		<span id="clients_header"><?php _e('clients', 'ct'); ?></span>
		<div class="clients_line"></div>
		<div id="clients_area">
			<div class="clients_btn left"></div>
			<div id="clients_scrollable">
					<ul>
						<li class="clients1"><a href="#"></a></li>
						<li class="clients2"><a href="#"></a></li>
						<li class="clients3"><a href="#"></a></li>
						<li class="clients4"><a href="#"></a></li>
						<li class="clients5"><a href="#"></a></li>
						<li class="clients6"><a href="#"></a></li>
						<li class="clients7"><a href="#"></a></li>
						<li class="clients8"><a href="#"></a></li>
						<li class="clients9"><a href="#"></a></li>
						<li class="clients10"><a href="#"></a></li>
						<li class="clients11"><a href="#"></a></li>
						<li class="clients12"><a href="#"></a></li>
						<li class="clients13"><a href="#"></a></li>
						<li class="clients14"><a href="#"></a></li>
						<li class="clients15"><a href="#"></a></li>
						<li class="clients16"><a href="#"></a></li>
						<li class="clients17"><a href="#"></a></li>
						<li class="clients18"><a href="#"></a></li>
						<li class="clients19"><a href="#"></a></li>
						<li class="clients20"><a href="#"></a></li>
						<li class="clients21"><a href="#"></a></li>
						<li class="clients22"><a href="#"></a></li>
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
								$phone_primary = get_option('ct_phone_primary');
								$phone_secondary = get_option('ct_phone_secondary');
								$company = get_option('ct_company_details');

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

    </body>
</html>
<?php wp_footer(); ?>