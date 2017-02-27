<?php
/**
 * Template Name: Contact
 *
 * @package WordPress
 * @subpackage CT
 * @since 2.0.0
 * @author Saborknight
 */
get_header(); ?>

	<div id="content">
		<?php
			printf(
				'<h1>%11$s</h1>
				<p>
					%1$s: <a href="tel:+%2$s%3$s">(+%2$s) %3$s</a> (%4$s)<br />
					<a href="tel:+%5$s%6$s">(+%5$s) %6$s</a> (%7$s)<br />
					%8$s: <a href="mailto:%9$s">%9$s</a><br />
					<a href="http://%10$s">%10$s</a>
				</p>',
				/*1*/_x('Telephone', 'contact-information', 'ct'),
				/*2*/$phone_primary['country_code'],
				/*3*/$phone_primary['number'],
				/*4*/$phone_primary['country'],
				/*5*/$phone_secondary['country_code'],
				/*6*/$phone_secondary['number'],
				/*7*/$phone_secondary['country'],
				/*8*/_x('E-mail', 'contact-information', 'ct'),
				/*9*/$company['email'],
				/*10*/$company['website'],
				/*11*/$company['name'] . $company['type']
			);
		?>
		<div class="container">
			<span id="title">&nbsp;</span>
			<?php do_action('ct_call_to_action_buttons'); ?>
		</div>
	</div>

<?php get_footer(); ?>