<?php 

namespace App;

use MF\Init\Bootstrap; 


class Route extends Bootstrap{ 


protected function initRoutes(){
	$routes['index'] = Array(
		'route' => '/',
		'controller' => 'IndexController',
		'action' => 'index'
	);

	$routes['inscreverse'] = Array(
		'route' => '/inscreverse',
		'controller' => 'IndexController',
		'action' => 'inscreverse'
	);
	
	$routes['registrar'] = Array(
		'route' => '/registrar',
		'controller' => 'IndexController',
		'action' => 'registrar'
	);

	$routes['autenticar'] = Array(
		'route' => '/autenticar',
		'controller' => 'AuthController',
		'action' => 'autenticar'
	);

	$routes['timeline'] = Array(
		'route' => '/timeline',
		'controller' => 'AppController',
		'action' => 'timeline'
	);

	$routes['sair'] = Array(
		'route' => '/sair',
		'controller' => 'AuthController',
		'action' => 'sair'
	);

	$routes['tweet'] = Array(
		'route' => '/tweet',
		'controller' => 'AppController',
		'action' => 'tweet'
	);

	$routes[' '] = Array(
		'route' => '/quem_seguir',
		'controller' => 'AppController',
		'action' => 'quemSeguir'
	);

	$routes['acao'] = Array(
		'route' => '/acao',
		'controller' => 'AppController',
		'action' => 'acao'
	);

	$routes['remover_tweet'] = Array(
		'route' => '/remover_tweet',
		'controller' => 'AppController',
		'action' => 'acao'
	);


	$this->setRoutes($routes);
 }

}


 ?>