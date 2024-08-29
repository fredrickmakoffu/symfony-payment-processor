<?php

	use App\Constants\PaymentGatewayType;
	use Symfony\Component\Routing\RouteCollection;
	use Symfony\Component\Routing\Route;

	$routes = new RouteCollection();

	$routes->add('example_route', new Route('/app/example/{payment_system}', [
	    '_controller' => 'App\Controller\PaymentGatewayController::process',
	], [
	    'payment_system' => implode('|', PaymentGatewayType::get()), // Restricting the parameter to specific values
	], [], '', [], ['POST'])); // Restricting the route to POST method

		return $routes;
?>
