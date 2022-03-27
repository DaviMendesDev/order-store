<?php

namespace App\Models\Utils\Discount;

interface DiscountableInterface
{
    public function hasDiscount(): bool;
    public function discountedValue(): float;
}
