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

		$this->setRoutes($routes);
	}
}