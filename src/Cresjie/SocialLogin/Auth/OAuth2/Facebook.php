<?php

namespace Cresjie\SocialLogin\Auth\OAuth2;

class Facebook extends OAuth2{

	protected $service_name = "facebook",
	 		$login_url = "https://graph.facebook.com/oauth/authorize",
			$access_token_url = "https://graph.facebook.com/oauth/access_token",
			$endpoint = "https://graph.facebook.com/me";			
}
