<?php
/**
 * Custom navigation country switcher for Kyani
 */

add_filter('wp_nav_menu_items', 'add_country_selector_to_menu', 10, 2);
function add_country_selector_to_menu($items, $args)
{
	register_files();
	$sites = get_sites(['public' => 1]);
	$current_site_id = get_current_blog_id();
	$new_nav_item = "";
	$items_array = array();

	$url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING);
	if (strpos($url, 'events') !== false) {
		$parts = parse_url($url);
		$country_path = explode('/', $parts[path]);
		$current_site_country_code = $country_path[3];
	} else {
		$current_site_country_code = str_replace("/", "", get_blog_details($current_site_id)->path);
	}

	// since the main site is for the US but contains no country code assign it to $current_site_country_code
	if ($current_site_country_code == "") {
		$current_site_country_code = "us";
	}


	if ($args->theme_location == "secondary") {
		$new_nav_item .= '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">';
		$new_nav_item .= '<img src="' . plugins_url() . '/kyani-custom-plugin/assets/images/flags/' . $current_site_country_code . '.svg" width="24">' . '</a>';
		$new_nav_item .= '<ul class="dropdown-menu dropdown-menu-right" id="countries" aria-labelledby="navbarDropdown">';

		$new_nav_item .= countrySwitcherBuilder($sites);
		$new_nav_item .= '</ul>';

		// if there are menu items in the $items array it will add the country switcher as the second menu item
		if ($items) {
			while (false !== ($items_pos = strpos($items, '<li', 2))) {
				$items_array[] = substr($items, 0, $items_pos);
				$items = substr($items, $items_pos);

			}
			$items_array[] = $items;
			array_splice($items_array, 0, 0, $new_nav_item);

			$items = implode('', $items_array);
			return $items;
		}
	}
	return $items . $new_nav_item;

}

add_filter('wp_nav_menu_items', 'add_country_selector_to_mobile', 10, 2);
function add_country_selector_to_mobile($items, $args)
{
	$sites = get_sites(['public' => 1]);
	$new_nav_item = "";

	if ($args->theme_location == "slide") {
		$new_nav_item .= "<li class='nav-item dropdown mobile-only'><a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown'>";
		$new_nav_item .= __("Country") . "</a>";
		$new_nav_item .= "<ul class='dropdown-menu' id='countries' aria-labelledby='navbarDropdown'>";

		$new_nav_item .= countrySwitcherBuilder($sites);
		$new_nav_item .= "</ul>";
	}
	return $new_nav_item . $items;
}

// function builds the dropdown menu with all the countries
function countrySwitcherBuilder($sites)
{
	$country_websites = json_decode(file_get_contents(plugins_url() . '/kyani-wp-SAP/assets/data/sites.json'));
	$rep = "";
	if (isset($_SERVER['HTTP_X_KYANI_REP'])) {
		$rep = explode(';', $_SERVER['HTTP_X_KYANI_REP'])[0];
	}
	$dropdownItems = "<div class='d-flex flex-row'>";

	foreach ($country_websites->regions as $region) {
		$dropdownItems .= '<button id="' . $region->className . '-header">' . $region->name . '</button>';
	}
	$dropdownItems .= '</div>';
	foreach ($country_websites->regions as $region) {
		$dropdownItems .= '<div class="d-flex flex-row flex-wrap" id="' . $region->className . '-list">';
		foreach ($region->countries as $country) {
			foreach ($sites as $subsite) {
				$subsite->object_id = get_object_vars($subsite)['blog_id'];
				$url = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_STRING);
				$subsite->url = get_blog_details($subsite->object_id)->siteurl;
				$subsite->displayname = get_blog_details($subsite->object_id)->blogname;
				$subsite->path = str_replace("/", "", get_blog_details($subsite->object_id)->path);
			}
			$dropdownItems .= "<div>";
			if ($country->code == 'cn') {
				$dropdownItems .= "<div class='country-dropdown-item' href='" . $country->url . "'><img class='nav-country-flag' src='" . plugins_url() . '/kyani-custom-plugin/assets/images/flags/' . $country->code . ".svg' width='24'>" . $country->display_name . "</div>";
			} else {
				if (strpos($url, 'events') !== false) {
					$dropdownItems .= "<div class='country-dropdown-item' href='//" . ($rep != "" ? $rep . '.' : "") . $_SERVER['HTTP_HOST'] . "/events" . $country->events_name . "'><img class='nav-country-flag' src='" . plugins_url() . '/kyani-custom-plugin/assets/images/flags/' . $country->code . ".svg' width='24'>" . $country->display_name . "</div>";
				} else {
					$dropdownItems .= "<div class='country-dropdown-item' href='//" . ($rep != "" ? $rep . '.' : "") . $_SERVER['HTTP_HOST'] . $country->url . "'><img class='nav-country-flag' src='" . plugins_url() . '/kyani-custom-plugin/assets/images/flags/' . $country->code . ".svg' width='24'>" . $country->display_name . "</div>";
				}
			}
			$dropdownItems .= "<br><div class='d-flex flex-row'>";
			foreach ($country->languages as $language) {
				$dropdownItems .= $language->name;
			}
			$dropdownItems .= "</div></div>";
		}
		$dropdownItems .= "</div>";
	}
	return $dropdownItems;
}

function register_files()
{
	wp_enqueue_style('product-carousel-style', plugins_url() . '/kyani-wp-SAP/includes/country-switcher/assets/css/style.css');
	wp_enqueue_script('product-carousel-script', plugins_url() . '/kyani-wp-SAP/includes/country-switcher/assets/js/script.css');
}
