<?php

namespace App\Endpoints;

use App\Utils\Endpoints\Endpoint;
use StdClass;

class SecondEndpoint extends Endpoint
{
    protected array $renameable = [
        'id' => 'id',                                   # id gerado automaticamente
        'code' => 'code',                               # código no formato YYYY-MM-OrderId
        'created_at' => 'date',                         # data do pedido no formato YYYY-MM-DD
        'totalAmountWithoutDiscount' => 'total',        # preço total sem desconto
        'discountedValue' => 'discount'                 # desconto
    ];

    protected array $callable = [
        'totalAmountWithoutDiscount' => 'totalAmountWithoutDiscount',
        'discountedValue' => 'discountedValue',
    ];

    public function __construct($rawData)
    {
        $this->url = route('second-endpoint');
        parent::__construct($rawData);
    }
}
