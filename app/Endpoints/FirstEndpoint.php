<?php

namespace App\Endpoints;

use App\Utils\Endpoints\Endpoint;
use StdClass;

class FirstEndpoint extends Endpoint
{
    protected array $renameable = [
        'id' => 'OrderId',                                                  # id gerado automaticamente
        'code' => 'OrderCode',                                              # código no formato YYYY-MM-OrderId
        'created_at' => 'OrderDate',                                        # data do pedido no formato YYYY-MM-DD
        'totalAmountWithoutDiscount' => 'TotalAmountWithoutDiscount',       # preço total sem desconto
        'totalAmountWithDiscount' => 'TotalAmountWithDiscount',             # preço total com desconto,
    ];

    protected array $callable = [
        'totalAmountWithoutDiscount' => 'totalAmountWithoutDiscount',
        'totalAmountWithDiscount' => 'totalAmountWithDiscount',
    ];

    public function __construct($rawData)
    {
        $this->url = route('first-endpoint');
        parent::__construct($rawData);
    }
}
