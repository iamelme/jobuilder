<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package jobuilder
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>

	<script src='https://www.google.com/recaptcha/api.js' async defer></script>
</head>

<body <?php body_class(); ?>>

<?php get_template_part('icons'); ?>

<div class="wrapper">


	<header class="header" id="main-header">
		<div class="header__top">
			<div class="header__inner">
				<span>Mon - Fri 8:00 AM - 5:00 PM</span>

				<div class="header__info">
					<a href="mailto:<?php echo bloginfo('admin_email'); ?>" class="info invi-sm"><?php echo bloginfo('admin_email'); ?></a> 
					<a href="tel:" class="info invi-sm">33333333</a> 
					<a href="" class="info fb">
						<svg  class="icon icon-facebook">
						  	<use xlink:href="#icon-facebook"></use>
						</svg>
					</a>					
				</div>
			</div>
		</div>
		<div class="header__inner">
			<a href="<?php echo home_url(); ?>" class="branding">
				<img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo5.png" style="max-height: 50px; margin-top: 1px" alt="">
			</a>
			<div class="header__nav">
				<div class="nav-trigger" data-target="main-header">
					<span class="line"></span>
					<span class="line"></span>

					<span class="menu-text">MENU</span>
				</div>

				<nav class="main-menu">
					<a href="mailto:<?php echo bloginfo('admin_email'); ?>" class="info invi-md"><?php echo bloginfo('admin_email'); ?></a> 
					<a href="tel:" class="info invi-md">63 6999 999 66</a>
					<?php
						wp_nav_menu( array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
						) );
					?>
				</nav>

				

			</div>
		</div>
	</header>
