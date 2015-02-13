<?php

namespace Cresjie\SocialLogin\Auth\OAuth2;
use Illuminate\Support\Facades\Config;

class Yahoo extends OAuth2{

	protected $service_name = "yahoo",
	 		$login_url = "https://api.login.yahoo.com/oauth2/request_auth",
			$access_token_url = "https://api.login.yahoo.com/oauth2/get_token",
			$endpoint = "https://social.yahooapis.com/v1/user/me/profile";

	function __construct(){
		$config = Config::get('social-login::config.yahoo');
		$auth = "Authorization: Basic " . base64_encode("{$config['client_id']}:{$config['client_secret']}");

		$this->access_token_extra_curl = [
			CURLOPT_HTTPHEADER =>[
				$auth,
				'Content-Type: application/x-www-form-urlencoded'
			]
		];
	}			
}