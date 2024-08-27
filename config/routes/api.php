<?php

	use Symfony\Component\Routing\RouteCollection;
	use Symfony\Component\Routing\Route;

	$routes = new RouteCollection();

	$routes->add('example_route', new Route('/app/example/{system}', [
    '_controller' => 'App\Controller\PaymentsController::process',
	], [
	   'system' => 'aci|shift4' // Restricting the parameter to specific values
	]));

	return $routes;
?>
