<?php

namespace App\Models;

use App\Models\Utils\Discount\Discountable;
use App\Models\Utils\Discount\OrderDiscountConstants;
use App\Models\Utils\Model\ModelException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Discountable
{
    use HasFactory;

    protected $table = 'order_products';

    protected $fillable = [
        'article_code',
        'article_name',
        'unit_price',
        'quantity',
    ];

    public function order (): \Illuminate\Database\Eloquent\Relations\BelongsTo {
        return $this->belongsTo(Order::class);
    }

    public static function minQuantityForDiscount (): int {
        return OrderDiscountConstants::MIN_QUANTITY;
    }

    public static function maxQuantityForDiscount (): int {
        return OrderDiscountConstants::MAX_QUANTITY;
    }

    public static function maxAmountForDiscount (): int {
        return OrderDiscountConstants::MAX_AMOUNT;
    }

    public static function discountPercentage(): float {
        return OrderDiscountConstants::PERCENTAGE;
    }

    /**
     * @throws ModelException
     */
    public function hasDiscount(): bool
    {
        $this->throwsIfNull('quantity');

        return $this->quantity >= self::minQuantityForDiscount()
            && $this->quantity <= self::maxQuantityForDiscount()
            && $this->totalAmountWithoutDiscount() > self::maxAmountForDiscount();
    }

    /**
     * @throws ModelException
     */
    public function discountedValue(): float
    {
        $this->throwsIfNull('quantity', 'unit_price');

        return ($this->totalAmountWithoutDiscount() / 100) * self::discountPercentage();
    }

    /**
     * The total amount, the 'brute' amount without any additional tax or discount.
     * @throws ModelException
     *
     * Throws a ModelException if 'quantity' or 'unit_price' is null
     */
    public function totalAmountWithoutDiscount (): float {
        $this->throwsIfNull('quantity', 'unit_price');

        return (float) $this->quantity * $this->unit_price;
    }
}
