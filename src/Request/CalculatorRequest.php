<?php

namespace App\Request;

use App\Repository\ProductRepository;
use App\Repository\TaxRepository;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CalculatorRequest extends BaseRequest
{
    #[Type('integer')]
    #[NotBlank()]
    protected $product;

    #[Type('string')]
    #[NotBlank()]
    protected $taxNumber;

    #[Type('string')]
    protected $couponCode;

    public function __construct(
        ValidatorInterface $validator,
        protected ProductRepository $productRepository,
        protected TaxRepository $taxRepository,
    ) {
        parent::__construct($validator);
    }

    public function validate(): void
    {
        parent::validate();

        $messages = ['message' => 'validation_failed', 'errors' => []];

        $product = $this->productRepository->find($this->product);

        if (is_null($product)) {
            $messages['errors'][] = [
                'property' => 'product',
                'value' => $this->product,
                'message' => 'Product not found',
            ];
            $this->sendErrors($messages);
        }

        if ($this->couponCode) {
            $coupon = $product->getCoupons()
                ->filter(fn ($el) => $el->getCode() === $this->couponCode)
                ->first();

            if (!$coupon) {
                $messages['errors'][] = [
                    'property' => 'couponCode',
                    'value' => $this->couponCode,
                    'message' => 'Invalid coupon code',
                ];
                $this->sendErrors($messages);
            }
        }

        $tax = $this->taxRepository->findOneBy(['number' => $this->taxNumber]);

        if (is_null($tax)) {
            $messages['errors'][] = [
                'property' => 'taxNumber',
                'value' => $this->taxNumber,
                'message' => 'Tax number is invalid',
            ];
            $this->sendErrors($messages);
        }
    }


}
