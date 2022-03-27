<?php

namespace App\Endpoints;

use App\Utils\Endpoints\Endpoint;

class ThirdEndpoint extends Endpoint
{
    protected array $renameable = [
        'id' => 'id',                                              # id gerado automaticamente
        'code' => 'code',                                          # código no formato YYYY-MM-OrderId
        'created_at' => 'date',                                    # data do pedido no formato YYYY-MM-DD
        'totalAmountWithoutDiscount' => 'totalAmount',             # preço total sem desconto
        'totalAmountWithDiscount' => 'totalAmountWithDiscount'     # preço total com desconto
    ];

    protected array $callable = [
        'totalAmountWithoutDiscount' => 'totalAmountWithoutDiscount',
        'totalAmountWithDiscount' => 'totalAmountWithoutDiscount',
    ];

    public function __construct($rawData)
    {
        $this->url = route('third-endpoint');
        parent::__construct($rawData);
    }
}
