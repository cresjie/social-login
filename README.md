Social Login
===================

Laravel 4 Authentication with Social Services API (OAuth2) like **Google, Facebook, Yahoo, Github**


----------


Installation via Composer
-------------

Add this to your composer.json file, in the require object:

```javascript
 "cresjie/social-login": "v1.0.0.0"
```
After that, run composer install to install the package.

Add the service provider to app/config/app.php, within the providers array.
```php
 'providers' => array(
	...
	'Cresjie\SocialLogin\SocialLoginServiceProvider'
)
```
Configuration
-------------
Publish the default config file to your application so you can make modifications.

```
$ php artisan config:publish cresjie/social-login
```
Add your service provider credentials to the published config file:

```
 app/config/packages/cresjie/social-login/config.php
```
for formality set your redirect callback credential to something like:
www.mysite.com/login/google/callback
see **Basic usage -> Authentication **

BASIC USAGE
-------------

##Login Page
```php
Route::get('/login/{provider}',function($provider){
	return SocialLogin::login($provider);
});
```

where **provider** is a social service like google, facebook, etc..
this would redirect the user to the login page for the that social service.

##Authentication

```php
Route::get('/login/{provider}/callback',function($provider){
	var_dump( SocialLogin::authenticate($provider) );
});
```
after the user logs in to his social service. He/she will be redirected to the url specified in your *config file redirect*, and just call the **SocialLogin::authenticate($provider)** to retrieve information

Other Usage
-------------

you can also filter results in the *config file* to have uniform calls. For example retrieving profile picture in google has an array key of *picture* while in github has an array key of *avatar_url*
```php
Route::get('/login/{provider}/callback',function($provider){
	$results = SocialLogin::authenticate($provider);
	
	echo $results['picture']; // for goole
	echo $results['avatar_url']; //for github
	
});
``` 

how about a uniform call.

```php
Route::get('/login/{provider}/callback',function($provider){
	$results = SocialLogin::authenticate($provider);
	
	echo $results['image']; //uniform call
	
});
```

how? just set **filter_result** in the *config file* with something like:
```javascript
<?php
	return [
		'google' => [
				...
				'filter_result' => function($result){
					$result['image'] = $result['picture'];
					return $result; //should have return value
				}
		],

		'github' => [
			...
			'filter_result' => function($result){
				$result['image'] = $result['avatar_url'];
				return $result;
			}
		]
];
```

we've just add another key to the *result value* to have a uniform call.. cool!


Access Token
---------
After the user successfully authenticate the login. You can get the access token by calling the method:
**SocialLogin::getAccessToken()**
