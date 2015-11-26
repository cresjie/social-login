<?php

return [
	'google' => [
		'client_id' => '254114236047-24oqrer035mjpigue3pcej9a6iu3p8ur.apps.googleusercontent.com',
		'client_secret' => 'yPwcW4W3CFw1Ny12qSfIZmso',
		'redirect_uri' => 'http://mymusicrocks.url.ph/login/google/callback',
		'scope' => [
			'openid',
			'email',
			'profile',
			'https://www.googleapis.com/auth/plus.me',
			'https://www.googleapis.com/auth/userinfo.profile',
			'https://www.googleapis.com/auth/userinfo.email',
			'https://www.googleapis.com/auth/plus.login'

		],
		'filter_result' => function($result){
			$result['provider_user_id'] = $result['id'];
			return $result;
		}

	],

	'facebook' => [
		'client_id' => '751285561592751',
		'client_secret' => 'f71629500b993bbbf2393b4e851021cc',
		'redirect_uri' => 'http://localhost/laravel2/public/login/facebook/callback',
		'scope' => [
			'email',
			'public_profile'
		]

	],
	
	'yahoo' => [
		'client_id' => 'dj0yJmk9WXQyWGhqekxvSzFhJmQ9WVdrOU1FRkpVVTh4TkRnbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD1mMQ--',
		'client_secret' => '03ce381c33e103da2df24ae43f140b7f6eaff96a',
		'redirect_uri' => 'http://mymusicrocks.url.ph/login/yahoo/callback',
		'filter_result' => function($result){
			$profile = $result['profile'];

			$output['provider_user_id'] = $profile['guid'];
			$output['picture'] =$profile['image']['imageUrl'];
			$output['nick_name'] = $profile['nickname'];
			$output['name'] = isset($profile['givenName']) ? $profile['givenName'] : $profile['nickname'];
			$output['family_name'] = isset( $profile['familyName'] ) ? $profile['familyName'] : '';
			$output['gender'] = isset( $profile['gender'] ) ? $profile['gender'] : '';
			$output['link'] = $profile['profileUrl'];
			return $output;
			
			//return $result;
		}

	],
	'github' => [
		'client_id' => '4cbcc02d15cacbc8eb1b',
		'client_secret' => '9fd9d6995f30d26c2c249d38f1999b3ae085fee0',
		'redirect_uri' => 'http://mymusicrocks.url.ph/login/github/callback',
		'appName' => 'cresjie',
		'scope' => [
			'user:email',
			],
		'filter_result' => function($result){
			$result['picture'] = $result['avatar_url'];
			$result['provider_user_id'] = $result['id'];
			return $result;
		}
	],
	'facebook' => [
		'client_id' => '',
		'client_secret' => '',
		'redirect_uri' => '',
	]
];
