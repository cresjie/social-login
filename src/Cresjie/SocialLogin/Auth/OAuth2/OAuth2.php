<?php

namespace Cresjie\SocialLogin\Auth\OAuth2;

use Illuminate\Support\Facades\Config;

use Cresjie\SocialLogin\SocialLogin;

class OAuth2{
			
			//required
	protected $service_name ="", 
	 		$login_url = "",
			$access_token_url = "",
			$endpoint = "",

			//optional
			$scope_separator = " ",
			$access_token_method = "post",
			$access_token_extra_curl = [],
			$endpoint_extra_curl = [],
			$endpoint_method = "get";

	
	public function loginUrl(array $additional_params = []){
		
		
		$service_params = Config::get('social-login::config')[$this->service_name];

		$service_params['response_type'] = 'code';
		unset($service_params['client_secret']); //login url doesnt need client secret

		if( !empty($service_params['scope']) )
			$service_params['scope'] = implode( $service_params['scope'] ,$this->scope_separator);

		if( !empty($additional_params))
			$service_params  += $additional_params; //merge arrays

		return $this->login_url . '?' . http_build_query($service_params);
	}


	public function authenticate($code){

		$service_params = Config::get('social-login::config')[$this->service_name];
		$service_params += ['code' => $code, 'grant_type' => 'authorization_code']; // add additional params to the query

		if( !empty($service_params['scope']) )
			$service_params['scope'] = implode( $service_params['scope'] , $this->scope_separator);

		//exchange code for access_token
		$result = SocialLogin::sendRequest($this->access_token_url, $service_params, $this->access_token_method, $this->access_token_extra_curl);

		
		//query the service API
		if($this->service_name == 'yahoo'){
			
			$auth = "Authorization: Bearer {$result['access_token']}";
			$result = SocialLogin::sendRequest($this->endpoint,['format' => 'json'],$this->endpoint_method,[
				CURLOPT_HTTPHEADER =>[
					$auth,
					'Content-Type: application/x-www-form-urlencoded'
				]
			]);


		}else{
			$result = SocialLogin::sendRequest($this->endpoint,[
				'access_token' => $result['access_token'],
				'alt' => 'json'
			], $this->endpoint_method, $this->endpoint_extra_curl);
		}

		return $result;

	}

}