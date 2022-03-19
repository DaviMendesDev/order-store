<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
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

        return $this->runOrFail(function () use ($validated) {
            $newOrder = new Order($validated);

            $newOrder->save();
        }, 'order saved successfully.');
    }

    public function update (Request $req, Order $order) {
        // TODO: update an existing order
    }
}
