<?php

namespace Cresjie\SocialLogin\Auth\OAuth2;

class Google extends OAuth2{

	protected $service_name = "google",
	 		$login_url = "https://accounts.google.com/o/oauth2/auth",
			$access_token_url = "https://accounts.google.com/o/oauth2/token",
			$endpoint = "https://www.googleapis.com/oauth2/v2/userinfo";			
}