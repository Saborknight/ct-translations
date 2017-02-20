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
				<h1 class="rus">Предлагаем скидки как новым, так и постоянным клиентам! Сделайте запрос бесплатного ценового предложения спомощью нижеприведенной формы: </h1>
			</div>
			<div id="wrapper_content">
				<?php
if(isset($_POST['submit'])) {
     
    $email_to = "ct@ct.ee";
    $email_subject = "Hinnapäring ".$_POST['name'];
     
     
    function died($error) {
        // your error code can go here
        echo "<h2>Возникли ошибки при отправке предложения:</h2>";
        echo "<br /><br />";
        echo $error."<br /><br />";
        echo "<h2>Пожалуйста, исправьте ошибки.</h2><br /><br />";
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
    $error_message .= '<p>Электронный адрес неправильный.</p><br />';
  }
  if(strlen($name) < 2) {
    $error_message .= '<p>Имя/название компании неправильный.</p><br />';
  }
  if(strlen($contact_person) < 2){
    $error_message .= '<p>Контактное лицо неправильнoe.</p><br />';
  }
  if(strlen($language_from) < 2){
    $error_message .= '<p>Исходный язык неправильный.</p><br />';
  }
  if(strlen($language_to) < 2){
    $error_message .= '<p>Целевой язык неправильный.</p><br />';
  }
  if(strlen($country) < 2){
    $error_message .= '<p>Государство неправильнoe.</p><br />';
  }
  if(strlen($deadline) < 4) {
    $error_message .= '<p>Желаемый срок исполнения неправильный.</p><br />';
  }
   if(strlen($description) < 4) {
    $error_message .= '<p>Тематическая направленность слишком короткая.</p><br />';
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

    $header = 'From: Hinnapäring lehelt www.ct.ee(vene keeles) <ct@ct.ee>';
     
    $sendmail = wp_mail($email_to, $email_subject, $email_message, $header, $attachments);
  if(strlen($error_message) > 0){
    died($error_message); 
  }
	else if($sendmail) {
    echo '<h2>Почта, отправленная!</h2>';
  } 
  else {
    echo '<h2>Что-то пошло не так!</h2>';   
  }
}
?>
				<form id="price_check" method="post" action="" enctype="multipart/form-data">
					<input type="text" class="price_request" name="client_name" placeholder="Имя/название компании">
					<input type="text" class="price_request" name="client_email" placeholder="Электронный адрес">
					<input type="text" class="price_request" name="client_phone" placeholder="Номер телефона">
					<input type="text" class="price_request" name="contact_person" placeholder="Контактное лицо">
					<input type="text" class="price_request" name="country" placeholder="Государство">
					<input type="text" class="price_request" name="language_from" placeholder="Исходный язык">
					<input type="text" class="price_request" name="language_to" placeholder="Целевой язык">
					<input type="text" class="price_request" name="deadline" placeholder="Желаемый срок исполнения">
					<textarea class="price_request description" name="description" placeholder="Тематическая направленность и объем текста" style="resize: none;"></textarea>
					<h2>Приложите файл(ы):</h2>
					<input type="file" class="price_request files" name="files[]" multiple>
					<div id="submit_area">
						<div id="submit_btn">
							<input name="submit" type="submit" value="Послать" class="submit">
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
						<li><a href="<?php echo get_home_url(); ?>/services"><span class="btn_text">смотри услуги</span><div class="content_btn_arrow"></div></a></li>
						<li><a href="<?php echo get_home_url(); ?>/price-quotation" class="orange"><span class="btn_text">cпроси предложение</span><div class="content_btn_arrow"></div></a></li>
						<li><a href="<?php echo get_home_url(); ?>/clients-comments"><span class="btn_text">смотри комментарии</span><div class="content_btn_arrow"></div></a></li>
					</ul>
				</div>
		</div>
	</div>

<?php get_footer(); ?>