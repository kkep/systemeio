<?php

namespace App\Request;

use App\Repository\ProductRepository;
use App\Repository\TaxRepository;
use App\Service\PurchaseService;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseRequest extends CalculatorRequest
{
    #[Type('string')]
    #[NotBlank()]
    protected $paymentProcessor;

    public function __construct(
        ValidatorInterface $validator,
        ProductRepository $productRepository,
        TaxRepository $taxRepository,
        protected PurchaseService $purchaseService,
    ) {
        parent::__construct($validator, $productRepository, $taxRepository);
    }

    public function validate(): void
    {
        parent::validate();

        $messages = ['message' => 'validation_failed', 'errors' => []];

        if (!class_exists($this->purchaseService->getClass($this->paymentProcessor))) {
            $messages['errors'][] = [
                'property' => 'paymentProcessor',
                'value' => $this->paymentProcessor,
                'message' => 'Unavailable payment method',
            ];
            $this->sendErrors($messages);
        }
    }
}
