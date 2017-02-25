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
						Correct Translations Ltd.
						<span class="bottom_text">
							Telefon (+372) 5346 4931 (Eesti)<br/>
							(+353) 86 394 6391 (Iirimaa)<br/>
							E-post: <a id="mail" href="mailto:ct@ct.ee">ct@ct.ee</a><br/>
							www.ct.ee
						</span>
					</div>
				</div>
				<div id="copyright" class="bottom_text"><?php printf( _x('copyright &copy; correct translations oü %s', 'copyright-statement', 'ct'), '2004-' . date('Y')); ?></div>
				<div id="bottom_button"></div>
			</div>
		</div>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri(); ?>/js/vendor/jquery-1.9.1.min.js"><\/script>')</script>
        <script src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>

    </body>
</html>
<?php wp_footer(); ?>