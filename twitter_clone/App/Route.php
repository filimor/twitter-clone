<?php
namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap
{
	public function initRoutes()
	{
		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['signup'] = array(
			'route' => '/signup',
			'controller' => 'indexController',
			'action' => 'signup'
		);

		$routes['register'] = array(
			'route' => '/register',
			'controller' => 'indexController',
			'action' => 'register'
		);

		$routes['auth'] = array(
			'route' => '/auth',
			'controller' => 'authController',
			'action' => 'auth'
		);

		$routes['timeline'] = array(
			'route' => '/timeline',
			'controller' => 'appController',
			'action' => 'timeline'
		);

		$routes['logout'] = array(
			'route' => '/logout',
			'controller' => 'authController',
			'action' => 'logout'
		);

		$routes['tweet'] = array(
			'route' => '/tweet',
			'controller' => 'appController',
			'action' => 'tweet'
		);

		$this->setRoutes($routes);
	}
}