<?php

namespace App\DataFixtures;

use App\Entity\Coupon;
use App\Entity\Product;
use App\Enum\CouponTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class ProductCouponFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            [
                'id' => 0,
                'name' => 'Iphone',
                'price' => 100,
            ],
            [
                'id' => 1,
                'name' => 'Наушники',
                'price' => 20,
            ],
            [
                'id' => 2,
                'name' => 'Чехол',
                'price' => 10,
            ],
        ];

        $coupons = [
            [
                'id' => 0,
                'product_id' => 0,
                'code' => 'F4',
                'discount' => 4,
                'type' => CouponTypeEnum::Fix->value,
            ],
            [
                'id' => 1,
                'product_id' => 1,
                'code' => 'P5',
                'discount' => 5,
                'type' => CouponTypeEnum::Percent->value,
            ],
            [
                'id' => 3,
                'product_id' => 2,
                'code' => 'F6',
                'discount' => 6,
                'type' => CouponTypeEnum::Fix->value,
            ],
        ];

        for ($i = 0; $i < count($products); $i++) {
            $product = new Product();
            $product->setId($products[$i]['id']);
            $product->setName($products[$i]['name']);
            $product->setPrice($products[$i]['price']);
            $manager->persist($product);

            $coupon = new Coupon();
            $coupon->setId($coupons[$i]['id']);
            $coupon->setCode($coupons[$i]['code']);
            $coupon->setDiscount($coupons[$i]['discount']);
            $coupon->setProduct($product);
            $coupon->setType($coupons[$i]['type']);

            $manager->persist($coupon);
        }


        $manager->flush();
    }
}
