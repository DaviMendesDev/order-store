<?php

namespace App\Models;

use App\Endpoints\FirstEndpoint;
use App\Endpoints\SecondEndpoint;
use App\Endpoints\ThirdEndpoint;
use App\Models\Utils\Discount\Discountable;
use App\Models\Utils\Endpoint\Dispatchable;
use App\Models\Utils\Model\FieldNullification;
use App\Utils\Aggregator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Order extends Discountable
{
    use HasFactory;
    use FieldNullification;
    use Dispatchable;

    protected $table = 'order';

    protected $fillable = [
        'code',
    ];

    protected array $dispatchEndpoints = [
        FirstEndpoint::class,
        SecondEndpoint::class,
        ThirdEndpoint::class,
    ];

    public function products (): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(OrderProduct::class);
    }

    public function jobs (): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(PendingDispatchesJob::class);
    }

    /**
     * @throws Utils\Model\ModelException
     */
    public function generateCode (): self {
        $this->throwsIfNull('id');

        $this->code = Carbon::now()->format('Y-m') . '-' . $this->id;
        return $this;
    }

    public function save(array $options = []): bool {
        parent::save($options);

        $this->generateCode();

        return parent::save($options);
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
