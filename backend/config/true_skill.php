<?php

return [
	// endpoint
	'true_skill_base_url' => env('TRUE_SKILL_BASE_URL'),

	// username
	'username' => env('TRUE_SKILL_USER_NAME'),

	// password
	'password' => env('TRUE_SKILL_PASSWORD'),

	'requests' => [
		'default_skill' 			=> [
			'method' 	=> 'GET',
			'uri'		=>	'v2/get/default_skill',
		],
		'calc_skill' 				=> [
			'method' 		=> 'POST',
			'uri'			=>	'v2/post/calc_skill',
		],
		'team_division_pattern' 	=> [
			'method' 		=> 'POST',
			'uri'			=>	'v2/post/team_division_pattern',
		],
		'data_conversion' 			=> [
			'method' 		=> 'POST',
			'uri'			=>	'v2/post/data_conversion',
		],
		'token' 					=> [
			'method' 		=> 'POST',
			'uri'			=>	'v2/post/token',
		],
	],

];