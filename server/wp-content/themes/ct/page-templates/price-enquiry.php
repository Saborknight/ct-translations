<?php
/**
 * Template Name: Price Enquiry
 *
 * @package WordPress
 * @subpackage CT
 * @since CT 1.0
 */

get_header(); ?>
	<div id="wrapper_overflow">
	<div id="wrapper">
		<div class="container">
			<div id="wrapper_header">
				<h1><?php echo __('We offer special discount rates to both first-time and regular clients. Complete the details below for a free, no obligation, price quotation.', 'ct'); ?></h1>
			</div>
			<div id="wrapper_content">
				<?php
if(isset($_POST['submit'])) {
	
	$email_to = get_option('ct_company_details')['email'];
	$email_subject = _x('Request for a quote ', 'form-sent-message', 'ct') . $_POST['client_name'];

	function died($error) {
		// your error code can go here
		printf(
			'<h2>%s</h2>
			<br /><br />
			%s
			<br /><br />
			<h2>%s</h2>',
			_x('The form below contains errors:', 'form-notice-messages', 'ct'),
			$error,
			_x('To send the price enquiry, please correct these mistakes.', 'form-error-messages', 'ct')
		);
	}

	$name = $_POST['client_name']; // required
	$email_from = $_POST['client_email']; // required
	$telephone = $_POST['client_phone']; // not required
	$contact_person = $_POST['contact_person']; // not required
	$country = $_POST['country']; // not required
	$language_from = $_POST['language_from']; // required
	$language_to = $_POST['language_to']; // required
	$deadline = $_POST['deadline']; // not required
	$description = $_POST['description']; // not required

	$upload_dir = wp_upload_dir();  // look for this function in wordpress documentation at codex 
	$upload_dir = $upload_dir['path'];
	$attachments = array();
	$count = 0;

	foreach($_FILES['files']['name'] as $filename){
		move_uploaded_file($_FILES["files"]["tmp_name"][$count],WP_CONTENT_DIR .'/uploads/'.basename($filename));
		array_push($attachments, WP_CONTENT_DIR . "/uploads/" . $filename);
		
		
		$count++;
	}

	$error_message = "";
	$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
	if(!preg_match($email_exp,$email_from)) {
		$error_message .= sprintf('<p class="error-message">%s</p><br />', _x('The given email address is invalid.', 'form-error-messages', 'ct'));
	}
	if(strlen($name) < 2) {
		$error_message .= sprintf('<p class="error-message">%s</p><br />', _x('The name you gave is incorrect.', 'form-error-messages', 'ct'));
	}
	if($telephone !== '') {
		if(is_numeric($telephone)) {
			if(
				strlen(str_replace(['-', '+', ' ', '(', ')'], ['', '00', '', '', ''], $telephone)) <= 9
				|| strlen(str_replace(['-', '+', ' ', '(', ')'], ['', '00', '', '', ''], $telephone)) >= 15
			) {
				$error_message .= sprintf(
					'<p class="error-message">%s</p><br />',
					_x('The given phone number has an incorrect length', 'form-error-messages', 'ct')
				);
			}
		} else {
			$error_message .= sprintf('<p class="error_message">%s</p><br />', _x('The given phone number is invalid.', 'form-error-messages', 'ct'));
		}
	}
	if(strlen($contact_person) < 2 && $contact_person !== ''){
		$error_message .= sprintf('<p class="error-message">%s</p><br />', _x('The given contact name is incorrect.', 'form-error-messages', 'ct'));
	}
	if(strlen($language_from) < 2){
		$error_message .= sprintf('<p class="error-message">%s</p><br />', _x('The inserted source language is invalid.', 'form-error-messages', 'ct'));
	}
	if(strlen($language_to) < 2){
		$error_message .= sprintf('<p class="error-message">%s</p><br />', _x('The inserted target language is invalid.', 'form-error-messages', 'ct'));
	}
	if(strlen($country) < 2 && $country !== ''){
		$error_message .= sprintf('<p class="error-message">%s</p><br />', _x('The given country is invalid.', 'form-error-messages', 'ct'));
	}
	if(strlen($deadline) < 4 && $deadline !== '') {
		$error_message .= sprintf('<p class="error-message">%s</p><br />', _x('The given date is invalid.', 'form-error-messages', 'ct'));
	}
	if(strlen($description) < 4 && $description !== '') {
		$error_message .= sprintf('<p class="error-message">%s</p><br />', _x('The description is too short.', 'form-error-messages', 'ct'));
	}

	/* translators: %s is the website which the price enquiry comes from */
	$email_message = sprintf( _x("Price enquiry from: %s\n\n", 'form-message-details', 'ct'), get_site_url());
	
	function clean_string($string) {
		$bad = array("content-type","bcc:","to:","cc:","href");
		return str_replace($bad,"",$string);
	}

	$email_message .= _x('Name: ', 'form-message-details', 'ct') . clean_string($name) . "\n";
	$email_message .= _x('Email: ', 'form-message-details', 'ct') . clean_string($email_from) . "\n";
	$email_message .= _x('Phone number: ', 'form-message-details', 'ct') . clean_string($telephone) . "\n";
	$email_message .= _x('Country: ', 'form-message-details', 'ct') . clean_string($country) . "\n";
	$email_message .= _x('Source language: ', 'form-message-details', 'ct') . clean_string($language_from) . "\n";
	$email_message .= _x('Target language: ', 'form-message-details', 'ct') . clean_string($language_to) . "\n";
	$email_message .= _x('Deadline: ', 'form-message-details', 'ct') . clean_string($deadline) . "\n";
	$email_message .= _x('Description: ', 'form-message-details', 'ct') . clean_string($description) . "\n";

	$header = sprintf('From: %s %s <ct@ct.ee>', _x('Price enquiry page', 'form-message-details', 'ct'), get_site_url());

	if(strlen($error_message) > 0){
		died($error_message);
	} else {
		$sendmail = wp_mail($email_to, $email_subject, $email_message, $header, $attachments);

		if($sendmail) {
			printf('<h2 class="success-message">%s</h2>', _x('Message sent!', 'form-notice-messages', 'ct'));
		} else {
			printf('<h2 class="error-message">%s</h2>', _x('Message failed to send, please try again!', 'form-notice-messages', 'ct'));
		}
	}
}
?>
				<form id="price_check" method="post" action="" enctype="multipart/form-data">
					<input type="text" class="price_request" name="client_name" placeholder="<?php _ex('Company or person (name)', 'form-fields', 'ct'); ?>">
					<input type="email" class="price_request" name="client_email" placeholder="<?php _ex('E-mail', 'form-fields', 'ct'); ?>">
					<input type="tel" class="price_request" name="client_phone" placeholder="<?php _ex('Phone number', 'form-fields', 'ct'); ?>">
					<input type="text" class="price_request" name="contact_person" placeholder="<?php _ex('Contact person', 'form-fields', 'ct'); ?>">
					<input type="text" class="price_request" name="country" placeholder="<?php _ex('Country', 'form-fields', 'ct'); ?>">
					<input type="text" class="price_request" name="language_from" placeholder="<?php _ex('Source language', 'form-fields', 'ct'); ?>">
					<input type="text" class="price_request" name="language_to" placeholder="<?php _ex('Target language', 'form-fields', 'ct'); ?>">
					<input type="text" class="price_request" name="deadline" placeholder="<?php _ex('Deadline', 'form-fields', 'ct'); ?>">
					<textarea class="price_request description" name="description" placeholder="<?php _ex('Translated abstract of the work (including volume of work)', 'form-fields', 'ct'); ?>" style="resize: none;"></textarea>
					<h2><?php _ex('Add file(id):', 'form-fields', 'ct'); ?></h2>
					<input type="file" class="price_request files" name="files[]" multiple>
					<div id="submit_area">
						<div id="submit_btn">
							<input name="submit" type="submit" value="<?php _ex('SEND', 'form-submit', 'ct'); ?>" class="submit">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

	<div id="content" class="notindex">
		<div class="container">
			<?php do_action('ct_call_to_action_buttons'); ?>
		</div>
	</div>

<?php get_footer(); ?>