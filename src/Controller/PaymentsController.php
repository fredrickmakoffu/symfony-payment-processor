<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class PaymentsController extends AbstractController
{
  public function process(): JsonResponse
  {
    return $this->json([
      'message' => 'Welcome to your new controller!',
      'path' => 'src/Controller/PaymentsController.php',
    ]);
  }
}
