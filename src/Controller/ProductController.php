<?php

namespace App\Controller;

use App\Request\CalculatorRequest;
use App\Request\PurchaseRequest;
use App\Service\CalculatorService;
use App\Service\PurchaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/calculate-price', name: 'calculate_price', methods: ['POST'])]
    public function index(CalculatorRequest $request, CalculatorService $calculatorService): JsonResponse
    {
        return $this->json($calculatorService->calculate(...$request->getRequest()->toArray()));
    }

    #[Route('/purchase', name: 'purchase', methods: ['POST'])]
    public function purchase(
        PurchaseRequest $request,
        CalculatorService $calculatorService,
        PurchaseService $purchaseService,
    ): JsonResponse
    {
        $params = $request->getRequest()->toArray();
        $class = $purchaseService->getClass($params['paymentProcessor']);
        unset($params['paymentProcessor']);
        $price = $calculatorService->calculate(...$params);
        $method = get_class_methods($class)[0];

        (new $class)->{$method}($price['price']);

        return $this->json(['success' => true]);
    }
}
