<?php

	use App\Constants\PaymentType;
	use Symfony\Component\Routing\RouteCollection;
	use Symfony\Component\Routing\Route;

	$routes = new RouteCollection();

	$routes->add('example_route', new Route('/app/example/{payment_system}', [
	    '_controller' => 'App\Controller\PaymentsController::process',
	], [
	    'payment_system' => implode('|', PaymentType::get()), // Restricting the parameter to specific values
	], [], '', [], ['GET'])); // Restricting the route to POST method

		return $routes;
?>
