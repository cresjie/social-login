<?php

namespace Cresjie\SocialLogin\Facades;

use Illuminate\Support\Facades\Facade;

class SocialLogin extends Facade{
	protected static function getFacadeAccessor(){
		return "social-login";	
	}	
}