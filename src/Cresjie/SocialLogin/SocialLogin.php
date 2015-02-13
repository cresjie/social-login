<?php 
namespace Cresjie\SocialLogin;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;

class SocialLogin{
	
	
	public function login($service){
		
		$service_state = Str::random();
		Session::put('service_state',$service_state); // store the state code in the session

		$classNamespace = "Cresjie\\SocialLogin\\Auth\\" . Config::get('social-login::oauth_version')[ strtolower($service) ] . '\\' . ucwords($service);
		$service = new $classNamespace;

		$url = $service->loginUrl(['state' => $service_state]);

		return Redirect::to($url);
		
	}


	public function authenticate($service){

		if( Input::get('code') ){

			if( Input::get('state') != Session::get('service_state'))
				throw new Exception("CSRF");
				
			$classNamespace = "Cresjie\\SocialLogin\\Auth\\" . Config::get('social-login::oauth_version')[ strtolower($service) ] . '\\' . ucwords($service);
			$serviceProvider = new $classNamespace;

			$result = $serviceProvider->authenticate( Input::get('code') );
			
			
			//trigger filter result in config file
			if( Config::get("social-login::config.$service.filter_result")  ){
				$filter_result = Config::get("social-login::config.$service.filter_result");
				$result = $filter_result($result);
			}
			$result['provider'] = $service;
			return $result;

		}else if( Input::get('error') )
			throw new \Exception( Input::get('error_message') );
		else
			throw new \Exception('Unknown Exception');
	}


	public static function sendRequest( $host,array $fields, $method = 'get', $extra_curl = []){

		$curl = curl_init();

		switch ( strtolower($method) ) {
			case 'get':
				
				$curl_params = [
					CURLOPT_URL => $host . '?' . http_build_query($fields),
					CURLOPT_RETURNTRANSFER => 1
				] + $extra_curl;
				curl_setopt_array($curl, $curl_params);

				break;
			
			case 'post':

				$curl_params = [
					CURLOPT_POST =>true,
					CURLOPT_URL => $host,
					CURLOPT_HTTPAUTH => CURLAUTH_ANY,
					CURLOPT_SSL_VERIFYPEER => false,
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_HEADER => false,
					CURLOPT_POSTFIELDS => http_build_query($fields)
				] + $extra_curl;
				curl_setopt_array($curl, $curl_params);
				break;
		}

		$result = curl_exec($curl);

		if( !$result){
			
			throw new \Exception( curl_errno($curl) ); 
		}
		$json = json_decode($result,true);

		if($json)
			$output = $json;
		else
			parse_str($result,$output); // if the result is not a valid json, it might be a string to be parsed

		if( isset($output['error']) ){
			//throw new \Exception( $output['error_message']);
			var_dump($output);exit();
		}
		return $output;

	} // /sendRequest

	

	
}

