<?php
/**
 * Template Name: Hinnapäring
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
				<h1>We offer special discount rates to both first-time and regular clients. Complete the details below for a free, no obligation, price quotation.</h1>
			</div>
			<div id="wrapper_content">
				<?php
if(isset($_POST['submit'])) {
     
    $email_to = "ct@ct.ee";
    $email_subject = "Hinnapäring ".$_POST['name'];
     
     
    function died($error) {
        // your error code can go here
        echo "<h2>Teie poolt saadetavas hinnapäringus ilmnesid vead:</h2>";
        echo "<br /><br />";
        echo $error."<br /><br />";
        echo "<h2>Päringu saatmiseks palun parandada vead.</h2><br /><br />";
    }
     
    
     
    $name = $_POST['client_name']; // required
    $email_from = $_POST['client_email']; // required
    $telephone = $_POST['client_phone']; // not required
    $contact_person = $_POST['contact_person']; // required
    $country = $_POST['country']; // required
    $language_from = $_POST['language_from']; // required
    $language_to = $_POST['language_to']; // required
    $deadline = $_POST['deadline']; // required
    $description = $_POST['description']; // required

    $upload_dir = wp_upload_dir();  // look for this function in wordpress documentation at codex 
    $upload_dir = $upload_dir['path'];
    $attachments = array();
    $count = 0;

    foreach($_FILES['files']['name'] as $filename){
      move_uploaded_file($_FILES["files"]["tmp_name"][$count],WP_CONTENT_DIR .'/uploads/'.basename($filename));
      array_push($attachments, WP_CONTENT_DIR ."/uploads/".$filename);
      
      
      $count++;
    }
    


    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= '<p>Entered e-mail address is not valid.</p><br />';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$name)) {
    $error_message .= '<p>Entered individual or company name is not valid.</p><br />';
  }
  if(!preg_match($string_exp,$contact_person)){
    $error_message .= '<p>Entered contact person is not valid.</p><br />';
  }
  if(!preg_match($string_exp,$language_from)){
    $error_message .= '<p>Entered source language is not valid.</p><br />';
  }
  if(!preg_match($string_exp,$language_to)){
    $error_message .= '<p>Entered target language is not valid.</p><br />';
  }
  if(!preg_match($string_exp,$country)){
    $error_message .= '<p>Entered target language is not valid.</p><br />';
  }
  if(strlen($deadline) < 4) {
    $error_message .= '<p>Entered due date is not valid.</p><br />';
  }
   if(strlen($description) < 4) {
    $error_message .= '<p>Description is too short.</p><br />';
  }
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
     
    $email_message .= "Nimi: ".clean_string($name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telefon: ".clean_string($telephone)."\n";
    $email_message .= "Riik: ".clean_string($country)."\n";
    $email_message .= "Lähtekeel: ".clean_string($language_from)."\n";
    $email_message .= "Sihtkeel: ".clean_string($language_to)."\n";
    $email_message .= "Tähtaeg: ".clean_string($deadline)."\n";
    $email_message .= "Kirjeldus: ".clean_string($description)."\n";

    $header = 'From: Hinnapäring lehelt www.ct.ee(inglise keeles) <ct@ct.ee>';
     
    $sendmail = wp_mail($email_to, $email_subject, $email_message, $header, $attachments);
  if(strlen($error_message) > 0){
    died($error_message); 
  }
	else if($sendmail) {
    echo '<h2>Mail sent!</h2>';
  } 
  else {
    echo '<h2>Something went wrong with your form, please try again!</h2>';   
  }
}
?>
				<form id="price_check" method="post" action="" enctype="multipart/form-data">
					<input type="text" class="price_request" name="client_name" placeholder="Individual or company(name)">
					<input type="text" class="price_request" name="client_email" placeholder="E-mail">
					<input type="text" class="price_request" name="client_phone" placeholder="Phone No.">
					<input type="text" class="price_request" name="contact_person" placeholder="Contact Person">
					<input type="text" class="price_request" name="country" placeholder="Country">
					<input type="text" class="price_request" name="language_from" placeholder="Source language">
					<input type="text" class="price_request" name="language_to" placeholder="Target language">
					<input type="text" class="price_request" name="deadline" placeholder="Due date">
					<textarea class="price_request description" name="description" placeholder="Brief Outline of Subject Matter (incl. volume of material)" style="resize: none;"></textarea>
					<h2>Attach file(s):</h2>
					<input type="file" class="price_request files" name="files[]" multiple>
					<div id="submit_area">
						<div id="submit_btn">
							<input name="submit" type="submit" value="SEND" class="submit">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
  </div>

	<div id="content" class="notindex">
		<div class="container">
				<div id="content_btns">
					<ul>
						<li><a href="<?php echo get_home_url(); ?>/services"><span class="btn_text">view services</span><div class="content_btn_arrow"></div></a></li>
						<li><a href="<?php echo get_home_url(); ?>/price-quotation" class="orange"><span class="btn_text">request a quote</span><div class="content_btn_arrow"></div></a></li>
						<li><a href="<?php echo get_home_url(); ?>/clients-comments"><span class="btn_text">view feedback</span><div class="content_btn_arrow"></div></a></li>
					</ul>
				</div>
		</div>
	</div>

<?php get_footer(); ?>