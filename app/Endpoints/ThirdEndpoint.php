<?php

namespace App\Endpoints;

use App\Utils\Endpoints\Endpoint;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class ThirdEndpoint extends Endpoint
{
    protected array $renameable = [
        'created_at' => 'date',                                    # data do pedido no formato YYYY-MM-DD
        'totalAmountWithoutDiscount' => 'totalAmount',             # preço total sem desconto
    ];

    protected array $callable = [
        'totalAmountWithoutDiscount' => 'totalAmountWithoutDiscount',
        'totalAmountWithDiscount' => 'totalAmountWithoutDiscount',
    ];

    public function __construct($rawData)
    {
        $this->url = 'http://localhost/api/third-endpoint';
        parent::__construct($rawData);
    }

    protected function asyncHandle(ConnectionException|Response $response)
    {
        if ($response instanceof ConnectionException)
            Log::error('ThirdEndpoint: connection exception', [ 'error_message' => $response->getMessage()]);

        if ($response instanceof Response)
            Log::info('ThirdEndpoint: the request body.', [ 'response_body' => $response->body() ]);
    }
}
