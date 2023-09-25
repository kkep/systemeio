<?php

namespace App\Service;

class PurchaseService
{
    public function getClass(string $name)
    {
        return '\\Systemeio\\TestForCandidates\\PaymentProcessor\\'
            . ucwords($name) . 'PaymentProcessor';
    }
}
