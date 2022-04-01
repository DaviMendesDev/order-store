<?php

namespace App\Endpoints;

use App\Utils\Endpoints\Endpoint;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;
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
        $this->url = 'http://localhost/api/first-endpoint';
        parent::__construct($rawData);
    }

    protected function asyncHandle(ConnectionException|Response $response)
    {
        if ($response instanceof ConnectionException)
            Log::error('FirstEndpoint: connection exception', [ 'error_message' => $response->getMessage()]);

        if ($response instanceof Response)
            Log::info('FirstEndpoint: the request body.', [ 'response_body' => $response->body() ]);
    }
}
