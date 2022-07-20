<?php

/**
 * Sidebar setup for footer full
 *
 * @package understrap
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

$container = get_theme_mod('understrap_container_type');

?>

<?php if (is_active_sidebar('footerfull')) : ?>

	<!-- ******************* The Footer Full-width Widget Area ******************* -->

	<div class="wrapper" id="wrapper-footer-full">
		<div class="container" id="footer-full-content">
			<div class="row footer-top">
				<div class="footer-company-info"><?php dynamic_sidebar('footerlogo') ?></div>
				<div class="footer-navigation-menus"><?php dynamic_sidebar('footerfull'); ?></div>
			</div>
			<div class="footer-additional-text">
				<?php dynamic_sidebar('footertext') ?>
			</div>
			<div class="footer-links">
				<div>© <?php echo do_shortcode('[year]') ?> <?php echo get_option('my_copyright'); ?></div>
				<?php wp_nav_menu(array('theme_location' => 'footer-links',)); ?>
			</div>

		</div>

	</div><!-- #wrapper-footer-full -->

<?php endif;
