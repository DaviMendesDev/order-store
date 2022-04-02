<?php

namespace Tests\Unit;

use App\Endpoints\FirstEndpoint;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Utils\Aggregator;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Utils\DiscountableTest;

class OrderTest extends TestCase
{
    private array $rawData = [
        [
            'article_code' => '11111',
            'article_name' => 'Any Product Name',
            'unit_price' => '30.00',
            'quantity' => '6',
        ],
        [
            'article_code' => '22222',
            'article_name' => 'Any Product Name',
            'unit_price' => '90.00',
            'quantity' => '8',
        ],
    ];

    private array $alteredData = [
        [
            'ARTICLE_CODE' => '11111',
            'ARTICLE_NAME' => 'Any Product Name',
            'UNIT_PRICE' => '30.00',
            'QUANTITY' => '6',
        ],
        [
            'ARTICLE_CODE' => '22222',
            'ARTICLE_NAME' => 'Any Product Name',
            'UNIT_PRICE' => '90.00',
            'QUANTITY' => '8',
        ],
    ];

    private array $products = [];

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        $this->products = [ new OrderProduct($this->rawData[0]), new OrderProduct($this->rawData[1]), ];
        parent::__construct($name, $data, $dataName);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_rename_array_keys_with_dot_notation()
    {
        $renamedData = Aggregator::rename([
            '*.article_code' => '*.' . strtoupper('article_code'),
            '*.article_name' => '*.' . strtoupper('article_name'),
            '*.unit_price' => '*.' . strtoupper('unit_price'),
            '*.quantity' => '*.' . strtoupper('quantity'),
        ], $this->rawData);

        $this->assertTrue($renamedData == $this->alteredData);
    }

    public function test_discounted_value() {
        $ficOrder = new DiscountableTest(products: $this->products);

        $this->assertTrue($ficOrder->discountedValue() == 108);
    }

    public function test_total_amount_without_discount_value () {
        $ficOrder = new DiscountableTest(products: $this->products);

        $this->assertTrue($ficOrder->totalAmountWithoutDiscount() == 900);
    }

    public function test_total_amount_with_discount_value () {
        $ficOrder = new DiscountableTest(products: $this->products);

        $this->assertTrue($ficOrder->totalAmountWithDiscount() == 792);
    }
}
