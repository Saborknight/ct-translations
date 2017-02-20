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
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/normalize.css">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/animate.min.css">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
        <script src="<?php echo get_template_directory_uri(); ?>/js/vendor/modernizr-2.6.2.min.js"></script>

        <?php wp_head(); ?>
    </head>
    
    <body <?php body_class(); ?>>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

   		<div id="top">
			<div class="container">
				<div id="logo_area">
					<a id="logo" href="<?php echo get_home_url(); ?>"></a>
				</div>
				
				<div id="phone">
					<div id="phone_icon"></div>
					<div id="phone_number">	
						<div id="region_code">(+372)</div><span>53464931</span>
					</div>
				</div>
				
				<div id="language">
					<ul>
						<li class="active"><a href="<?php echo get_site_url(4); ?>"><div class="lang_icon fin"></div>Suomeksi<div id="arrow"></div></a></li>
						<li><a href="<?php echo get_site_url(1); ?>"><div class="lang_icon est"></div>Eesti keeles</a></li>
						<li><a href="<?php echo get_site_url(3); ?>"><div class="lang_icon rus"></div>Пo русский</a></li>
						<li class="last"><a href="<?php echo get_site_url(2); ?>"><div class="lang_icon eng"></div>In English</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div id="menu_area">
			<div class="container">
				<div id="menu_show"></div>
				<?php
					$args = array(

						'exclude'  => 5

					);
				?>

				<?php wp_nav_menu( $args ); ?> 

				<form id="search" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
					<input type="text" id="search-input" name="s" onfocus="if(this.value=='Hae sivustosta')this.value=''" onblur="if(this.value=='')this.value='Hae sivustosta'" value="Hae sivustosta" />
					<input type="submit" id="search-btn" value="" />
				</form>
			
			</div>
		</div>