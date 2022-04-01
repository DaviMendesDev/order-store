<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Utils\Aggregator;
use Illuminate\Http\Request;

class OrdersController extends BaseController
{
    public function list (): \Illuminate\Http\JsonResponse
    {
        return $this->success('all orders.', Order::all());
    }

    public function store (CreateOrderRequest $req): \Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $validated = $req->validated();
        $ordersResults = [];

        return $this->runOrFail(function () use ($validated, &$ordersResults) {
            $aggregatedProducts = Aggregator::agregateBy('article_code', $validated['orders']);
            collect($aggregatedProducts)->each(function ($products) use (&$ordersResults) {
                $newOrder = new Order();
                $newOrder->save();
                $newOrder->products()->createMany($products);
                $newOrder->jobs()->create([]);
                $ordersResults[] = $newOrder->toArray();
            });
        }, 'order saved successfully.', $ordersResults);
    }
}
