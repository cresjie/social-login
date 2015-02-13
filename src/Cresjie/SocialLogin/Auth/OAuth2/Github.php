<?php

namespace Cresjie\SocialLogin\Auth\OAuth2;
use Illuminate\Support\Facades\Config;

class Github extends OAuth2{

	protected $service_name = "github",
	 		$login_url = "https://github.com/login/oauth/authorize",
			$access_token_url = "https://github.com/login/oauth/access_token",
			$endpoint = "https://api.github.com/user",
			$scope_separator = ',';
			
			

	function __construct(){
		$this->endpoint_extra_curl = [
				CURLOPT_HTTPHEADER => ["User-Agent: ".Config::get('social-login::config.github.appName') ]
			];		
	}
							
}