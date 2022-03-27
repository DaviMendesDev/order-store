<?php

namespace App\Models\Utils\Discount;

use App\Models\Utils\Model\FieldNullification;
use Illuminate\Database\Eloquent\Model;

abstract class Discountable extends Model implements DiscountableInterface
{
    use FieldNullification;

    public abstract function totalAmountWithoutDiscount (): float;

    public function totalAmountWithDiscount (): float {
        return $this->totalAmountWithoutDiscount() - $this->discountedValue();
    }
}
