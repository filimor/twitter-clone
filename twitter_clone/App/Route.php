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

		$this->setRoutes($routes);
	}
}