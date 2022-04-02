<?php

namespace Tests\Unit\Utils;

use App\Models\Order;
use App\Models\OrderProduct;

class DiscountableTest extends Order
{
    private array $products = [];

    public function __construct(array $products)
    {
        $this->products = $products;
        parent::__construct();
    }

    public function totalAmountWithoutDiscount(): float {
        return collect($this->products)->reduce(function (float|null $result, OrderProduct $product) {
            return (float) ($result ?? 0) + $product->totalAmountWithoutDiscount();
        });
    }

    public function hasDiscount(): bool {
        return collect($this->products)->reduce(function (float|null $result, OrderProduct $product) {
            return (float) ($result ?? 0) + $product->hasDiscount();
        });
    }

    public function discountedValue(): float {
        return collect($this->products)->reduce(function (float|null $result, OrderProduct $product) {
            return (float) ($result ?? 0) + $product->discountedValue();
        });
    }
}
