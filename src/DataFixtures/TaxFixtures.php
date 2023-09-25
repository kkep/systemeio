<?php

namespace App\DataFixtures;

use App\Entity\Tax;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
;

class TaxFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            [
                'id' => 0,
                'country' => 'Germany',
                'percent' => 19,
                'number' => 'DE345378465',
            ],
            [
                'id' => 1,
                'country' => 'Italy',
                'percent' => 22,
                'number' => 'IT23412534533',
            ],
            [
                'id' => 2,
                'country' => 'France',
                'percent' => 20,
                'number' => 'FRAT456456435',
            ],
            [
                'id' => 3,
                'country' => 'Greece',
                'percent' => 24,
                'number' => 'GR635345758',
            ],
        ];
        foreach ($data as $item) {
            $tax = new Tax();
            $tax->setId($item['id']);
            $tax->setCountry($item['country']);
            $tax->setNumber($item['number']);
            $tax->setPercent($item['percent']);
            $manager->persist($tax);
        }
        $manager->flush();
    }
}
