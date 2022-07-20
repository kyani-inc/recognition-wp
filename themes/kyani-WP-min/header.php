<?php

/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$container = get_theme_mod('understrap_container_type');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>


<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<script src="https://kit.fontawesome.com/0b3c9b4cc0.js" crossorigin="anonymous"></script>
	<link
			href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
			rel="stylesheet">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
	<title><?php echo esc_html(wp_title()); ?> </title>

</head>

<body <?php body_class(); ?> <?php understrap_body_attributes(); ?>>

<?php do_action('wp_body_open'); ?>
<div class="site" id="page">
	<section id="BannerMessages">

	</section>
		<header>
		<nav class="navbar-expand-md d-flex">
			<!-- ******************* The Navbar Area ******************* -->
			<?php if ((is_page() || is_singular())) : ?>
				<?php endif; ?>
				<a href="<?php echo(get_home_url()) ?>" class="navbar-brand">
					<img src="<?php echo esc_url(bloginfo('template_directory') . "/images/logo-header.svg") ?>" alt="Kyani Logo" width="80px">
				</a>

				<?php wp_nav_menu(
						array(
								'theme_location' => 'primary',
								'container_class' => 'collapse navbar-collapse',
								'container_id' => 'navbarNavDropdown',
								'menu_class' => 'navbar-nav mr-auto',
								'fallback_cb' => '',
								'menu_id' => 'main-menu',
								'depth' => 3,
								'walker' => new Custom_WP_Bootstrap_Navwalker()
						)
				); ?>
		</nav><!-- .site-navigation -->
</div>
<!--main-menu end-->
</header>


</div><!-- #wrapper-navbar end -->
