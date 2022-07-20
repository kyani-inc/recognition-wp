<?php
/*
 * Plugin Name: Kyani WP for SAP
 * Description: This plugin adds functionality for Replicated Sites and creates the Country Switcher in the navigation menus for each country for SAP.
 * Version: 1.0
 * Author: Gage Bateman
 * Author URI: http://kyani.com
 */

$kyani_plugin_includes = array(
//	'/country-switcher/country-switcher.php',
//	'/nav-country-switcher.php',
	'/table-builder.php',
	'/customizer.php',
);

foreach ($kyani_plugin_includes as $file) {
	require_once plugin_dir_path(__FILE__) . 'includes' . $file;
}
