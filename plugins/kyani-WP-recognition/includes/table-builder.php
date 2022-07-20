<?php
function tableBuilderShortcode($atts, $content = null) {

	$args = shortcode_atts(array(
		'url' => '',
		'country' => 'yes',
		'name' => 'yes',
		'type' => ''
	), $atts);

	if (!$args['url']) {
	return 'Please Enter a URL Parameter';
	}
	$url = $args['url'];
	$json_data = json_decode(file_get_contents($url));
	$data = $json_data->data;

	$jsonTable = '<h3>' . $content . '</h3>';
	$jsonTable .= '<table class=table-striped table-condensed" width=100%>';
	//Table Heading
	$jsonTable .= '<tr>';
	if ($args['country'] == 'yes' || $args['country'] == 'Yes') {
	$jsonTable .= '<th class="Header" scope="col">Country</th>';
	}
	if ($args['name'] == 'yes' || $args['name'] == 'Yes') {
		$jsonTable .= '<th class="Header" scope="col">Name</th>';
	}
	if ($args['type'] == 'enrollments' || $args['type'] == 'Enrollments') {
		$jsonTable .= '<th class="Header" scope="col">Enrollments</th>';
	} else if ($args['type'] == 'tickets' || $args['type'] == 'Tickets') {
		$jsonTable .= '<th class="Header" scope="col">Tickets</th>';
	} else if ($args['type'] == 'points' || $args['type'] == 'Points') {
		$jsonTable .= '<th class="Header" scope="col">Points</th>';
	}
	$jsonTable .= '</tr>';
	foreach($data as $val ) {
		$jsonTable .= '<tr>';
		if ($args['country'] == 'yes' || $args['country'] == 'Yes') {
			$jsonTable .= '<td class="Data"><img src="https://office.kyani.net/assets/images/flags/' . $val->Country . '.png" alt="' . $val->CountryFull . '">' . $val->CountryFull . '</td>';
		}
		if ($args['name'] == 'yes' || $args['name'] == 'Yes') {
			$jsonTable .= '<td class="Data">' . $val->Name . '</td>';
		}
		if ($args['type'] == 'enrollments' || $args['type'] == 'Enrollments') {
			$jsonTable .= '<td class="Data">' . $val->Enrollments . '</td>';
		} else if ($args['type'] == 'tickets' || $args['type'] == 'Tickets') {
			$jsonTable .= '<td class="Data">' . $val->Tickets . '</td>';
		} else if ($args['type'] == 'points' || $args['type'] == 'Points') {
			$jsonTable .= '<td class="Data">' . $val->Points . '</td>';
		}
		$jsonTable .= '</tr>';
	}
$jsonTable .= '</table>';
return $jsonTable;
}

add_shortcode('jsonTable', 'tableBuilderShortcode');
