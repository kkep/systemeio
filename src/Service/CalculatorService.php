<?php

namespace App\Service;

use App\Enum\CouponTypeEnum;
use App\Repository\ProductRepository;
use App\Repository\TaxRepository;

class CalculatorService
{
    public function __construct(
        protected ProductRepository $productRepository,
        protected TaxRepository $taxRepository,
    ) {}

    public function calculate(int $product, string $taxNumber, ?string $couponCode = null)
    {
        $product = $this->productRepository->find($product);

        $discount = 0;

        if ($couponCode) {
            $coupon = $product->getCoupons()
                ->filter(fn ($el) => $el->getCode() === $couponCode)
                ->first();

            $discount = $coupon->getType() === CouponTypeEnum::Fix
                ? $coupon->getDiscount()
                : $product->getPrice() / 100 * $coupon->getDiscount();
        }

        $tax = $this->taxRepository->findOneBy(['number' => $taxNumber]);

        $price = $product->getPrice() - $discount;
        $price = $price + ($price / 100 * $tax->getPercent());

        return [
            'price' => round($price, 2),
            'discount' => $discount,
        ];
    }
}
