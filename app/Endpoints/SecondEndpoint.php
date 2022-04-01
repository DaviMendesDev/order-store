<?php

namespace App\Endpoints;

use App\Utils\Endpoints\Endpoint;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;
use StdClass;

class SecondEndpoint extends Endpoint
{
    protected array $renameable = [
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
        $this->url = 'http://localhost/api/second-endpoint';
        parent::__construct($rawData);
    }

    protected function asyncHandle(ConnectionException|Response $response)
    {
        if ($response instanceof ConnectionException)
            Log::error('SecondEndpoint: connection exception', [ 'error_message' => $response->getMessage()]);

        if ($response instanceof Response)
            Log::info('SecondEndpoint: the request body.', [ 'response_body' => $response->body() ]);
    }
}
